@extends('layouts.app')
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

        {{-- Header Info Card --}}
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

        {{-- Meta Info Grid --}}
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

        </div>

        {{-- Action Band --}}
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

@endsection