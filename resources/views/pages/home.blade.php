@extends('layouts.app')

@section('title', 'ForgeHarbor Metals')
@section('meta_description', 'Milwaukee scrap metal dealer buying steel, copper, aluminum, brass, and industrial scrap with certified scale tickets and container pickup.')

@section('content')
<section class="hero">
    <div class="wrap hero-inner">
        <h1>ForgeHarbor<br>Metals</h1>
        <p>Honest scale tickets, competitive non-ferrous payouts, and industrial scrap contracts that keep Milwaukee shops and demolition crews paid same-day.</p>
        <div class="hero-ctas">
            <a class="btn btn-primary" href="{{ route('contact') }}">Check today’s prices</a>
            <a class="btn btn-ghost" href="{{ route('services') }}">Explore yard services</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <h2>What we buy &amp; haul</h2>
        <p class="lede">From driveway copper drops to mill-bound HMS — ForgeHarbor grades, weighs, and settles scrap with certified scales and clear tickets.</p>
        <div class="grid-3">
            @foreach([
                ['ferrous-scrap','Ferrous Scrap Buying','HMS, plate & structural, rebar, and mixed steel paid by the ton.','https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?auto=format&fit=crop&w=1200&q=80'],
                ['non-ferrous-metals','Non-Ferrous Metals','Copper, aluminum, brass, and stainless sorted for top-tier payouts.','https://images.unsplash.com/photo-1581092162384-8987c1d64718?auto=format&fit=crop&w=1200&q=80'],
                ['industrial-scrap-contracts','Industrial Scrap Contracts','Scheduled pickup for fabs, machine shops, and demolition sites.','https://images.unsplash.com/photo-1587293852726-70cdb56c2866?auto=format&fit=crop&w=1200&q=80'],
            ] as [$slug,$title,$blurb,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad">
                        <h3>{{ $title }}</h3>
                        <p>{{ $blurb }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Why ForgeHarbor</h2>
        <p class="lede">Southeast Wisconsin’s scrap yard that treats every load like a commercial account — graded right, weighed right, paid right.</p>
        <div class="grid-3">
            <div class="panel">
                <h3>Certified scale</h3>
                <p>NTEP-ready tickets with photos and material grades so your books match what left the dock.</p>
            </div>
            <div class="panel">
                <h3>Container logistics</h3>
                <p>Roll-off and gaylord staging for shops that generate scrap every week — swaps on your schedule.</p>
            </div>
            <div class="panel">
                <h3>ERP-run yard</h3>
                <p>Buy tickets, inventory lots, invoices, and customer accounts live in one operations stack.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Ops dashboard preview</h2>
        <p class="lede">A glimpse of the ForgeHarbor ERP used to track buy tickets, scrap inventory lots, and commercial settlements.</p>
        <div class="dash-preview">
            <div>
                <div class="grid-3" style="grid-template-columns:repeat(3,1fr)">
                    <div class="metric"><strong>62</strong> Open tickets</div>
                    <div class="metric"><strong>$241k</strong> Month buys</div>
                    <div class="metric"><strong>380t</strong> Yard stock</div>
                </div>
                <div class="bars">
                    <span style="height:42%"></span><span style="height:68%"></span><span style="height:58%"></span>
                    <span style="height:88%"></span><span style="height:64%"></span><span style="height:95%"></span>
                    <span style="height:72%"></span>
                </div>
            </div>
            <div>
                <h3 style="font-family:var(--font-display);text-transform:uppercase;margin-top:0;font-size:1.5rem">Live modules</h3>
                <ul style="line-height:1.9;padding-left:1.1rem;color:rgba(255,255,255,.86)">
                    <li>Buy tickets &amp; grading</li>
                    <li>Scrap lot inventory</li>
                    <li>Invoices &amp; payouts</li>
                    <li>AI content + troubleshooting</li>
                </ul>
                <a class="btn btn-primary" style="margin-top:1rem" href="/admin">Open admin ERP</a>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>From the scale house</h2>
        <p class="lede">Guides for fab shops, demo crews, and homeowners sorting copper from contamination.</p>
        <div class="grid-3">
            @forelse($posts as $post)
                <a class="panel" href="{{ route('blog.show', $post->slug) }}">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                </a>
            @empty
                <div class="panel"><p>Blog posts will appear after seeding.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
