<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\KnowledgeArticle;
use App\Models\Post;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->take(3)->get();

        return view('pages.home', compact('posts'));
    }

    public function services(): View
    {
        return view('pages.services', ['services' => $this->serviceCatalog()]);
    }

    public function serviceShow(string $slug): View
    {
        $services = $this->serviceCatalog();
        abort_unless(isset($services[$slug]), 404);

        return view('services.show', [
            'slug' => $slug,
            'service' => $services[$slug],
            'services' => $services,
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::query()->create($data);

        return back()->with('success', 'Thanks! ScaleForge Metals will follow up within one business day.');
    }

    public function blog(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function blogShow(string $slug): View
    {
        $post = Post::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function knowledge(): View
    {
        $articles = KnowledgeArticle::query()->where('is_published', true)->orderBy('category')->orderBy('title')->get()->groupBy('category');

        return view('kb.index', compact('articles'));
    }

    public function knowledgeShow(string $slug): View
    {
        $article = KnowledgeArticle::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('kb.show', compact('article'));
    }

    public function chat(Request $request, AiService $ai)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'session_id' => ['nullable', 'string', 'max:80'],
        ]);

        $result = $ai->chat($data['message'], $data['session_id'] ?? null);

        return response()->json($result);
    }

    /** @return array<string, array<string, string>> */
    protected function serviceCatalog(): array
    {
        return [
            'ferrous-scrap' => [
                'title' => 'Ferrous Scrap Buying',
                'summary' => 'HMS, plate & structural, rebar, cast iron, and mixed steel loads graded on our certified scale.',
                'body' => 'Northeast Ohio factories and demo crews generate steel every week. ScaleForge grades ferrous by HMS prep, plate & structural, cast, and mixed, then prints gross/tare/net tickets so settlements match what rolled across the scale. Bring clean, sorted loads when you can — prep pays.',
                'image' => 'https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?auto=format&fit=crop&w=1600&q=80',
            ],
            'non-ferrous-metals' => [
                'title' => 'Non-Ferrous Metals',
                'summary' => 'Copper, brass, aluminum, stainless, and specialty alloys with posted grade explanations.',
                'body' => 'Bare bright, #1 and #2 copper, yellow brass, aluminum extrusions, cast, and stainless are graded separately. We explain deductions for attachments, insulation, or contamination before you leave the scale house — honest calls beat surprise checks.',
                'image' => 'https://images.unsplash.com/photo-1611273426858-450d8e3c9fce?auto=format&fit=crop&w=1600&q=80',
            ],
            'wire-and-cable' => [
                'title' => 'Wire & Cable',
                'summary' => 'Insulated copper wire, aluminum cable, and communications scrap with prep guidance.',
                'body' => 'Wire grades swing hard with insulation and recovery. We sort ICW, aluminum cable, and mixed communication wire, then advise when stripping pays versus selling insulated. Industrial reels and contractor pulls get scheduled dock times so your crew is not waiting in the public lane.',
                'image' => 'https://images.unsplash.com/photo-1473341302250-a10b1cb1b1dc?auto=format&fit=crop&w=1600&q=80',
            ],
            'auto-scrap' => [
                'title' => 'Auto Scrap & Catalytic',
                'summary' => 'Auto bodies, radiators, batteries, and catalytic converters with lawful ID and paperwork.',
                'body' => 'We buy eligible auto scrap streams including radiators, batteries, and catalytic converters when Ohio ID and ownership rules are met. Catalytic units are logged with serials and seller details for compliance — no shortcuts that put the yard or the seller at risk.',
                'image' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=1600&q=80',
            ],
            'roll-off-containers' => [
                'title' => 'Roll-Off Containers',
                'summary' => 'Jobsite bins for demolition, remodel, and contractor scrap streams.',
                'body' => 'Need a bin on a Cleveland remodel or teardown? We stage roll-offs sized for metal-heavy loads, schedule swaps, and weigh material back at the yard. Contaminated mixed debris may be refused or re-rated — call before you fill if you are unsure what belongs in a metal container.',
                'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1600&q=80',
            ],
            'industrial-accounts' => [
                'title' => 'Industrial Accounts',
                'summary' => 'Recurring plant pickup, gaylords, and settlement reporting for manufacturers.',
                'body' => 'Machine shops, fabricators, and stamping plants get dedicated routes, gaylord programs, and monthly settlement summaries from our ERP. We coordinate dock access, grade mixed turnings correctly, and keep environmental paperwork ready for your audits.',
                'image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?auto=format&fit=crop&w=1600&q=80',
            ],
        ];
    }
}

