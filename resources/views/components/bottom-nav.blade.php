<nav
    class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-slate-900/95 backdrop-blur-xl border-t border-slate-800 shadow-2xl">
    <div class="grid grid-cols-5 text-xs">

        {{-- Home --}}
        <a href="{{ route('dashboard') }}" {{-- <a href="{{ route('dashboard') }}" --}}
            class="relative flex flex-col items-center py-3 transition-all duration-300 {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-slate-500 hover:text-slate-300' }}">

            @if (request()->routeIs('dashboard'))
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-12 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-b-full">
                </div>
            @endif

            <div
                class="relative {{ request()->routeIs('dashboard') ? 'scale-110' : '' }} transition-transform duration-300">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                @if (request()->routeIs('dashboard'))
                    <div class="absolute -top-1 -right-1 w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                @endif
            </div>
            <span class="font-medium">Home</span>
        </a>

        {{-- Tickets --}}
        <a href="#" {{-- <a href="{{ route('tickets.index') }}" --}}
            class="relative flex flex-col items-center py-3 transition-all duration-300 {{ request()->routeIs('tickets.*') ? 'text-blue-400' : 'text-slate-500 hover:text-slate-300' }}">

            @if (request()->routeIs('tickets.*'))
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-12 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-b-full">
                </div>
            @endif

            <div
                class="relative {{ request()->routeIs('tickets.*') ? 'scale-110' : '' }} transition-transform duration-300">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
                {{-- Badge untuk notifikasi (optional) --}}
                {{-- <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center text-[10px] text-white font-bold border-2 border-slate-900">3</div> --}}
            </div>
            <span class="font-medium">Your Tickets</span>
        </a>
        <a href="#" {{-- <a href="{{ route('tickets.index') }}" --}}
            class="relative flex flex-col items-center py-3 transition-all duration-300 {{ request()->routeIs('tickets.*') ? 'text-blue-400' : 'text-slate-500 hover:text-slate-300' }}">

            @if (request()->routeIs('tickets.*'))
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-12 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-b-full">
                </div>
            @endif

            <div
                class="relative {{ request()->routeIs('tickets.*') ? 'scale-110' : '' }} transition-transform duration-300">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
                {{-- Badge untuk notifikasi (optional) --}}
                {{-- <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center text-[10px] text-white font-bold border-2 border-slate-900">3</div> --}}
            </div>
            <span class="font-medium">All Tickets</span>
        </a>

        {{-- Create New Ticket - Featured Button --}}
        {{-- <a href="{{ route('openticket') }}"
            class="relative flex flex-col items-center py-3 transition-all duration-300 group">

            <div class="absolute -top-6 left-1/2 -translate-x-1/2">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-600 shadow-lg shadow-blue-500/50 flex items-center justify-center transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-90 group-active:scale-95">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </div>

            <span class="mt-5 font-medium text-slate-500 group-hover:text-blue-400 transition-colors">New Tickets</span>
        </a> --}}
        {{-- Profile --}}
        <a href="{{ route('profile') }}" {{-- <a href="{{ route('profile') }}" --}}
            class="relative flex flex-col items-center py-3 transition-all duration-300 {{ request()->routeIs('profile') ? 'text-blue-400' : 'text-slate-500 hover:text-slate-300' }}">
            @if (request()->routeIs('profile'))
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-12 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-b-full">
                </div>
            @endif
            <div
                class="relative {{ request()->routeIs('profile') ? 'scale-110' : '' }} transition-transform duration-300">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <span class="font-medium">Profile</span>
        </a>
    </div>
    {{-- Safe Area untuk iPhone dengan notch --}}
    <div class="h-safe-area-inset-bottom bg-slate-900"></div>
</nav>

<style>
    /* Safe area untuk iOS devices */
    .h-safe-area-inset-bottom {
        height: env(safe-area-inset-bottom);
    }
</style>
