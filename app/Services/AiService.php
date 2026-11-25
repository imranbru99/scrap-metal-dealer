<?php

namespace App\Services;

use App\Models\ChatLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiService
{
    /** @var array<int, array{q: string, a: string}> */
    protected array $faq = [
        [
            'q' => 'price cost how much estimate quote board copper aluminum',
            'a' => 'ForgeHarbor posts a daily board for ferrous and non-ferrous. Copper and aluminum move with the market — call (414) 555-0188 or WhatsApp for today\'s payout before you load the truck.',
        ],
        [
            'q' => 'schedule appointment book pickup container when available',
            'a' => 'Yard hours Mon–Sat. Book pickups and roll-off drops via the contact form, phone, or WhatsApp. Industrial routes run Milwaukee, Racine, Kenosha, and Waukesha on standing schedules.',
        ],
        [
            'q' => 'ferrous steel hms cast shred structural',
            'a' => 'We buy HMS #1/#2, plate and structural, cast iron, and shredded steel. Keep dirt, concrete, and closed containers out of the load for cleaner grades and faster scale tickets.',
        ],
        [
            'q' => 'non ferrous copper brass aluminum stainless wire',
            'a' => 'Separate #1 copper, #2 copper, aluminum extrusions/cans, brass, and stainless before arrival. Clean grades pay better — insulation and steel attachments knock material into a lower bucket.',
        ],
        [
            'q' => 'catalytic converter cat serial id license',
            'a' => 'Converters are purchased only from legitimate sellers with ID and documentation. Serials are logged in our ERP. We will not buy undocumented converters.',
        ],
        [
            'q' => 'container roll off gaylord drop swap',
            'a' => 'We deliver 10–40 yard roll-offs and gaylords for scrap staging. Tell us ferrous vs mixed vs segregated non-ferrous so we place the right box and schedule swaps without blocking your dock.',
        ],
        [
            'q' => 'hours open yard location milwaukee wisconsin',
            'a' => 'ForgeHarbor Metals serves Milwaukee and southeast Wisconsin. Call (414) 555-0188 for today\'s hours, scale queue status, and industrial pickup windows.',
        ],
        [
            'q' => 'payment payout check cash ticket invoice',
            'a' => 'Walk-up loads are ticketed at the scale. Industrial accounts can invoice through the ERP with payment history. Keep your ticket — it is the record of grade, weight, and payout.',
        ],
    ];

    public function chat(string $message, ?string $sessionId = null): array
    {
        $reply = null;
        $source = 'demo';

        if ($key = config('services.openai.key')) {
            try {
                $reply = $this->callOpenAi($message, $key);
                $source = 'openai';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply && ($gemini = config('services.gemini.key'))) {
            try {
                $reply = $this->callGemini($message, $gemini);
                $source = 'gemini';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply) {
            $reply = $this->demoReply($message);
            $source = 'demo';
        }

        ChatLog::query()->create([
            'session_id' => $sessionId,
            'message' => $message,
            'reply' => $reply,
            'source' => $source,
        ]);

        return ['reply' => $reply, 'source' => $source];
    }

    public function generate(string $type, string $prompt): string
    {
        $message = match ($type) {
            'blog' => "Write a concise SEO blog post outline and intro for a scrap metal dealer about: {$prompt}",
            'description' => "Write a compelling product/service description for scrap metal buying or recycling: {$prompt}",
            'automation' => "Suggest 5 practical AI automations for a scrap yard ERP related to: {$prompt}",
            'troubleshoot' => "Troubleshoot this scrap yard / metal recycling operations issue with clear steps: {$prompt}",
            default => $prompt,
        };

        $result = $this->chat($message);

        return $result['reply'];
    }

    protected function demoReply(string $message): string
    {
        $hay = Str::lower($message);
        $best = null;
        $bestScore = 0;

        foreach ($this->faq as $item) {
            $score = 0;
            foreach (explode(' ', $item['q']) as $word) {
                if ($word !== '' && str_contains($hay, $word)) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $item['a'];
            }
        }

        if ($best && $bestScore > 0) {
            return $best;
        }

        return 'Thanks for reaching ForgeHarbor Metals. We buy ferrous and non-ferrous scrap, catalytic converters, and industrial loads across Milwaukee and southeast Wisconsin. Ask about prices, containers, grading, or booking — or call (414) 555-0188.';
    }

    protected function callOpenAi(string $message, string $key): string
    {
        $response = Http::withToken($key)
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config('services.openai.model', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are the ForgeHarbor Metals assistant for a Milwaukee, WI scrap metal dealer SME (ferrous/non-ferrous buying, catalytic converters, roll-offs, industrial pickups). Be concise and practical. Never encourage illegal scrap sales. Require ID/docs for converters.',
                    ],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.4,
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'choices.0.message.content', 'Unable to generate a response.');
    }

    protected function callGemini(string $message, string $key): string
    {
        $model = config('services.gemini.model', 'gemini-1.5-flash');
        $response = Http::timeout(30)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "You are ForgeHarbor Metals assistant (Milwaukee scrap metal dealer). Answer briefly:\n{$message}"],
                        ],
                    ],
                ],
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'candidates.0.content.parts.0.text', 'Unable to generate a response.');
    }
}
