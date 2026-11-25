<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ForgeHarbor Metals') — Milwaukee Scrap Metal Dealer</title>
    <meta name="description" content="@yield('meta_description', 'ForgeHarbor Metals buys ferrous and non-ferrous scrap, pays competitive scale prices, and runs industrial scrap contracts across Milwaukee and southeast Wisconsin.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Teko:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0a1628;
            --accent: #c9a227;
            --accent-deep: #a8841a;
            --harbor: #1a6b8a;
            --muted: #5a6b7c;
            --surface: #e4ebf0;
            --panel: #f1f5f8;
            --white: #ffffff;
            --font-display: "Teko", sans-serif;
            --font-body: "Outfit", sans-serif;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: var(--font-body);
            color: var(--ink);
            background:
                radial-gradient(1000px 480px at 100% -8%, rgba(201,162,39,.16), transparent 55%),
                radial-gradient(860px 440px at -10% 20%, rgba(26,107,138,.14), transparent 50%),
                linear-gradient(180deg, #edf2f6 0%, var(--surface) 48%, #cfd9e3 100%);
            min-height: 100vh;
        }
        a { color: inherit; text-decoration: none; }
        .wrap { width: min(1120px, calc(100% - 2rem)); margin-inline: auto; }
        .site-header {
            position: sticky; top: 0; z-index: 40;
            backdrop-filter: blur(12px);
            background: rgba(10,22,40,.94);
            border-bottom: 1px solid rgba(201,162,39,.25);
        }
        .nav {
            display: flex; align-items: center; justify-content: space-between;
            padding: .9rem 0; gap: 1rem;
        }
        .brand {
            font-family: var(--font-display);
            letter-spacing: .06em;
            font-size: 1.65rem;
            color: #fff;
            text-transform: uppercase;
            line-height: 1;
        }
        .brand span { color: var(--accent); }
        .nav-links { display: flex; flex-wrap: wrap; gap: .9rem 1.1rem; align-items: center; }
        .nav-links a { color: rgba(255,255,255,.82); font-size: .9rem; font-weight: 500; }
        .nav-links a:hover { color: #fff; }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: .4rem; padding: .75rem 1.2rem; border-radius: .2rem;
            font-weight: 700; border: 0; cursor: pointer;
            transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background: var(--accent); color: var(--ink); box-shadow: 0 10px 24px rgba(201,162,39,.3); }
        .btn-primary:hover { background: var(--accent-deep); color: #fff; }
        .btn-ghost { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.28); }
        .btn-dark { background: var(--ink); color: #fff; }
        .hero {
            min-height: calc(100vh - 64px);
            display: grid;
            align-items: end;
            position: relative;
            overflow: hidden;
            color: #fff;
            background:
                linear-gradient(115deg, rgba(10,22,40,.92) 0%, rgba(10,22,40,.55) 48%, rgba(10,22,40,.28) 100%),
                url('https://images.unsplash.com/photo-1611273426858-450d8e3c9fce?auto=format&fit=crop&w=2000&q=80') center/cover no-repeat;
        }
        .hero-inner { padding: 5.5rem 0 4rem; max-width: 640px; animation: rise .8s ease both; }
        .hero h1 {
            font-family: var(--font-display);
            font-size: clamp(3rem, 8vw, 5rem);
            line-height: .9;
            text-transform: uppercase;
            margin: 0 0 1rem;
            letter-spacing: .03em;
        }
        .hero p { font-size: 1.05rem; line-height: 1.6; color: rgba(255,255,255,.88); margin: 0 0 1.5rem; max-width: 34rem; }
        .hero-ctas { display: flex; flex-wrap: wrap; gap: .75rem; }
        .section { padding: 4.5rem 0; }
        .section h2 {
            font-family: var(--font-display);
            font-size: clamp(2.1rem, 4.5vw, 3rem);
            text-transform: uppercase;
            letter-spacing: .04em;
            margin: 0 0 .75rem;
        }
        .lede { color: var(--muted); max-width: 40rem; line-height: 1.6; margin: 0 0 2rem; }
        .grid-3 { display: grid; gap: 1.25rem; grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-2 { display: grid; gap: 1.5rem; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .service-tile {
            position: relative; overflow: hidden; min-height: 260px; color: #fff;
            isolation: isolate;
        }
        .service-tile img {
            position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2;
            transition: transform .6s ease;
        }
        .service-tile:hover img { transform: scale(1.06); }
        .service-tile::after {
            content: ""; position: absolute; inset: 0; z-index: -1;
            background: linear-gradient(180deg, rgba(10,22,40,.12), rgba(10,22,40,.9));
        }
        .service-tile .pad { position: absolute; left: 0; right: 0; bottom: 0; padding: 1.25rem; }
        .service-tile h3 { margin: 0 0 .35rem; font-family: var(--font-display); text-transform: uppercase; letter-spacing: .05em; font-size: 1.45rem; }
        .service-tile p { margin: 0; color: rgba(255,255,255,.85); font-size: .92rem; }
        .panel {
            background: rgba(255,255,255,.76);
            border: 1px solid rgba(10,22,40,.06);
            padding: 1.4rem;
        }
        .panel h3 { margin: 0 0 .5rem; font-family: var(--font-display); text-transform: uppercase; letter-spacing: .05em; font-size: 1.35rem; }
        .dash-preview {
            display: grid; gap: 1rem; grid-template-columns: 1.2fr .8fr;
            background: var(--ink); color: #fff; padding: 1.5rem; overflow: hidden;
        }
        .metric { padding: 1rem; background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08); }
        .metric strong { display: block; font-size: 1.7rem; color: var(--accent); font-family: var(--font-display); }
        .bars { display: flex; align-items: end; gap: .45rem; height: 140px; margin-top: 1rem; }
        .bars span {
            flex: 1; border-radius: 2px 2px 0 0;
            background: linear-gradient(180deg, var(--accent), var(--harbor));
            animation: grow .9s ease both;
        }
        form.stack { display: grid; gap: .85rem; }
        label { font-weight: 600; font-size: .9rem; }
        input, textarea, select {
            width: 100%; padding: .8rem .9rem; border: 1px solid rgba(10,22,40,.14);
            background: #fff; font: inherit; border-radius: .2rem;
        }
        .flash {
            background: rgba(26,107,138,.12); border: 1px solid rgba(26,107,138,.35);
            color: #0f4a60; padding: .9rem 1rem; margin-bottom: 1rem;
        }
        .site-footer {
            background: var(--ink); color: rgba(255,255,255,.78); padding: 2.5rem 0;
            margin-top: 2rem;
        }
        .site-footer .brand { margin-bottom: .5rem; }
        .wa-float {
            position: fixed; right: 1.1rem; bottom: 1.1rem; z-index: 50;
            width: 56px; height: 56px; border-radius: 999px;
            display: grid; place-items: center;
            background: #25d366; color: #fff; font-weight: 800;
            box-shadow: 0 12px 28px rgba(0,0,0,.25);
            animation: pulse 2.4s ease infinite;
        }
        .chat-widget {
            position: fixed; left: 1.1rem; bottom: 1.1rem; z-index: 50; width: min(360px, calc(100vw - 2rem));
        }
        .chat-toggle {
            background: var(--ink); color: #fff; border: 0; padding: .8rem 1rem;
            font-weight: 700; cursor: pointer; width: 100%;
        }
        .chat-panel {
            display: none; background: #fff; border: 1px solid rgba(10,22,40,.1);
            box-shadow: 0 18px 40px rgba(10,22,40,.18); overflow: hidden;
        }
        .chat-panel.open { display: block; animation: rise .25s ease; }
        .chat-log { height: 240px; overflow: auto; padding: .9rem; background: var(--panel); }
        .bubble { margin: .4rem 0; padding: .65rem .75rem; border-radius: .4rem; max-width: 90%; font-size: .9rem; line-height: 1.4; }
        .bubble.bot { background: #fff; border: 1px solid rgba(10,22,40,.08); }
        .bubble.user { background: var(--ink); color: #fff; margin-left: auto; }
        .chat-form { display: flex; gap: .4rem; padding: .65rem; }
        .chat-form input { flex: 1; }
        @keyframes rise { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: none; } }
        @keyframes grow { from { transform: scaleY(.2); transform-origin: bottom; } to { transform: scaleY(1); } }
        @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.05); } }
        @media (max-width: 900px) {
            .grid-3, .grid-2, .dash-preview { grid-template-columns: 1fr; }
            .nav-links { display: none; }
            .hero { min-height: 78vh; }
        }
    </style>
    @stack('head')
</head>
<body>
<header class="site-header">
    <div class="wrap nav">
        <a class="brand" href="{{ route('home') }}">Forge<span>Harbor</span></a>
        <nav class="nav-links">
            <a href="{{ route('services') }}">Services</a>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('blog') }}">Blog</a>
            <a href="{{ route('knowledge') }}">Knowledge</a>
            <a href="{{ route('contact') }}">Contact</a>
            <a class="btn btn-primary" href="{{ route('contact') }}">Get a Scale Quote</a>
        </nav>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="site-footer">
    <div class="wrap">
        <div class="brand">Forge<span>Harbor</span> Metals</div>
        <p>Milwaukee · Racine · Kenosha · SE Wisconsin scrap buying, industrial contracts &amp; container pickup.</p>
        <p style="margin-top:1rem;font-size:.9rem;">(414) 555-0188 · hello@forgeharbormetals.com · <a href="/admin" style="color:var(--accent)">Admin ERP</a></p>
    </div>
</footer>

<a class="wa-float" href="https://wa.me/14145550188" target="_blank" rel="noopener" aria-label="WhatsApp">WA</a>

<div class="chat-widget" id="fh-chat">
    <div class="chat-panel" id="chat-panel">
        <div class="chat-log" id="chat-log">
            <div class="bubble bot">Hi — ask ForgeHarbor about copper prices, ferrous grades, catalytic converters, industrial scrap contracts, or container pickup in Milwaukee.</div>
        </div>
        <form class="chat-form" id="chat-form">
            <input type="text" id="chat-input" placeholder="Ask about scrap buying…" required maxlength="2000">
            <button class="btn btn-primary" type="submit">Send</button>
        </form>
    </div>
    <button class="chat-toggle" type="button" id="chat-toggle">AI Scrap Yard Assistant</button>
</div>

<script>
(() => {
    const panel = document.getElementById('chat-panel');
    const toggle = document.getElementById('chat-toggle');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const log = document.getElementById('chat-log');
    const sessionId = 'fh-' + Math.random().toString(36).slice(2);
    toggle.addEventListener('click', () => panel.classList.toggle('open'));
    const add = (text, who) => {
        const el = document.createElement('div');
        el.className = 'bubble ' + who;
        el.textContent = text;
        log.appendChild(el);
        log.scrollTop = log.scrollHeight;
    };
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;
        add(message, 'user');
        input.value = '';
        try {
            const res = await fetch(@json(route('ai.chat')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message, session_id: sessionId }),
            });
            const data = await res.json();
            add(data.reply || 'Something went wrong.', 'bot');
        } catch (err) {
            add('Network error — please try again or call (414) 555-0188.', 'bot');
        }
    });
})();
</script>
@stack('scripts')
</body>
</html>
