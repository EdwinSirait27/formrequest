<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title', 'Form Request')</title>
    <link rel="icon" type="image/png"
        href="{{ asset('img/AsianBay logomark.ico') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @vite('resources/css/app.css')
    <meta name="theme-color" content="#0F172A" id="theme-color-meta">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --bg-primary: #F8FAFC;
            --bg-secondary: #F1F5F9;
            --bg-card: #FFFFFF;
            --bg-hover: #E2E8F0;
            --border-color: #E2E8F0;
            --text-primary: #0F172A;
            --text-secondary: #64748B;
            --text-muted: #94A3B8;
            --sidebar-bg: #FFFFFF;
            --header-bg: rgba(255, 255, 255, 0.85);
            --toggle-bg: #E2E8F0;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        html.dark {
            --bg-primary: #0F172A;
            --bg-secondary: #020617;
            --bg-card: #1E293B;
            --bg-hover: #1E293B;
            --border-color: #1E293B;
            --text-primary: #F1F5F9;
            --text-secondary: #94A3B8;
            --text-muted: #64748B;
            --sidebar-bg: #0F172A;
            --header-bg: rgba(15, 23, 42, 0.85);
            --toggle-bg: #1E293B;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
        }

        html,
        body {
            background-color: var(--bg-primary) !important;
            color: var(--text-primary) !important;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        aside {
            transition: transform 0.3s ease-in-out;
        }

        aside.sidebar-hidden {
            transform: translateX(-100%);
        }

        aside .sidebar-inner {
            background-color: var(--sidebar-bg) !important;
            border-color: var(--border-color) !important;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .main-wrapper {
            transition: padding-left 0.3s ease-in-out;
        }

        .main-wrapper.sidebar-hidden {
            padding-left: 0 !important;
        }

        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 60;
            transition: left 0.3s ease-in-out;
        }

        .sidebar-toggle.sidebar-hidden {
            left: 20px;
        }

        .sidebar-toggle:not(.sidebar-hidden) {
            left: 280px;
        }

        @media (max-width: 1024px) {
            .sidebar-toggle {
                display: none;
            }
        }

        .theme-toggle-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background-color: var(--toggle-bg);
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.2s ease;
            overflow: hidden;
        }

        .theme-toggle-btn:hover {
            transform: scale(1.08);
        }

        .theme-toggle-btn svg {
            width: 20px;
            height: 20px;
            transition: opacity 0.3s ease, transform 0.4s ease;
            position: absolute;
        }

        .icon-sun {
            color: #FBBF24;
            opacity: 0;
            transform: rotate(-90deg) scale(0.8);
        }

        html.dark .icon-sun {
            opacity: 1;
            transform: rotate(0deg) scale(1);
        }

        .icon-moon {
            color: #6366F1;
            opacity: 1;
            transform: rotate(0deg) scale(1);
        }

        html.dark .icon-moon {
            opacity: 0;
            transform: rotate(90deg) scale(0.8);
        }

        .nav-item-default {
            color: var(--text-secondary);
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .nav-item-default:hover {
            background-color: var(--bg-hover);
            color: var(--text-primary);
        }

        .nav-sub-item {
            color: var(--text-muted);
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .nav-sub-item:hover {
            background-color: var(--bg-hover);
            color: var(--text-primary);
        }

        .nav-sub-item-active {
            background-color: var(--bg-hover);
            color: var(--text-primary);
        }

        header {
            background-color: var(--header-bg) !important;
            border-color: var(--border-color) !important;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .user-info-box {
            background-color: var(--bg-hover);
            transition: background-color 0.3s ease;
        }

        html:not(.dark) .bg-slate-950 {
            background-color: var(--bg-secondary) !important;
        }

        html:not(.dark) .bg-slate-900 {
            background-color: var(--bg-primary) !important;
        }

        html:not(.dark) .text-slate-400 {
            color: var(--text-secondary) !important;
        }

        html:not(.dark) .text-slate-300 {
            color: var(--text-primary) !important;
        }

        html:not(.dark) .border-slate-800 {
            border-color: var(--border-color) !important;
        }

        html:not(.dark) .bg-slate-800 {
            background-color: var(--bg-hover) !important;
        }

        html:not(.dark) .hover\:bg-slate-800:hover {
            background-color: var(--bg-hover) !important;
        }

        html:not(.dark) .bg-slate-700 {
            background-color: #CBD5E1 !important;
        }
    </style>
</head>

<body class="bg-slate-950 text-gray-100 transition-colors duration-300" x-data="{ sidebarOpen: true }" x-init="// Restore saved theme on load
if (localStorage.getItem('theme') === 'light') {
    document.documentElement.classList.remove('dark');
} else {
    document.documentElement.classList.add('dark');
}">
    <button @click="sidebarOpen = !sidebarOpen" :class="{ 'sidebar-hidden': !sidebarOpen }"
        class="sidebar-toggle hidden lg:flex items-center justify-center w-10 h-10 bg-slate-800 hover:bg-slate-700 rounded-lg shadow-lg border border-slate-700 transition-all group">
        <svg x-show="sidebarOpen" class="w-5 h-5 text-slate-300 group-hover:text-white transition-colors" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
        </svg>
        <svg x-show="!sidebarOpen" class="w-5 h-5 text-slate-300 group-hover:text-white transition-colors"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
        </svg>
    </button>
    <aside :class="{ 'sidebar-hidden': !sidebarOpen }"
        class="hidden lg:fixed lg:inset-y-0 lg:left-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <div
            class="sidebar-inner flex grow flex-col gap-y-5 overflow-y-auto bg-slate-900 border-r border-slate-800 px-6 pb-4">
            {{-- <div class="flex h-24 shrink-0 items-center border-b border-slate-800">
                <img src="{{ asset('img/AsianBay.png') }}"
                    class="h-16 w-16 select-none pointer-events-none hidden dark:block" draggable="false"
                    alt="icon">

                <img src="{{ asset('img/AsianBaylogo.png') }}"
                    class="h-16 w-16 select-none pointer-events-none block dark:hidden" draggable="false"
                    alt="icon">
                <div class="ml-3">
                    <h2 class="text-base font-bold text-slate-400 font-medium">Form Request</h2>
                    <p class="text-xs text-slate-400 font-medium">Information System</p>
                </div>
            </div> --}}
            <div class="flex items-center gap-3 h-24 border-b border-slate-800">

    <img src="{{ asset('img/AsianBay.png') }}"
        class="hidden dark:block h-16 w-auto">

    <img src="{{ asset('img/AsianBaylogo.png') }}"
        class="block dark:hidden h-16 w-auto">

    <div>
        <h2 class="text-base font-bold text-slate-400">Form Request</h2>
        <p class="text-xs text-slate-400">Information System</p>
    </div>

</div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
                            <li>
                                <a href="{{ route('profile') }}"
                                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all
                                          {{ request()->routeIs('profile')
                                              ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-md'
                                              : 'nav-item-default' }}">
                                    <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profile
                                </a>

                                <a href="{{ route('dashboard') }}"
                                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all
                                          {{ request()->routeIs('dashboard')
                                              ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-md'
                                              : 'nav-item-default' }}">
                                    <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Dashboard
                                </a>
                            </li>
                            @role('admin')
                             <a href="{{ route('vendor') }}"
                                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all
                                          {{ request()->routeIs('vendor')
                                              ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-md'
                                              : 'nav-item-default' }}">
                                    <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Vendor
                                </a>
                            </li>
                             <a href="{{ route('requesttype') }}"
                                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all
                                          {{ request()->routeIs('requesttype')
                                              ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-md'
                                              : 'nav-item-default' }}">
                                    <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Request Type
                                </a>
                            </li>
                                <li x-data="{ open: {{ request()->routeIs('users.*') ? 'true' : 'false' }} }">
                                    <button @click="open = !open"
                                        class="w-full group flex items-center justify-between gap-x-3 rounded-lg p-3 text-sm font-semibold transition-all duration-300
                                                   {{ request()->routeIs('users.*')
                                                       ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-md'
                                                       : 'nav-item-default' }}">
                                        <div class="flex items-center gap-x-3">
                                            <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Users
                                        </div>
                                        <svg class="h-4 w-4 transition-transform duration-300"
                                            :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                    <ul x-show="open" x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 -translate-y-2"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 -translate-y-2"
                                        class="mt-1 space-y-1 pl-12 overflow-hidden">
                                        <li>
                                            <a href="{{ route('users') }}"
                                                class="block rounded-md px-3 py-2 text-sm transition
                                                      {{ request()->routeIs('users.*') ? 'nav-sub-item-active' : 'nav-sub-item' }}">
                                                List Users
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('users') }}"
                                                class="block rounded-md px-3 py-2 text-sm transition
                                                      {{ request()->routeIs('users.*') ? 'nav-sub-item-active' : 'nav-sub-item' }}">
                                                Roles & Permissions
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endrole
                        </ul>
                    </li>

                    <!-- Settings section -->
                    <li>
                        <div class="text-xs font-semibold leading-6 text-slate-400 uppercase tracking-wider mb-2">
                            Settings
                        </div>
                        <ul role="list" class="-mx-2 space-y-1">
                            <li>
                                <a href=""
                                    class="group flex gap-x-3 rounded-lg p-3 text-sm leading-6 font-semibold transition-all nav-item-default">
                                    <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                    </svg>
                                    About
                                </a>
                            </li>
                        </ul>
                    </li>

                    @auth
                        <li class="mt-auto">
                            <div class="user-info-box flex items-center justify-between p-3 bg-slate-800 rounded-lg">
                                <div class="flex items-center gap-x-3 min-w-0">
                                    <div class="min-w-0 flex-1">
                                        @role('admin')
                                            <p class="text-sm font-semibold truncate" style="color: var(--text-primary)">
                                                {{ Auth::user()->employee->employee_name ?? ' +62 812-3456-9999' }}
                                            </p>
                                            <p class="text-xs truncate" style="color: var(--text-secondary)">
                                                {{ Auth::user()->roles->first()->name ?? '+62 812-3456-9999' }}
                                            </p>
                                        @endrole
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </aside>
    <div :class="{ 'sidebar-hidden': !sidebarOpen }" class="main-wrapper lg:pl-72">
        <div
            class="max-w-md lg:max-w-none mx-auto min-h-screen flex flex-col bg-slate-900 lg:bg-slate-950 shadow-2xl lg:shadow-none transition-colors duration-300">
            <header
                class="sticky top-0 z-40 bg-slate-900 lg:backdrop-blur-sm lg:bg-slate-900/80 border-b border-slate-800 transition-colors duration-300">
                <div class="px-4 sm:px-6 lg:px-8 py-4 lg:py-6">
                    <div class="flex items-center justify-between mb-4 lg:hidden">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('img/AsianBay.png') }}"
                                class="w-16 h-16 select-none pointer-events-none" draggable="false" alt="icon">
                            <div>
                                <h2 class="text-sm font-bold text-white">@yield('company', 'System')</h2>
                                <p class="text-xs text-slate-400 font-medium">Form Request</p>
                            </div>
                        </div>
                        <button onclick="toggleTheme()" class="theme-toggle-btn" title="Toggle theme">
                            <svg class="icon-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                            </svg>
                            <svg class="icon-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3 lg:space-x-4">
                            <div
                                class="hidden lg:block h-10 w-1 bg-gradient-to-b from-blue-500 to-cyan-500 rounded-full">
                            </div>
                            <div class="lg:hidden h-6 w-1 bg-gradient-to-b from-blue-500 to-cyan-500 rounded-full">
                            </div>
                            <div>
                                <h1 class="text-lg sm:text-xl lg:text-3xl font-bold"
                                    style="color: var(--text-primary)">
                                    @yield('header', 'Dashboard')
                                </h1>
                                <p class="text-xs sm:text-sm lg:text-base mt-0.5"
                                    style="color: var(--text-secondary)">
                                    @yield('subtitle', 'Manage your Form Request')
                                </p>
                            </div>
                        </div>
                        @auth
                            <div class="hidden lg:flex items-center space-x-3">
                                <button onclick="toggleTheme()" class="theme-toggle-btn"
                                    title="Toggle dark / light mode">
                                    <svg class="icon-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                                    </svg>
                                    <svg class="icon-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                    </svg>
                                </button>
                                <form action="{{ route('logout.post') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-red-500 to-rose-500 text-white rounded-xl font-semibold shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40 transition-all text-sm">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </header>
            <main class="flex-1 pb-28 lg:pb-8 pt-6 lg:pt-8 px-4 sm:px-6 lg:px-8">
                @yield('content')
            </main>
            <footer class="mt-auto mb-24 lg:mb-0" style="background-color: var(--bg-primary)">
                <div class="px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
                    <div class="mt-6 pt-6 border-t" style="border-color: var(--border-color)">
                        <div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
                            <p class="text-xs" style="color: var(--text-muted)">
                                © {{ date('Y') }} Form Request. Created by Edwin Sirait
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
            <div class="lg:hidden">
                @include('components.bottom-nav')
            </div>
        </div>
    </div>
    <div class="hidden lg:block fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div
            class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-900/10 rounded-full filter blur-3xl transition-colors">
        </div>
        <div
            class="absolute bottom-0 left-72 w-[600px] h-[600px] bg-cyan-900/10 rounded-full filter blur-3xl transition-colors">
        </div>
    </div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   <script>
        (function() {
            const saved = localStorage.getItem('theme');
            if (saved === 'light') {
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
    </script>
    @stack('scripts')
</body>

</html>
