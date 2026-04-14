<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>403 — Forbidden · Form Request</title>
    <link rel="icon" type="image/png" href="{{ asset('img/AsianBay logomark.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <meta name="theme-color" content="#0e0e10" id="theme-color-meta">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --bg:        #0e0e10;
            --surface:   #17171a;
            --border:    rgba(255,255,255,0.07);
            --border-hi: rgba(255,255,255,0.14);
            --text:      #e8e8ec;
            --muted:     #6b6b75;
            --accent:    #4f8ef7;
            --accent-lo: rgba(79,142,247,0.12);
            --error:     #f87171;
            --error-lo:  rgba(248,113,113,0.10);
            --label:     #9191a0;
            --input-bg:  #111114;
            --amber:     #fbbf24;
            --amber-lo:  rgba(251,191,36,0.08);
        }
        html:not(.dark) {
            --bg:        #f7f4ef;
            --surface:   #ffffff;
            --border:    rgba(0,0,0,0.08);
            --border-hi: rgba(0,0,0,0.15);
            --text:      #1a1a1e;
            --muted:     #8a8a96;
            --accent:    #2563eb;
            --accent-lo: rgba(37,99,235,0.08);
            --error:     #dc2626;
            --error-lo:  rgba(220,38,38,0.08);
            --label:     #6b6b78;
            --input-bg:  #f0ece4;
            --amber:     #b45309;
            --amber-lo:  rgba(180,83,9,0.08);
        }

        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            transition: background 0.4s, color 0.4s;
        }
        .serif { font-family: 'Instrument Serif', Georgia, serif; }
        .mono  { font-family: 'DM Mono', monospace; }

        /* ── Layout ── */
        .shell {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }
        @media (max-width: 900px) {
            .shell { grid-template-columns: 1fr; }
            .left-panel { display: none; }
        }

        /* ── Left panel ── */
        .left-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            overflow: hidden;
            background: #0b0c0f;
        }
        html:not(.dark) .left-panel { background: #1c2333; }

        /* Noise texture */
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
            background-size: 200px 200px;
            opacity: 0.4;
            pointer-events: none;
        }

        /* Error stripe — merah, beda dari login yang biru */
        .left-stripe {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #f87171 0%, #fca5a5 50%, transparent 100%);
        }

        /* Big decorative number */
        .left-bg-num {
            position: absolute;
            bottom: -30px;
            right: -16px;
            font-family: 'Instrument Serif', serif;
            font-size: clamp(160px, 20vw, 260px);
            line-height: 1;
            color: rgba(248,113,113,0.05);
            user-select: none;
            pointer-events: none;
            letter-spacing: -0.04em;
        }

        /* Logo */
        .left-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 2;
        }
        .left-logo img {
            width: 36px;
            height: 36px;
            filter: brightness(0) invert(1);
            opacity: 0.9;
        }
        .left-logo-text {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
        }

        /* Content */
        .left-content {
            position: relative;
            z-index: 2;
        }
        .left-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--error);
            margin-bottom: 14px;
        }

        /* Badge HTTP 500 */
        .error-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--error-lo);
            border: 1px solid rgba(248,113,113,0.18);
            border-radius: 6px;
            padding: 6px 14px;
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            color: var(--error);
            letter-spacing: 0.04em;
            margin-bottom: 22px;
        }
        .badge-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--error);
            animation: pulse 1.8s ease-in-out infinite;
            flex-shrink: 0;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.25; }
        }

        .left-headline {
            font-family: 'Instrument Serif', serif;
            font-size: clamp(32px, 4vw, 48px);
            line-height: 1.08;
            color: #ffffff;
            margin: 0 0 18px;
            font-weight: 400;
        }
        .left-headline em {
            font-style: italic;
            color: rgba(255,255,255,0.4);
        }
        .left-desc {
            font-size: 13px;
            line-height: 1.7;
            color: rgba(255,255,255,0.32);
            max-width: 300px;
        }

        .left-footer {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            color: rgba(255,255,255,0.18);
            letter-spacing: 0.08em;
            position: relative;
            z-index: 2;
        }

        /* ── Right panel ── */
        .right-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px 24px;
            background: var(--bg);
            position: relative;
            transition: background 0.4s;
        }

        html:not(.dark) .right-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='400' height='400' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
            background-size: 200px 200px;
            pointer-events: none;
        }

        /* Theme toggle */
        .theme-btn {
            position: absolute;
            top: 20px; right: 20px;
            width: 38px; height: 38px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--muted);
            transition: border-color 0.2s, color 0.2s, transform 0.15s;
            z-index: 10;
        }
        .theme-btn:hover { border-color: var(--border-hi); color: var(--text); transform: scale(1.05); }
        .icon-sun  { display: none; }
        .icon-moon { display: block; }
        html:not(.dark) .icon-sun  { display: block; }
        html:not(.dark) .icon-moon { display: none; }

        /* Card */
        .card {
            width: 100%;
            max-width: 400px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 36px 36px 32px;
            box-shadow: 0 1px 0 var(--border-hi), 0 20px 60px rgba(0,0,0,0.3);
            position: relative;
            animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
            transition: background 0.4s, border-color 0.4s;
        }
        html:not(.dark) .card {
            box-shadow: 0 1px 0 rgba(255,255,255,0.8), 0 4px 24px rgba(0,0,0,0.07);
        }

        /* Top accent — error merah */
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 24px; right: 24px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--error), transparent);
            opacity: 0.4;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Mobile brand */
        .mobile-brand {
            display: none;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
        }
        @media (max-width: 900px) { .mobile-brand { display: flex; } }
        .mobile-brand img { width: 32px; height: 32px; }
        .mobile-brand-name { font-size: 15px; font-weight: 600; color: var(--text); }

        /* Card header */
        .card-header { margin-bottom: 24px; }
        .card-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--error);
            margin-bottom: 8px;
        }
        .card-title {
            font-family: 'Instrument Serif', serif;
            font-size: 26px;
            font-weight: 400;
            line-height: 1.1;
            color: var(--text);
            margin: 0 0 6px;
        }
        .card-sub {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* Info blocks */
        .info-block {
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 10px;
            transition: background 0.4s, border-color 0.4s;
        }
        .info-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .info-icon {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .info-icon.red   { background: var(--error-lo); }
        .info-icon.blue  { background: var(--accent-lo); }
        .info-icon.amber { background: var(--amber-lo); }
        .info-icon svg   { width: 14px; height: 14px; }
        .info-icon.red   svg { color: var(--error); }
        .info-icon.blue  svg { color: var(--accent); }
        .info-icon.amber svg { color: var(--amber); }

        .info-label {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.10em;
            text-transform: uppercase;
            color: var(--label);
            margin-bottom: 3px;
        }
        .info-value {
            font-size: 12.5px;
            color: var(--text);
            line-height: 1.55;
        }

        /* Incident tag */
        .incident-tag {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--amber-lo);
            border: 1px solid rgba(251,191,36,0.15);
            border-radius: 5px;
            padding: 3px 8px;
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            color: var(--amber);
            letter-spacing: 0.05em;
            margin-top: 5px;
        }
        html:not(.dark) .incident-tag {
            border-color: rgba(180,83,9,0.15);
        }

        /* Divider */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 22px 0;
        }

        /* Buttons */
        .btn-row {
            display: flex;
            gap: 8px;
        }
        .btn-primary {
            flex: 1;
            padding: 11px 16px;
            border-radius: 10px;
            border: none;
            background: var(--accent);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 2px 12px rgba(79,142,247,0.35);
            text-decoration: none;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 20px rgba(79,142,247,0.45); opacity: 0.9; }
        .btn-primary:active { transform: translateY(0); }

        .btn-secondary {
            padding: 11px 16px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--muted);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            transition: border-color 0.2s, color 0.2s;
            white-space: nowrap;
            text-decoration: none;
        }
        .btn-secondary:hover { border-color: var(--border-hi); color: var(--text); }

        /* Page footer */
        .page-footer {
            margin-top: 24px;
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.06em;
            color: var(--muted);
            opacity: 0.4;
            animation: slideUp 0.7s 0.2s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
    </style>
</head>

<body>
<div class="shell">

    {{-- ── LEFT PANEL ── --}}
    <div class="left-panel">
        <div class="left-stripe"></div>
        {{-- <div class="left-bg-num">404</div> --}}

        <div class="left-logo">
            <img src="{{ asset('img/AsianBay.png') }}" alt="Logo">
            <span class="left-logo-text">Form Request</span>
        </div>

        <div class="left-content">
            <p class="left-eyebrow">Forbidden</p>

            <div class="error-badge">
                <span class="badge-dot"></span>
                403
            </div>

            <h1 class="left-headline">
                Forbidden<br>Not<br><em>Allowed.</em>
            </h1>
            <p class="left-desc">
               why do you see this page.
            </p>
        </div>

        <div class="left-footer">
            © {{ date('Y') }} · Form Request Developed by Edwin Sirait
        </div>
    </div>

    {{-- ── RIGHT PANEL ── --}}
    <div class="right-panel">

        {{-- Theme toggle --}}
        <button class="theme-btn" onclick="toggleTheme()" title="Ganti tema">
            <svg class="icon-sun" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
            </svg>
            <svg class="icon-moon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>

        <div class="card">

            {{-- Mobile brand --}}
            <div class="mobile-brand">
                <img src="{{ asset('img/AsianBay.png') }}" alt="Logo">
                <div>
                    <div class="mobile-brand-name">Form Request</div>
                </div>
            </div>

            {{-- Header --}}
            <div class="card-header">
                <p class="card-eyebrow">What Happend?</p>
                <h2 class="card-title">Forbidden Not Allowed</h2>
                <p class="card-sub">The page you're looking for doesn't belong's to you.</p>
            </div>

            {{-- Status --}}
            <div class="info-block">
                <div class="info-row">
                    <div class="info-icon red">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="info-label">Status</p>
                        <p class="info-value">Forbidden Not Allowed</p>
                        {{-- <span class="incident-tag">Sedang ditangani</span> --}}
                    </div>
                </div>
            </div>

            {{-- Langkah berikutnya --}}
            <div class="info-block">
                <div class="info-row">
                    <div class="info-icon blue">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="info-label">Next Step</p>
                        <p class="info-value">Contact administrator.</p>
                    </div>
                </div>
            </div>

            {{-- Kontak --}}
            <div class="info-block">
                <div class="info-row">
                    <div class="info-icon amber">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="info-label">Heed help ASAP?</p>
                        <p class="info-value">
    <a href="https://tix.asianbay.co.id"
       target="_blank"
       rel="noopener noreferrer"
       class="text-blue-400 hover:underline">
        IT Ticketing
    </a>
</p>
</p>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            {{-- Actions --}}
            <div class="btn-row">
                <a href="javascript:history.back()" class="btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Try Again
                </a>
                @auth
    <a href="{{ route('dashboard') }}" class="btn-secondary">
@else
    <a href="{{ route('login') }}" class="btn-secondary">
@endauth
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>
            </div>
        </div>

        <p class="page-footer">© {{ date('Y') }} · Form Request Developed by Edwin Sirait</p>
    </div>

</div>

<script>
    (function () {
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    })();

    function toggleTheme() {
        const html = document.documentElement;
        const dark = html.classList.toggle('dark');
        localStorage.setItem('theme', dark ? 'dark' : 'light');
        document.getElementById('theme-color-meta')
            .setAttribute('content', dark ? '#0e0e10' : '#f7f4ef');
    }
</script>
</body>
</html>