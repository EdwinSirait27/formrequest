@extends('layouts.app')

@section('title', 'Profile')
@section('header', 'Profile')
@section('subtitle', 'Your account information')

@section('content')
<style>
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
    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Profile Card --}}
        <div class="rounded-2xl border p-6 shadow-sm transition-colors duration-300"
            style="background-color: var(--bg-card); border-color: var(--border-color);">

            {{-- Avatar & Name --}}
            <div class="flex items-center gap-5 pb-6 mb-6 border-b" style="border-color: var(--border-color);">

               
                <div
                    class="flex-shrink-0 w-16 h-16 rounded-2xl shadow-lg shadow-blue-500/30 
            flex items-center justify-center text-white font-bold text-xl bg-blue-500">

                    {{ strtoupper(
                        substr(explode(' ', Auth::user()->employee->employee_name ?? (Auth::user()->name ?? 'U'))[0], 0, 1) .
                            (isset(explode(' ', Auth::user()->employee->employee_name ?? (Auth::user()->name ?? ''))[1])
                                ? substr(explode(' ', Auth::user()->employee->employee_name ?? (Auth::user()->name ?? ''))[1], 0, 1)
                                : ''),
                    ) }}

                </div>
                <div>
                    <h2 class="text-xl font-bold" style="color: var(--text-primary)">
                        {{ Auth::user()->employee->employee_name ?? (Auth::user()->name ?? '-') }}
                    </h2>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold mt-1
                             bg-gradient-to-r from-blue-500/20 to-cyan-500/20 text-cyan-400 border border-cyan-500/30">
                        {{ Auth::user()->roles->first()->name ?? 'No Role' }}
                    </span>
                </div>
            </div>

            {{-- Info Fields --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                {{-- Username --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold  tracking-wider" style="color: var(--text-muted)">
                        Username
                    </label>
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border transition-colors"
                        style="background-color: var(--bg-secondary); border-color: var(--border-color);">
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-muted)" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium" style="color: var(--text-primary)">
                            {{ Auth::user()->username ?? '-' }}
                        </span>
                    </div>
                </div>

                {{-- Email --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold tracking-wider" style="color: var(--text-muted)">
                        Email
                    </label>
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border transition-colors"
                        style="background-color: var(--bg-secondary); border-color: var(--border-color);">
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-muted)" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-medium" style="color: var(--text-primary)">
                            {{ Auth::user()->employee->email ?? '-' }}
                        </span>
                    </div>
                </div>

                {{-- Employee Name --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold tracking-wider" style="color: var(--text-muted)">
                        Company
                    </label>
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border transition-colors"
                        style="background-color: var(--bg-secondary); border-color: var(--border-color);">
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-muted)" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm font-medium" style="color: var(--text-primary)">
                            {{ Auth::user()->employee->company->name ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold tracking-wider" style="color: var(--text-muted)">
                        Department
                    </label>
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border transition-colors"
                        style="background-color: var(--bg-secondary); border-color: var(--border-color);">
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-muted)" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm font-medium" style="color: var(--text-primary)">
                            {{ Auth::user()->employee->department->department_name ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold tracking-wider" style="color: var(--text-muted)">
                        Position
                    </label>
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border transition-colors"
                        style="background-color: var(--bg-secondary); border-color: var(--border-color);">
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-muted)" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm font-medium" style="color: var(--text-primary)">
                            {{ Auth::user()->employee->position->name ?? '-' }}
                        </span>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold tracking-wider" style="color: var(--text-muted)">
                        Employee Name
                    </label>
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border transition-colors"
                        style="background-color: var(--bg-secondary); border-color: var(--border-color);">
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-muted)" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm font-medium" style="color: var(--text-primary)">
                            {{ Auth::user()->employee->employee_name ?? '-' }}
                        </span>
                    </div>
                </div>

                {{-- Phone --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold tracking-wider" style="color: var(--text-muted)">
                        Phone Number
                    </label>
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border transition-colors"
                        style="background-color: var(--bg-secondary); border-color: var(--border-color);">
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-muted)" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-sm font-medium" style="color: var(--text-primary)">
                            {{ Auth::user()->employee->telp_number ?? '-' }}
                        </span>
                    </div>
                </div>

                {{-- Department --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold tracking-wider" style="color: var(--text-muted)">
                        Company Mail
                    </label>
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border transition-colors"
                        style="background-color: var(--bg-secondary); border-color: var(--border-color);">
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-muted)" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="text-sm font-medium" style="color: var(--text-primary)">
                            {{ Auth::user()->employee->company_email ?? 'empty mail :)' }}
                        </span>
                    </div>
                </div>
                {{-- Role --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold tracking-wider" style="color: var(--text-muted)">
                        Role
                    </label>
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border transition-colors"
                        style="background-color: var(--bg-secondary); border-color: var(--border-color);">
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-muted)" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="text-sm font-medium capitalize" style="color: var(--text-primary)">
                            {{ Auth::user()->roles->first()->name ?? '-' }}
                        </span>
                    </div>
                </div>

                {{-- Member Since --}}
                <div class="space-y-1.5 sm:col-span-2">
                    <label class="text-xs font-semibold tracking-wider" style="color: var(--text-muted)">
                        Join Date
                    </label>
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border transition-colors"
                        style="background-color: var(--bg-secondary); border-color: var(--border-color);">
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-muted)" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm font-medium" style="color: var(--text-primary)">
                            {{ Auth::user()->created_at?->format('d F Y') ?? '-' }}
                        </span>
                    </div>
                </div>
                @if (count($user->all_roles_formrequest ?? []) > 1)
                <div class="space-y-1.5 sm:col-span-2">

                    <form method="POST" action="{{ route('profile.update-active-role') }}">
                        @csrf
                        <label for="active_role_formrequest" class="text-sm text-white">Select Active Role</label>
                        <select name="role" id="active_role_formrequest"
                            class="select2 mt-1 block w-full rounded-lg bg-slate-800 text-white p-2 border border-slate-700">
                            @foreach ($user->all_roles_formrequest ?? [] as $role)
                                <option value="{{ $role }}"
                                    {{ $user->active_role_formrequest == $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                            Update Active Role
                        </button>
                    </form>
                </div>

                @endif
                <div class="max-w-xl mx-auto bg-white shadow-lg rounded-2xl p-6 space-y-6">

                    <!-- Title -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">Signature</h3>
                        <p class="text-sm text-gray-500">Please create or update your signature</p>
                    </div>

                    <!-- Current Signature -->
                    @if (auth()->user()->employee->signature)
                        <div class="border rounded-xl p-4 bg-gray-50">
                            <p class="text-sm text-gray-500 mb-3">Current signature</p>
                            <div class="flex justify-center">
                                <img src="{{ asset('storage/' . auth()->user()->employee->signature) }}"
                                    class="h-24 object-contain">
                            </div>
                        </div>
                    @endif

                    <!-- Canvas -->
                    <div class="border-2 border-dashed rounded-xl p-4 bg-gray-50">
                        <p class="text-sm text-gray-500 mb-2">Draw your signature below</p>
                        <canvas id="signature-pad" class="w-full h-40 bg-white rounded-lg"></canvas>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between items-center">
                        <button type="button" onclick="clearPad()"
                            class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                            Clear
                        </button>
                        <form method="POST" action="{{ route('save.signature') }}">
                            @csrf
                            <input type="hidden" name="signature" id="signature">
                            <button type="submit" onclick="saveSignature()"
                                class="px-5 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Read-only notice --}}
        <div class="flex items-center gap-3 px-4 py-3 rounded-xl border"
            style="background-color: var(--bg-secondary); border-color: var(--border-color);">
            <svg class="w-4 h-4 flex-shrink-0 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
            </svg>
            <p class="text-xs" style="color: var(--text-muted)">
                Profile information is managed by your administrator. Contact HRD if any data is incorrect.
            </p>
        </div>

    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
        <script>
            const canvas = document.getElementById('signature-pad');

            // 🔥 fix ukuran biar tidak blur
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }
            resizeCanvas();

            const signaturePad = new SignaturePad(canvas);

            // ✅ Load signature lama ke canvas
            const existingSignature = @json(auth()->user()->employee->signature ? asset('storage/' . auth()->user()->employee->signature) : null);

            if (existingSignature) {
                const image = new Image();
                image.src = existingSignature;

                image.onload = function() {
                    const ctx = canvas.getContext("2d");
                    ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
                };
            }

            // clear
            function clearPad() {
                signaturePad.clear();
            }

            // save
            function saveSignature() {
                if (signaturePad.isEmpty()) {
                    alert("signature has not been filled in!");
                    event.preventDefault();
                    return false;
                }

                document.getElementById('signature').value = signaturePad.toDataURL();
            }
        </script>
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
              $('#active_role_formrequest').select2({
                placeholder: "Choose Roles",
                allowClear: true,
                width: '100%'
            });
        </script>
    @endpush
@endsection
