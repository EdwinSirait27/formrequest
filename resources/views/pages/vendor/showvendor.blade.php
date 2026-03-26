{{-- @extends('layouts.app')
@section('title', 'Vendor - ' . ($vendor->vendor_name ?? 'Detail'))
@section('header', 'Vendor Detail')
@section('content')

    <style>
        /* =============================================
           CSS VARIABLES - Dark & Light Theme
           ============================================= */
        :root,
        .dark {
            --bg-page:        #0f172a;
            --bg-card:        #1e293b;
            --bg-card-alt:    #0f172a;
            --bg-meta-card:   #1e293b;
            --bg-back-btn:    #334155;

            --border-card:    #334155;
            --border-green:   rgba(74, 222, 128, 0.2);
            --bg-green-band:  linear-gradient(135deg, rgba(20,83,45,0.35) 0%, rgba(6,78,59,0.35) 100%);

            --text-primary:   #f1f5f9;
            --text-secondary: #94a3b8;
            --text-meta:      #cbd5e1;
            --text-label:     #64748b;
            --text-back-btn:  #f1f5f9;

            --shadow:         0 4px 6px -1px rgba(0,0,0,0.3);
        }

        html:not(.dark) {
            --bg-page:        #f1f5f9;
            --bg-card:        #ffffff;
            --bg-card-alt:    #f8fafc;
            --bg-meta-card:   #ffffff;
            --bg-back-btn:    #e2e8f0;

            --border-card:    #e2e8f0;
            --border-green:   rgba(22, 163, 74, 0.25);
            --bg-green-band:  linear-gradient(135deg, rgba(220,252,231,0.8) 0%, rgba(187,247,208,0.6) 100%);

            --text-primary:   #0f172a;
            --text-secondary: #475569;
            --text-meta:      #334155;
            --text-label:     #94a3b8;
            --text-back-btn:  #1e293b;

            --shadow:         0 2px 8px rgba(0,0,0,0.07);
        }

        /* =============================================
           Component Styles
           ============================================= */
        .detail-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: 1rem;
            box-shadow: var(--shadow);
            padding: 1.5rem;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .detail-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            transition: color 0.3s;
        }

        .detail-subtitle {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
            transition: color 0.3s;
        }

        .transfer-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            background: linear-gradient(to right, #3b82f6, #06b6d4);
            color: white;
            white-space: nowrap;
        }

        .meta-card {
            background-color: var(--bg-meta-card);
            border: 1px solid var(--border-card);
            border-radius: 0.75rem;
            padding: 1.25rem;
            box-shadow: var(--shadow);
            transition: background-color 0.3s, border-color 0.3s;
        }

        .meta-label {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--text-label);
            transition: color 0.3s;
        }

        .meta-value {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--text-meta);
            margin-top: 0.375rem;
            word-break: break-word;
            transition: color 0.3s;
        }

        .action-band {
            background: var(--bg-green-band);
            border: 1px solid var(--border-green);
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.75rem;
            background-color: var(--bg-back-btn);
            color: var(--text-back-btn);
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            opacity: 0.85;
            transform: translateY(-1px);
        }
    </style>

    <div class="max-w-7xl mx-auto space-y-6">

        <div class="detail-card">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h2 class="detail-title">
                        {{ $vendor->vendor_name ?? 'N/A' }}
                    </h2>
                    <p class="detail-subtitle">
                        Address : {{ $vendor->address ?? 'No address provided' }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span class="transfer-badge">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        Transfer Via: {{ $vendor->transfer ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">

            <div class="meta-card">
                <p class="meta-label">Email</p>
                <p class="meta-value">{{ $vendor->email ?? 'N/A' }}</p>
            </div>

            <div class="meta-card">
                <p class="meta-label">Phone</p>
                <p class="meta-value">{{ $vendor->phone ?? 'N/A' }}</p>
            </div>

            <div class="meta-card">
                <p class="meta-label">City</p>
                <p class="meta-value">{{ $vendor->city ?? 'N/A' }}</p>
            </div>

            <div class="meta-card">
                <p class="meta-label">Province</p>
                <p class="meta-value">{{ $vendor->province ?? 'N/A' }}</p>
            </div>

            <div class="meta-card">
                <p class="meta-label">Postal Code</p>
                <p class="meta-value">{{ $vendor->postal_code ?? 'N/A' }}</p>
            </div>

            <div class="meta-card">
                <p class="meta-label">NPWP</p>
                <p class="meta-value">{{ $vendor->npwp ?? 'N/A' }}</p>
            </div>

            <div class="meta-card">
                <p class="meta-label">Bank Name</p>
                <p class="meta-value">{{ $vendor->bank_name ?? 'N/A' }}</p>
            </div>

            <div class="meta-card">
                <p class="meta-label">Bank Account Name</p>
                <p class="meta-value">{{ $vendor->bank_account_name ?? 'N/A' }}</p>
            </div>

            <div class="meta-card">
                <p class="meta-label">Bank Account Number</p>
                <p class="meta-value">{{ $vendor->bank_account_number ?? 'N/A' }}</p>
            </div>
           <div class="meta-card">
    <p class="meta-label">Status</p>
    <span class="px-3 py-1 text-sm font-semibold rounded-full
        {{ $vendor->status == 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
        {{ $vendor->status ?? 'N/A' }}
    </span>
</div>

        </div>

        <div class="action-band flex justify-left">
            <a href="{{ route('vendor') }}" class="btn-back">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Vendor
            </a>
        </div>

    </div>

@endsection --}}
@extends('layouts.app')
@section('title', 'Show Vendor - ' . $vendor->vendor_name)
@section('header', 'Show Vendor')
@section('subtitle', 'Show Vendor')
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
.form-input {
    background-color: var(--bg-card);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
}
</style>

<div class="px-4 pb-8">

    <div class="bg-gradient-to-r from-amber-500/10 to-orange-500/10 border border-amber-500/30 rounded-2xl p-4 mb-6">
        <div class="flex items-start space-x-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-amber-400 mb-1">Show Vendor: {{ $vendor->vendor_name }}</h3>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Show the vendor information below.
                </p>
            </div>
        </div>
    </div>

    {{-- Form --}}
        {{-- ── VENDOR INFO SECTION ── --}}
        <div class="space-y-4">

            {{-- Vendor Name --}}
            <div>
                <label for="vendor_name" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Vendor Name <span class="text-red-400"></span>
                </label>
                 <input type="text" class="form-input w-full px-4 py-3 rounded-xl"value="{{ old('vendor_name', $vendor->vendor_name) }}" disabled>

                @error('vendor_name')
                    <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Email
                </label>
                {{-- <input type="email" id="email" name="email"
                    placeholder="Example: blabla@company.co.id"
                    class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500
                           focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                    value="{{ old('email', $vendor->email) }}"> --}}
                 <input type="email" class="form-input w-full px-4 py-3 rounded-xl"value="{{ old('email', $vendor->email) }}" disabled>
    
                @error('email')
                    <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Phone --}}
            <div>
                <label for="phone" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Phone Number
                </label>
                {{-- <input type="text" id="phone" name="phone"
                    placeholder="08xxx"
                    class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500
                           focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                    value="{{ old('phone', $vendor->phone) }}"> --}}
                 <input type="number" class="form-input w-full px-4 py-3 rounded-xl"value="{{ old('phone', $vendor->phone) }}"disabled>

                @error('phone')
                    <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Address --}}
            <div>
                <label for="address" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Vendor Address
                </label>
                {{-- <input type="text" id="address" name="address"
                    placeholder="Jl. ..."
                    class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500
                           focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                    value="{{ old('address', $vendor->address) }}"> --}}
                 <input type="text" class="form-input w-full px-4 py-3 rounded-xl"value="{{ old('address', $vendor->address) }}"disabled>

                @error('address')
                    <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- City & Province --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="city" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        City
                    </label>
                    {{-- <input type="text" id="city" name="city"
                        placeholder="Denpasar"
                        class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500
                               focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                        value="{{ old('city', $vendor->city) }}"> --}}
                 <input type="text" class="form-input w-full px-4 py-3 rounded-xl"value="{{ old('city', $vendor->city) }}"disabled>

                    @error('city')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="province" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Province
                    </label>
                    {{-- <input type="text" id="province" name="province"
                        placeholder="Bali"
                        class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500
                               focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                        value="{{ old('province', $vendor->province) }}"> --}}
                 <input type="text" class="form-input w-full px-4 py-3 rounded-xl"value="{{ old('province', $vendor->province) }}"disabled>

                    @error('province')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Postal Code & NPWP --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="postal_code" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Postal Code
                    </label>
                    {{-- <input type="text" id="postal_code" name="postal_code"
                        placeholder="82xxx"
                        class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500
                               focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                        value="{{ old('postal_code', $vendor->postal_code) }}"> --}}
                 <input type="number" class="form-input w-full px-4 py-3 rounded-xl"value="{{ old('postal_code', $vendor->postal_code) }}"disabled>

                    @error('postal_code')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="npwp" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        NPWP <span class="text-red-400"></span>
                    </label>
                    {{-- <input type="text" id="npwp" name="npwp" required
                        placeholder="00.000.000.0-000.000"
                        class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500
                               focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                        value="{{ old('npwp', $vendor->npwp) }}"> --}}
                 <input type="number" class="form-input w-full px-4 py-3 rounded-xl"value="{{ old('npwp', $vendor->npwp) }}" disabled>
                    @error('npwp')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

        </div>

        {{-- ── BANK INFORMATION SECTION ── --}}
        <div class="flex items-center gap-3 pt-2">
            <div class="flex-1 h-px bg-slate-700"></div>
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-widest flex-shrink-0">Bank Information</span>
            <div class="flex-1 h-px bg-slate-700"></div>
        </div>

        <div class="space-y-4">

            {{-- Bank Name --}}
            <div>
                <label for="bank_name" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                    Bank Name <span class="text-red-400"></span>
                </label>
                {{-- <input type="text" id="bank_name" name="bank_name" required
                    placeholder="BCA / BNI / Mandiri ..."
                    class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500
                           focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                    value="{{ old('bank_name', $vendor->bank_name) }}"> --}}
                 <input type="text" class="form-input w-full px-4 py-3 rounded-xl"value="{{ old('bank_name', $vendor->bank_name) }}" disabled>

                @error('bank_name')
                    <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Account Name & Number --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="bank_account_name" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Bank Account Name <span class="text-red-400"></span>
                    </label>
                    {{-- <input type="text" id="bank_account_name" name="bank_account_name" required
                        placeholder="Account holder name"
                        class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500
                               focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                        value="{{ old('bank_account_name', $vendor->bank_account_name) }}"> --}}
                 <input type="text" class="form-input w-full px-4 py-3 rounded-xl"value="{{ old('bank_account_name', $vendor->bank_account_name) }}" disabled>

                    @error('bank_account_name')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="bank_account_number" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Bank Account Number <span class="text-red-400"></span>
                    </label>
                    {{-- <input type="text" id="bank_account_number" name="bank_account_number" required
                        placeholder="2283423..."
                        class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500
                               focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                        value="{{ old('bank_account_number', $vendor->bank_account_number) }}"> --}}
                 <input type="number" class="form-input w-full px-4 py-3 rounded-xl"value="{{ old('bank_account_number', $vendor->bank_account_number) }}" disabled>

                    @error('bank_account_number')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

        </div>

        {{-- ── TRANSFER SECTION ── --}}
        <div class="flex items-center gap-3 pt-2">
            <div class="flex-1 h-px bg-slate-700"></div>
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-widest flex-shrink-0">Type</span>
            <div class="flex-1 h-px bg-slate-700"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            {{-- Transfer Via --}}
            {{-- <div>
                <label for="transfer" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                    Transfer Via <span class="text-red-400"></span>
                </label>
                <div class="relative">
                    <select id="transfer" name="transfer" disabled
                        class="select2 w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white
                               focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                               transition-all duration-200 appearance-none cursor-pointer">
                        <option value="" class="bg-slate-800">Choose Transfer...</option>
                        <option value="ABD" class="bg-slate-800" {{ old('transfer', $vendor->transfer) == 'ABD' ? 'selected' : '' }}>PT. Asian Bay Development</option>
                        <option value="MJM" class="bg-slate-800" {{ old('transfer', $vendor->transfer) == 'MJM' ? 'selected' : '' }}>PT. Mahendradata Jaya Mandiri</option>
                        <option value="TNJ" class="bg-slate-800" {{ old('transfer', $vendor->transfer) == 'TNJ' ? 'selected' : '' }}>CV. Tenji Indonesia</option>
                        <option value="BIB" class="bg-slate-800" {{ old('transfer', $vendor->transfer) == 'BIB' ? 'selected' : '' }}>CV. Nuansa Bali Indah</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                @error('transfer')
                    <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div> --}}

            {{-- Vendor Type — now its own field with proper label --}}
            <div>
                <label for="type" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Vendor Type <span class="text-red-400"></span>
                </label>
                <div class="relative">
                    <select id="type" name="type" disabled
                        class="select2 w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white
                               focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                               transition-all duration-200 appearance-none cursor-pointer">
                        <option value="" class="bg-slate-800">Choose Type...</option>
                        <option value="Vendor"     class="bg-slate-800" {{ old('type', $vendor->type) == 'Vendor'     ? 'selected' : '' }}>Vendor</option>
                        <option value="Non Vendor" class="bg-slate-800" {{ old('type', $vendor->type) == 'Non Vendor' ? 'selected' : '' }}>Non Vendor</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                @error('type')
                    <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="status" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Status <span class="text-red-400"></span>
                </label>
                <div class="relative">
                    <select id="status" name="status" disabled
                        class="select2 w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white
                               focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent
                               transition-all duration-200 appearance-none cursor-pointer">
                        <option value="" class="bg-slate-800">Choose Statuses...</option>
                        <option value="Active"     class="bg-slate-800" {{ old('status', $vendor->status) == 'Active'     ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" class="bg-slate-800" {{ old('status', $vendor->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                @error('status')
                    <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
<br>
        {{-- ── ACTION BUTTONS ── --}}
        <div class="flex gap-3 pt-2">
            <a href="{{ route('vendor') }}"
                class="flex-1 py-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 font-semibold rounded-xl
                       transition-all duration-200 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // $(document).ready(function () {
    //     $('#transfer').select2({
    //         placeholder: "Choose Transfer...",
    //         allowClear: true,
    //         width: '100%'
    //     });
    // });
    $(document).ready(function () {
        $('#status').select2({
            placeholder: "Choose Status...",
            allowClear: true,
            width: '100%'
        });
    });
    $(document).ready(function () {
        $('#type').select2({
            placeholder: "Choose type...",
            allowClear: true,
            width: '100%'
        });
    });
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
</script>
@endsection