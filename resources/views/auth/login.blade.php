<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Login — Form Request</title>
    <link rel="icon" type="image/png" href="{{ asset('img/AsianBay logomark.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <meta name="theme-color" content="#0e0e10" id="theme-color-meta">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            --paper:     #f5f0e8;
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
            justify-content: flex-end;
            padding: 48px;
            overflow: hidden;
            background: #0b0c0f;
        }
        html:not(.dark) .left-panel { background: #1c2333; }

        /* Scanned photo texture feel */
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
            background-size: 200px 200px;
            opacity: 0.4;
            pointer-events: none;
        }

        /* Big editorial number */
        .left-bg-num {
            position: absolute;
            top: -40px;
            right: -20px;
            font-family: 'Instrument Serif', serif;
            font-size: clamp(180px, 22vw, 320px);
            line-height: 1;
            color: rgba(255,255,255,0.03);
            user-select: none;
            pointer-events: none;
            letter-spacing: -0.04em;
        }

        /* Diagonal accent stripe */
        .left-stripe {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4f8ef7 0%, #7dd3fc 50%, transparent 100%);
        }

        .left-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: auto;
            padding-top: 4px;
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

        .left-content {
            position: relative;
            z-index: 2;
        }
        .left-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #4f8ef7;
            margin-bottom: 16px;
        }
        .left-headline {
            font-family: 'Instrument Serif', serif;
            font-size: clamp(36px, 4vw, 56px);
            line-height: 1.08;
            color: #ffffff;
            margin: 0 0 20px;
            font-weight: 400;
        }
        .left-headline em {
            font-style: italic;
            color: rgba(255,255,255,0.55);
        }
        .left-desc {
            font-size: 13px;
            line-height: 1.7;
            color: rgba(255,255,255,0.38);
            max-width: 320px;
            margin-bottom: 36px;
        }
        .feature-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .feature-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #4f8ef7;
            flex-shrink: 0;
        }
        .feature-text {
            font-size: 12px;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0.01em;
        }
        .left-footer {
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.07);
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            color: rgba(255,255,255,0.2);
            letter-spacing: 0.08em;
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

        /* Subtle paper texture in light mode */
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

        /* Top accent line on card */
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 24px; right: 24px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
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
        .mobile-brand-sub  { font-size: 11px; color: var(--muted); }

        /* Card header */
        .card-header { margin-bottom: 28px; }
        .card-eyebrow {
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 8px;
        }
        .card-title {
            font-family: 'Instrument Serif', serif;
            font-size: 28px;
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

        /* Alert */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            background: var(--error-lo);
            border: 1px solid rgba(248,113,113,0.2);
            color: var(--error);
        }
        .alert svg { flex-shrink: 0; margin-top: 1px; }

        /* Form fields */
        .field { margin-bottom: 18px; }
        .field-label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: var(--label);
            margin-bottom: 6px;
            letter-spacing: 0.02em;
        }
        .field-wrap {
            position: relative;
        }
        .field-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px; height: 16px;
            color: var(--muted);
            pointer-events: none;
            transition: color 0.2s;
        }
        .field-wrap:focus-within .field-icon { color: var(--accent); }

        .field-input {
            width: 100%;
            padding: 11px 12px 11px 38px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--input-bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            -webkit-appearance: none;
        }
        .field-input::placeholder { color: var(--muted); opacity: 0.6; }
        .field-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-lo);
        }
        .field-input.is-error {
            border-color: var(--error);
            box-shadow: 0 0 0 3px var(--error-lo);
        }
        .field-error {
            font-size: 11.5px;
            color: var(--error);
            margin-top: 5px;
            display: block;
        }

        /* Password toggle */
        .pw-toggle {
            position: absolute;
            right: 10px;
            top: 50%; transform: translateY(-50%);
            width: 30px; height: 30px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: var(--muted);
            background: none; border: none; padding: 0;
            border-radius: 6px;
            transition: color 0.2s, background 0.2s;
        }
        .pw-toggle:hover { color: var(--text); background: var(--border); }

        /* Divider */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 24px 0;
        }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: var(--accent);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.01em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
            transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 2px 12px rgba(79,142,247,0.35);
        }
        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0);
            transition: background 0.15s;
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 20px rgba(79,142,247,0.45); }
        .btn-submit:hover::after { background: rgba(255,255,255,0.07); }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { opacity: 0.7; pointer-events: none; }

        .spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: none;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Card footer */
        .card-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: var(--muted);
            line-height: 1.6;
        }

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
        {{-- <div class="left-stripe"></div> --}}
        <div class="left-bg-num"></div>

        <div class="left-logo">
            <img src="{{ asset('img/AsianBay.png') }}" alt="Logo">
            <span class="left-logo-text">Form Request</span>
        </div>

        <div class="left-content">
            {{-- <p class="left-eyebrow">Internal System</p> --}}
            {{-- <h2 class="left-headline">
                Kelola<br>permintaan<br><em>dengan mudah.</em>
            </h2> --}}
            <p class="left-desc">
                Sistem terpusat untuk mengelola form request secara efisien — transparan, terstruktur, dan real-time.
            </p>

            <div class="feature-row">
                <span class="feature-dot"></span>
                <span class="feature-text">Manajemen Form Request</span>
            </div>
            <div class="feature-row">
                <span class="feature-dot"></span>
                <span class="feature-text">Dashboard real-time</span>
            </div>

            {{-- <div class="left-footer">
                © {{ date('Y') }} · Form Request Developed by Edwin Sirait
            </div> --}}
        </div>
    </div>

    {{-- ── RIGHT PANEL ── --}}
    <div class="right-panel">
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
                    {{-- <div class="mobile-brand-sub">Internal System</div> --}}
                </div>
            </div>

            {{-- Header --}}
            <div class="card-header">
                <p class="card-eyebrow">Selamat datang</p>
                <h1 class="card-title">Masuk ke akun</h1>
                <p class="card-sub">Gunakan kredensial akun HRX.</p>
            </div>

            {{-- Global error --}}
            @if ($errors->any() && !$errors->has('username') && !$errors->has('password'))
                <div class="alert">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke-width="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form --}}
            <form action="{{ route('login.post') }}" method="POST" id="loginForm" novalidate>
                @csrf

                {{-- Username --}}
                <div class="field">
                    <label class="field-label" for="username">Username</label>
                    <div class="field-wrap">
                        <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input class="field-input {{ $errors->has('username') ? 'is-error' : '' }}"
                               type="text"
                               id="username"
                               name="username"
                               value="{{ old('username') }}"
                               autocomplete="username"
                               placeholder="username HRX"
                               required>
                    </div>
                    @error('username')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="field">
                    <label class="field-label" for="password">Password</label>
                    <div class="field-wrap">
                        <svg class="field-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input class="field-input {{ $errors->has('password') ? 'is-error' : '' }}"
                               type="password"
                               id="password"
                               name="password"
                               autocomplete="current-password"
                               placeholder="••••••••"
                               style="padding-right: 44px;"
                               required>
                        <button type="button" class="pw-toggle" onclick="togglePassword()" title="Tampilkan password">
                            <svg id="eye-open" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-closed" style="display:none" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="divider"></div>

                <button type="submit" id="submitBtn" class="btn-submit">
                    <span class="spinner" id="btnSpinner"></span>
                    <span id="btnText">Masuk</span>
                </button>
            </form>

            <p class="card-footer">
                Belum punya akses?&nbsp; Hubungi administrator.
            </p>
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

    function togglePassword() {
        const input  = document.getElementById('password');
        const eyeOn  = document.getElementById('eye-open');
        const eyeOff = document.getElementById('eye-closed');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        eyeOn.style.display  = isHidden ? 'none'  : '';
        eyeOff.style.display = isHidden ? ''      : 'none';
    }

    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn     = document.getElementById('submitBtn');
        const spinner = document.getElementById('btnSpinner');
        const text    = document.getElementById('btnText');
        btn.disabled = true;
        spinner.style.display = 'block';
        text.textContent = 'Memproses…';
    });
</script>
</body>
</html>