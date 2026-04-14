@extends('layouts.app')
@section('title', 'Edit Roles')
@section('header', 'Edit Roles')
@section('subtitle', 'Edit Roles')
@section('content')
<style>
/* LIGHT MODE */
.select2-container--default .select2-selection--single {
    background-color: #ffffff;
    border: 1px solid #cbd5e1;
    height: 50px;
    border-radius: 12px;
}

.select2-selection__rendered {
    color: #1e293b !important;
    line-height: 50px !important;
}

.select2-selection__arrow {
    height: 50px !important;
}

.select2-dropdown {
    background-color: #ffffff;
    border: 1px solid #cbd5e1;
    color: #1e293b;
}

/* DARK MODE */
.dark .select2-container--default .select2-selection--single {
    background-color: #1e293b;
    border: 1px solid #334155;
}

.dark .select2-selection__rendered {
    color: #ffffff !important;
}

.dark .select2-dropdown {
    background-color: #1e293b;
    border: 1px solid #334155;
    color: #ffffff;
}
</style>

    <div class="px-4 space-y-6 pb-8">

        {{-- Info Banner --}}
        <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 border border-amber-500/30 rounded-2xl p-4">
            <div class="flex items-start space-x-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-amber-400 mb-1">Edit Roles: {{ $role->name}}</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Update the Roles information below. Fields marked with
                        <span class="text-red-400">*</span> are required.
                    </p>
                </div>
            </div>
        </div>

        {{-- Form --}}
            <form method="POST" action="{{ route('updateroles', request()->route('hash')) }}">
            @csrf
            @method('PUT')
            {{-- Vendor Name --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-300 mb-2 flex items-center space-x-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Role Name</span>
                    <span class="text-red-400">*</span>
                </label>
                <input type="text" id="name" name="name" readonly
                    placeholder="Example: Admin"
                    class="w-full px-4 py-3.5 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                     value="{{ old('name', $role->name) }}">
                @error('name')
                    <p class="mt-2 text-sm text-red-400 flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>
            <div>
    <!-- Label utama (jangan di dalam loop) -->
    <label class="block text-sm font-semibold text-slate-300 mb-3 flex items-center space-x-2">
        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        <span>Permissions</span>
        <span class="text-red-400">*</span>
    </label>

    <!-- List permissions -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
        @foreach($permissions as $permission)
            <label for="permission-{{ $permission->id }}" class="flex items-center space-x-2 text-sm text-slate-300">
                
                <input type="checkbox"
                    id="permission-{{ $permission->id }}"
                    name="permissions[]"
                    value="{{ $permission->id }}"
                    class="rounded border-slate-600 bg-slate-800 text-amber-500 focus:ring-amber-500"
                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                >

                <span>{{ $permission->name }}</span>
            </label>
        @endforeach
    </div>

    @error('permissions')
        <p class="mt-2 text-sm text-red-400 flex items-center space-x-1">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>

            {{-- Email --}}
            

            {{-- Action Buttons --}}
            <div class="flex space-x-3 pt-4">
                <a href="{{ route('roles') }}"
                    class="flex-1 py-3.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 font-semibold rounded-xl transition-all duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back</span>
                </a>

                <button type="submit"
                    class="flex-1 py-3.5 bg-gradient-to-r from-amber-500 to-orange-500
                           hover:from-amber-600 hover:to-orange-600
                           text-white font-semibold rounded-xl
                           shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50
                           transition-all duration-300
                           hover:scale-[1.02] active:scale-[0.98]
                           flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Update Request Type</span>
                </button>
            </div>

        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: "3000"
        };
        @if (session('success'))
            toastr.success(@json(session('success')));
        @endif
        @if (session('error'))
            toastr.error(@json(session('error')));
        @endif
    </script>
@endsection