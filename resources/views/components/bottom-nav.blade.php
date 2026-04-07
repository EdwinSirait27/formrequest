{{-- <nav
    class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-slate-900/95 backdrop-blur-xl border-t border-slate-800 shadow-2xl">
    <div class="grid grid-cols-5 text-xs">
@role('admin')
 <a href="{{ route('profile') }}"
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

         <a href="{{ route('users') }}"
            class="relative flex flex-col items-center py-3 transition-all duration-300 {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-slate-500 hover:text-slate-300' }}">

            @if (request()->routeIs('users'))
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-12 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-b-full">
                </div>
            @endif

            <div
                class="relative {{ request()->routeIs('users') ? 'scale-110' : '' }} transition-transform duration-300">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                @if (request()->routeIs('users'))
                    <div class="absolute -top-1 -right-1 w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                @endif
            </div>
            <span class="font-medium">Users</span>
        </a>
        <a href="{{ route('dashboard') }}"
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
         <a href="{{ route('vendor') }}"
            class="relative flex flex-col items-center py-3 transition-all duration-300 {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-slate-500 hover:text-slate-300' }}">

            @if (request()->routeIs('vendor'))
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-12 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-b-full">
                </div>
            @endif

            <div
                class="relative {{ request()->routeIs('vendor') ? 'scale-110' : '' }} transition-transform duration-300">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                @if (request()->routeIs('vendor'))
                    <div class="absolute -top-1 -right-1 w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                @endif
            </div>
            <span class="font-medium">Vendor</span>
        </a>
         <a href="{{ route('requesttype') }}" 
            class="relative flex flex-col items-center py-3 transition-all duration-300 {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-slate-500 hover:text-slate-300' }}">

            @if (request()->routeIs('requesttype'))
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-12 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-b-full">
                </div>
            @endif

            <div
                class="relative {{ request()->routeIs('requesttype') ? 'scale-110' : '' }} transition-transform duration-300">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                @if (request()->routeIs('requesttype'))
                    <div class="absolute -top-1 -right-1 w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                @endif
            </div>
            <span class="font-medium">Req-Type</span>
        </a>
         <a href="{{ route('request') }}" 
            class="relative flex flex-col items-center py-3 transition-all duration-300 {{ request()->routeIs('dashboard') ? 'text-blue-400' : 'text-slate-500 hover:text-slate-300' }}">

            @if (request()->routeIs('request'))
                <div
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-12 h-1 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-b-full">
                </div>
            @endif

            <div
                class="relative {{ request()->routeIs('requesttype') ? 'scale-110' : '' }} transition-transform duration-300">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                @if (request()->routeIs('request'))
                    <div class="absolute -top-1 -right-1 w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                @endif
            </div>
            <span class="font-medium">Req</span>
        </a>
        @endrole
    </div>
    <div class="h-safe-area-inset-bottom bg-slate-900"></div>
</nav>
<style>
    .h-safe-area-inset-bottom {
        height: env(safe-area-inset-bottom);
    }
</style> --}}
<nav class="fixed bottom-0 left-0 right-0 max-w-md mx-auto bg-slate-900/95 backdrop-blur-xl border-t border-slate-800 shadow-2xl">
    <div class="flex overflow-x-auto scrollbar-hide -webkit-overflow-scrolling-touch whitespace-nowrap px-1">
        @role('admin')

        {{-- Home --}}
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            @if(request()->routeIs('dashboard'))
                <div class="nav-bar"></div>
                <div class="nav-dot"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.75z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9"/>
            </svg>
            <span class="nav-label">Home</span>
        </a>

        {{-- Profile --}}
        <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            @if(request()->routeIs('profile'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="nav-label">Profile</span>
        </a>

        {{-- Users --}}
        <a href="{{ route('users') }}" class="nav-item {{ request()->routeIs('users') ? 'active' : '' }}">
            @if(request()->routeIs('users'))
                <div class="nav-bar"></div>
                <div class="nav-dot"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5.356-3.789M9 20H4v-2a4 4 0 015.356-3.789M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="nav-label">Users</span>
        </a>

        {{-- Vendor --}}
        <a href="{{ route('vendor') }}" class="nav-item {{ request()->routeIs('vendor') ? 'active' : '' }}">
            @if(request()->routeIs('vendor'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 100 2 1 1 0 000-2zm7 0a1 1 0 100 2 1 1 0 000-2z"/>
            </svg>
            <span class="nav-label">Vendor</span>
        </a>

        {{-- Request Type --}}
        <a href="{{ route('requesttype') }}" class="nav-item {{ request()->routeIs('requesttype') ? 'active' : '' }}">
            @if(request()->routeIs('requesttype'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 5h6M9 12h6m-6 4h4"/>
            </svg>
            <span class="nav-label">Req-Type</span>
        </a>

        {{-- Request --}}
        <a href="{{ route('request') }}" class="nav-item {{ request()->routeIs('request') ? 'active' : '' }}">
            @if(request()->routeIs('request'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
            </svg>
            <span class="nav-label">Request</span>
        </a>

        @endrole
        @role('finance')

        {{-- Home --}}
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            @if(request()->routeIs('dashboard'))
                <div class="nav-bar"></div>
                <div class="nav-dot"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.75z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9"/>
            </svg>
            <span class="nav-label">Home</span>
        </a>

        {{-- Profile --}}
        <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            @if(request()->routeIs('profile'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="nav-label">Profile</span>
        </a>

       

        {{-- Vendor --}}
        <a href="{{ route('vendor') }}" class="nav-item {{ request()->routeIs('vendor') ? 'active' : '' }}">
            @if(request()->routeIs('vendor'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h11M10 19a1 1 0 100 2 1 1 0 000-2zm7 0a1 1 0 100 2 1 1 0 000-2z"/>
            </svg>
            <span class="nav-label">Vendor</span>
        </a>

      
        {{-- Request --}}
        <a href="{{ route('request') }}" class="nav-item {{ request()->routeIs('request') ? 'active' : '' }}">
            @if(request()->routeIs('request'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
            </svg>
            <span class="nav-label">Request</span>
        </a>
        @endrole
        @role('user')

        {{-- Home --}}
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            @if(request()->routeIs('dashboard'))
                <div class="nav-bar"></div>
                <div class="nav-dot"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.75z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9"/>
            </svg>
            <span class="nav-label">Home</span>
        </a>

        {{-- Profile --}}
        <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            @if(request()->routeIs('profile'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="nav-label">Profile</span>
        </a>

       

        {{-- Vendor --}}
       
      
        {{-- Request --}}
        <a href="{{ route('request') }}" class="nav-item {{ request()->routeIs('request') ? 'active' : '' }}">
            @if(request()->routeIs('request'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
            </svg>
            <span class="nav-label">Request</span>
        </a>
        @endrole
        @role('manager')

        {{-- Home --}}
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            @if(request()->routeIs('dashboard'))
                <div class="nav-bar"></div>
                <div class="nav-dot"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.75z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9"/>
            </svg>
            <span class="nav-label">Home</span>
        </a>

        {{-- Profile --}}
        <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            @if(request()->routeIs('profile'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="nav-label">Profile</span>
        </a>

       

        {{-- Vendor --}}
       
      
        {{-- Request --}}
        <a href="{{ route('request') }}" class="nav-item {{ request()->routeIs('request') ? 'active' : '' }}">
            @if(request()->routeIs('request'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
            </svg>
            <span class="nav-label">Request</span>
        </a>
        @endrole
        @role('director')

        {{-- Home --}}
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            @if(request()->routeIs('dashboard'))
                <div class="nav-bar"></div>
                <div class="nav-dot"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.75L12 3l9 6.75V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.75z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9"/>
            </svg>
            <span class="nav-label">Home</span>
        </a>

        {{-- Profile --}}
        <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            @if(request()->routeIs('profile'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="nav-label">Profile</span>
        </a>

       

        {{-- Vendor --}}
       
      
        {{-- Request --}}
        <a href="{{ route('request') }}" class="nav-item {{ request()->routeIs('request') ? 'active' : '' }}">
            @if(request()->routeIs('request'))
                <div class="nav-bar"></div>
            @endif
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
            </svg>
            <span class="nav-label">Request</span>
        </a>
        @endrole
    </div>
    <div class="h-safe-area-inset-bottom bg-slate-900"></div>
</nav>

<style>
    .scrollbar-hide { scrollbar-width: none; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .h-safe-area-inset-bottom { height: env(safe-area-inset-bottom); }

    .nav-item {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        min-width: 64px;
        padding: 10px 14px;
        gap: 3px;
        text-decoration: none;
        color: #64748b;
        transition: color 0.2s;
    }
    .nav-item:hover { color: #94a3b8; }
    .nav-item.active { color: #60a5fa; }

    .nav-icon {
        width: 22px;
        height: 22px;
        flex-shrink: 0;
        transition: transform 0.2s;
    }
    .nav-item.active .nav-icon { transform: scale(1.1); }

    .nav-label {
        font-size: 10px;
        font-weight: 500;
        white-space: nowrap;
    }

    .nav-bar {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 32px;
        height: 3px;
        border-radius: 0 0 4px 4px;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
    }

    .nav-dot {
        position: absolute;
        top: 8px;
        right: 10px;
        width: 7px;
        height: 7px;
        background: #22c55e;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>
