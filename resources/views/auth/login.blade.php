<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Login — Form Request</title>
      <link rel="icon" type="image/png"
        href="{{ asset('img/AsianBay logomark.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
          rel="stylesheet">
    @vite('resources/css/app.css')
    <meta name="theme-color" content="#0F172A" id="theme-color-meta">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Sora', sans-serif; }
        .mono { font-family: 'JetBrains Mono', monospace; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-10px); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up      { animation: fadeUp 0.6s ease both; }
        .animate-fade-up-slow { animation: fadeUp 0.8s ease both; }

        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner { animation: spin 0.7s linear infinite; }

        .grid-overlay {
            background-image:
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        /* Theme icon transitions */
        .icon-sun  { opacity: 0; transform: rotate(-90deg) scale(0.8); transition: opacity 0.3s ease, transform 0.4s ease; }
        .icon-moon { opacity: 1; transform: rotate(0deg)  scale(1);    transition: opacity 0.3s ease, transform 0.4s ease; }
        html.dark .icon-sun  { opacity: 1; transform: rotate(0deg) scale(1); }
        html.dark .icon-moon { opacity: 0; transform: rotate(90deg) scale(0.8); }

        /* Focus-within changes icon color */
        .input-group:focus-within .input-icon { color: #38BDF8; }

        /* Button shine */
        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            border-radius: inherit;
            transition: opacity 0.2s ease;
        }
        .btn-login:hover::after { opacity: 1; }
    </style>
</head>

<body class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-300">

    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

        {{-- =============================================
             LEFT PANEL — decorative (desktop only)
        ============================================= --}}
        <div class="hidden lg:flex flex-col justify-center items-center relative overflow-hidden
                    bg-gradient-to-br from-slate-900 via-slate-800 to-sky-900">

            {{-- Light mode override --}}
            <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-sky-500 to-cyan-400 opacity-0
                        dark:opacity-0 transition-opacity duration-300 [html:not(.dark)_&]:opacity-100"></div>

            {{-- Grid overlay --}}
            <div class="grid-overlay absolute inset-0 pointer-events-none z-[1]"></div>

            {{-- Glow orbs --}}
            <div class="absolute -top-20 -left-20 w-96 h-96 rounded-full bg-sky-400/20 blur-[80px] pointer-events-none z-[1]"></div>
            <div class="absolute bottom-16 -right-16 w-72 h-72 rounded-full bg-indigo-500/15 blur-[80px] pointer-events-none z-[1]"></div>
            <div class="absolute bottom-[40%] left-[30%] w-48 h-48 rounded-full bg-cyan-500/10 blur-[80px] pointer-events-none z-[1]"></div>

            {{-- Content --}}
            <div class="relative z-10 text-center px-12 animate-fade-up-slow">
                <img src="{{ asset('img/AsianBay.png') }}"
                     class="w-24 h-24 mx-auto mb-8 drop-shadow-[0_8px_32px_rgba(56,189,248,0.4)] select-none"
                     draggable="false" alt="Logo">

                <h2 class="text-[2rem] font-bold text-white leading-tight tracking-tight mb-3">
                    Form<br>Request
                </h2>
                <p class="text-sm text-white/60 max-w-xs mx-auto leading-relaxed">
                    Sistem Form Request.
                </p>

                <div class="mono inline-block mt-8 px-5 py-2 rounded-full text-xs tracking-widest
                            text-white/75 bg-white/10 border border-white/15 backdrop-blur-sm">
                    Form Request · System
                </div>

                <div class="mt-10 flex flex-col gap-3 text-left">
                    @foreach (['Manajemen Form Request', 'Dashboard real-time'] as $feature)
                        <div class="flex items-center gap-3 text-sm text-white/70">
                            <span class="w-2 h-2 rounded-full flex-shrink-0
                                         bg-gradient-to-br from-sky-400 to-cyan-400
                                         shadow-[0_0_8px_rgba(56,189,248,0.6)]"></span>
                            {{ $feature }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- =============================================
             RIGHT PANEL — form
        ============================================= --}}
        <div class="flex flex-col justify-center items-center px-6 py-10 relative
                    bg-slate-50 dark:bg-slate-950 transition-colors duration-300">

            {{-- Theme toggle --}}
            <div class="absolute top-5 right-5 z-10">
                <button onclick="toggleTheme()"
                        title="Toggle dark / light mode"
                        class="relative flex items-center justify-center w-11 h-11 rounded-xl overflow-hidden cursor-pointer
                               bg-white dark:bg-slate-800
                               border border-slate-200 dark:border-slate-700
                               shadow-sm hover:shadow-md hover:scale-105
                               transition-all duration-200">
                    <svg class="icon-sun absolute w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                    <svg class="icon-moon absolute w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>
            </div>

            {{-- Card --}}
            <div class="w-full max-w-md animate-fade-up
                        bg-white dark:bg-slate-800
                        border border-slate-200 dark:border-slate-700
                        rounded-3xl p-8 sm:p-10
                        shadow-xl shadow-slate-200/60 dark:shadow-black/40
                        transition-colors duration-300">

                {{-- Mobile brand (hidden on desktop) --}}
                <div class="flex items-center justify-center gap-3 mb-8 lg:hidden">
                    <img src="{{ asset('img/AsianBay.png') }}" class="w-12 h-12 select-none" draggable="false" alt="Logo">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">Form Request</h2>
                        <p class="text-xs text-slate-400">Information System</p>
                    </div>
                </div>

                {{-- Card header --}}
                <div class="mb-8">
                    <p class="mono text-[0.7rem] tracking-widest uppercase text-sky-500 mb-1">Welcome back</p>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white mb-1">Masuk ke Akun</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Gunakan username, password akun HRX untuk login.
                    </p>
                </div>

                {{-- Global error --}}
                @if ($errors->any() && !$errors->has('username') && !$errors->has('password'))
                    <div class="flex items-start gap-2.5 p-3.5 mb-5 rounded-xl text-sm text-red-400
                                bg-red-500/10 border border-red-500/25">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke-width="2"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/>
                        </svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Session error --}}
                @if (session('error'))
                    <div class="flex items-start gap-2.5 p-3.5 mb-5 rounded-xl text-sm text-red-400
                                bg-red-500/10 border border-red-500/25">
                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <div class="mb-5">
                        <label for="username"
                               class="block text-xs font-semibold tracking-wide mb-1.5
                                      text-slate-600 dark:text-slate-400">
                            Username
                        </label>
                        <div class="input-group relative">
                            <svg class="input-icon absolute left-3.5 top-1/2 -translate-y-1/2 w-[18px] h-[18px]
                                        text-slate-400 pointer-events-none transition-colors duration-200"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <input type="text"
                                   id="username"
                                   name="username"
                                   value="{{ old('username') }}"
                                   autocomplete="username"
                                   placeholder="Masukkan username"
                                   required
                                   class="w-full pl-10 pr-4 py-3 rounded-xl text-sm
                                          bg-slate-50 dark:bg-slate-900
                                          text-slate-900 dark:text-slate-100
                                          placeholder-slate-400 dark:placeholder-slate-500
                                          border {{ $errors->has('username') ? 'border-red-400 ring-2 ring-red-400/20' : 'border-slate-200 dark:border-slate-600' }}
                                          focus:outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20
                                          transition-all duration-200">
                        </div>
                        @error('username')
                            <span class="block mt-1 text-xs text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-5">
                        <label for="password"
                               class="block text-xs font-semibold tracking-wide mb-1.5
                                      text-slate-600 dark:text-slate-400">
                            Password
                        </label>
                        <div class="input-group relative">
                            <svg class="input-icon absolute left-3.5 top-1/2 -translate-y-1/2 w-[18px] h-[18px]
                                        text-slate-400 pointer-events-none transition-colors duration-200"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   autocomplete="current-password"
                                   placeholder="Masukkan password"
                                   required
                                   class="w-full pl-10 pr-11 py-3 rounded-xl text-sm
                                          bg-slate-50 dark:bg-slate-900
                                          text-slate-900 dark:text-slate-100
                                          placeholder-slate-400 dark:placeholder-slate-500
                                          border {{ $errors->has('password') ? 'border-red-400 ring-2 ring-red-400/20' : 'border-slate-200 dark:border-slate-600' }}
                                          focus:outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-400/20
                                          transition-all duration-200">
                            <button type="button"
                                    onclick="togglePassword()"
                                    title="Tampilkan password"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 flex items-center
                                           text-slate-400 hover:text-slate-600 dark:hover:text-slate-200
                                           bg-transparent border-0 cursor-pointer p-0 transition-colors duration-200">
                                <svg id="eye-open" class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-closed" class="w-[18px] h-[18px] hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="block mt-1 text-xs text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Submit --}}
                    <button type="submit"
                            id="submitBtn"
                            class="btn-login relative w-full py-3.5 rounded-xl text-sm font-semibold text-white overflow-hidden
                                   bg-gradient-to-r from-blue-500 to-cyan-500
                                   shadow-lg shadow-sky-500/30
                                   hover:-translate-y-0.5 hover:shadow-xl hover:shadow-sky-500/40
                                   active:translate-y-0 active:shadow-md
                                   transition-all duration-150 cursor-pointer">
                        {{-- <span id="btnSpinner"
                              class="hidden w-[18px] h-[18px] border-2 border-white/30 border-t-white rounded-full
                                     spinner inline-block align-middle mr-2"></span> --}}
                        <span id="btnText">Masuk</span>
                    </button>
                </form>

                {{-- Card footer --}}
                <div class="mt-7 pt-6 border-t border-slate-100 dark:border-slate-700 text-center
                            text-xs text-slate-400 dark:text-slate-500 transition-colors duration-300">
                    Butuh akses? Hubungi administrator.
                </div>
            </div>

            {{-- Page footer --}}
            <p class="mt-6 text-xs text-slate-400 dark:text-slate-600 transition-colors duration-300">
                © {{ date('Y') }} Form Request · Developed by Edwin Sirait
            </p>
        </div>
    </div>

    <script>
        // Anti-flash: apply saved theme immediately
        (function () {
            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();

        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                document.getElementById('theme-color-meta').setAttribute('content', '#F8FAFC');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                document.getElementById('theme-color-meta').setAttribute('content', '#0F172A');
            }
        }

        function togglePassword() {
            const input  = document.getElementById('password');
            const eyeOn  = document.getElementById('eye-open');
            const eyeOff = document.getElementById('eye-closed');
            if (input.type === 'password') {
                input.type = 'text';
                eyeOn.classList.add('hidden');
                eyeOff.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOn.classList.remove('hidden');
                eyeOff.classList.add('hidden');
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function () {
            const btn     = document.getElementById('submitBtn');
            const spinner = document.getElementById('btnSpinner');
            const text    = document.getElementById('btnText');
            btn.disabled = true;
            btn.classList.add('opacity-80', 'pointer-events-none');
            spinner.classList.remove('hidden');
            text.textContent = 'Memproses...';
        });
    </script>

</body>
</html>