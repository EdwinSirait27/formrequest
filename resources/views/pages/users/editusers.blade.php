{{-- @extends('layouts.app')

@section('title', 'Users Management')
@section('header', 'Users')
@section('subtitle', 'Manage system users and permissions')

@section('content')

    <div class="px-4 space-y-6 pb-8">
        <div class="bg-gradient-to-r from-blue-500/10 to-cyan-500/10 border border-blue-500/30 rounded-2xl p-4">
            <div class="flex items-start space-x-3">
                <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-blue-400 mb-1">Edit Roles Users</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">for administrators only.</p>
                </div>
            </div>
        </div>
       
          <form method="POST" action="{{ route('updateusers', request()->route('hash')) }}">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-semibold text-slate-300 mb-2 flex items-center space-x-2">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                    <span>Edit for Users {{ $user->employee->employee_name }}</span>
                    <span class="text-red-400">*</span>
                </label>

            </div>
           
            <div>
                <label for="roles" class="block text-sm font-semibold text-slate-300 mb-2 flex items-center space-x-2">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <span>Roles</span>
                    <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    @foreach ($roles as $role)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}"
                                {{ in_array($role->name, $userRoles) ? 'checked' : '' }}>
                            <label class="form-check-label">
                                {{ ucfirst($role->name) }}
                            </label>
                        </div>
                    @endforeach
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">

                    </div>
                </div>
                @error('roles')
                    <p class="mt-2 text-sm text-red-400 flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <div class="flex space-x-3 pt-4">
                <a href="{{ route('users') }}"
                    class="flex-1 py-3.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 font-semibold rounded-xl transition-all duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Abort</span>
                </a>
                <button type="submit"
                    class="flex-1 py-3.5 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Update</span>
                </button>
            </div>
        </form>
    </div>

@endsection --}}
@extends('layouts.app')

@section('title', 'Edit User')
@section('header', 'Edit User')
@section('subtitle', 'Manage roles and permissions')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Info Banner --}}
    <div class="flex items-start gap-3 p-4 rounded-2xl border border-blue-500/30"
        style="background-color: var(--bg-card)">
        <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-blue-400">Edit Roles — Administrators Only</p>
            <p class="text-xs mt-0.5" style="color: var(--text-muted)">
                Changes will immediately affect the user's access across the system.
            </p>
        </div>
    </div>

    {{-- User Identity Card --}}
    <div class="rounded-2xl border p-5" style="background-color: var(--bg-card); border-color: var(--border-color)">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white font-bold text-lg bg-gradient-to-br from-blue-500 to-cyan-500 flex-shrink-0">
                {{ strtoupper(substr($user->employee->employee_name ?? $user->name ?? 'U', 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->employee->employee_name ?? $user->name ?? '')[1] ?? '', 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="font-bold text-base" style="color: var(--text-primary)">
                    {{ $user->employee->employee_name ?? $user->name ?? '-' }}
                </p>
                <p class="text-xs mt-0.5" style="color: var(--text-muted)">
                    {{ $user->username ?? '-' }}
                    @if($user->employee->company)
                        &middot; {{ $user->employee->company->name }}
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Form Request Roles Info --}}
    <div class="rounded-2xl border p-5 space-y-3" style="background-color: var(--bg-card); border-color: var(--border-color)">
        <div class="flex items-center gap-2 pb-3 border-b" style="border-color: var(--border-color)">
            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <p class="text-sm font-semibold" style="color: var(--text-primary)">
                Form Request Roles
            </p>
            @if(!empty($allRolesFormrequest))
                <span class="ml-auto text-xs px-2 py-0.5 rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">
                    {{ count($allRolesFormrequest) }} role{{ count($allRolesFormrequest) > 1 ? 's' : '' }}
                </span>
            @endif
        </div>

        @if(!empty($allRolesFormrequest))
            <div class="flex flex-wrap gap-2">
                @foreach($allRolesFormrequest as $role)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                        bg-gradient-to-r from-blue-500/20 to-cyan-500/20 text-cyan-400 border border-cyan-500/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                        {{ ucfirst($role) }}
                    </span>
                @endforeach
            </div>
        @else
            <div class="flex items-center gap-2 py-1">
                <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-muted)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 12H4"/>
                </svg>
                <p class="text-sm" style="color: var(--text-muted)">No form request roles assigned</p>
            </div>
        @endif
    </div>

    {{-- Edit Roles Form --}}
    <div class="rounded-2xl border p-5 space-y-4" style="background-color: var(--bg-card); border-color: var(--border-color)">
        <div class="flex items-center gap-2 pb-3 border-b" style="border-color: var(--border-color)">
            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <p class="text-sm font-semibold" style="color: var(--text-primary)">Assign Roles</p>
        </div>

        <form method="POST" action="{{ route('updateusers', request()->route('hash')) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-6">
                @foreach($roles as $role)
                    <label class="flex items-center gap-3 px-4 py-3 rounded-xl border cursor-pointer transition-all
                        {{ in_array($role->name, $userRoles) ? 'border-cyan-500/50 bg-cyan-500/10' : '' }}"
                        style="{{ !in_array($role->name, $userRoles) ? 'border-color: var(--border-color); background-color: var(--bg-secondary)' : '' }}">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                            {{ in_array($role->name, $userRoles) ? 'checked' : '' }}
                            class="w-4 h-4 rounded accent-cyan-500">
                        <span class="text-sm font-medium {{ in_array($role->name, $userRoles) ? 'text-cyan-400' : '' }}"
                            style="{{ !in_array($role->name, $userRoles) ? 'color: var(--text-secondary)' : '' }}">
                            {{ ucfirst($role->name) }}
                        </span>
                    </label>
                @endforeach
            </div>

            @error('roles')
                <p class="mb-4 text-sm text-red-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </p>
            @enderror

            <div class="flex gap-3">
                <a href="{{ route('users') }}"
                    class="flex-1 py-3 rounded-xl border text-sm font-semibold text-center transition-all"
                    style="background-color: var(--bg-secondary); border-color: var(--border-color); color: var(--text-secondary)">
                    Cancel
                </a>
                <button type="submit"
                    class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700
                    text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 transition-all
                    hover:scale-[1.02] active:scale-[0.98]">
                    Update Roles
                </button>
            </div>
        </form>
    </div>

</div>
@endsection