@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('subtitle', 'Overview of all form requests')

@section('content')

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-5 mb-8">
        @role('manager')

        @foreach ([['label' => 'Total Requests', 'value' => $stats['total'], 'color' => 'text-slate-300'], ['label' => 'Submitted', 'value' => $stats['Submitted'], 'color' => 'text-yellow-400'], ['label' => 'Approved', 'value' => $stats['approved'], 'color' => 'text-emerald-400'], ['label' => 'Rejected', 'value' => $stats['rejected'], 'color' => 'text-red-400'],['label' => 'Done', 'value' => $stats['Done'], 'color' => 'text-slate-300']] as $stat)
            <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
                <p class="text-xs text-slate-400 mb-1">{{ $stat['label'] }}</p>
                <p class="text-2xl font-semibold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
        @endforeach
        @endrole
        @role('user')
        @foreach ([['label' => 'Total Requests', 'value' => $stats['total'], 'color' => 'text-slate-300'], ['label' => 'Submitted', 'value' => $stats['Submitted'], 'color' => 'text-yellow-400'], ['label' => 'Approved', 'value' => $stats['approved'], 'color' => 'text-emerald-400'], ['label' => 'Rejected', 'value' => $stats['rejected'], 'color' => 'text-red-400'],['label' => 'Done', 'value' => $stats['Done'], 'color' => 'text-slate-300']] as $stat)
            <div class="bg-slate-800 rounded-xl p-4 border border-slate-700">
                <p class="text-xs text-slate-400 mb-1">{{ $stat['label'] }}</p>
                <p class="text-2xl font-semibold {{ $stat['color'] }}">{{ $stat['value'] }}</p>
            </div>
        @endforeach
        @endrole
    </div>

    {{-- Request Types --}}
    <div class="mb-2">
        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-4">Request Types</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($requestTypes as $type)
                        <a href="{{ route('request', ['type' => $type->code]) }}"
    
                    class="group bg-slate-800 border border-slate-700 hover:border-slate-500 rounded-xl p-4 flex flex-col gap-3 transition-all">
                    <div class="flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-500">{{ $type->request_type_name }}</p>
                            <p class="text-xs text-slate-500">Code: {{ $type->code }}</p>
                        </div>
                        <span class="shrink-0 text-xs font-medium bg-slate-700 text-slate-300 px-2.5 py-1 rounded-full">
                            {{ $type->requests_count ?? 0 }} active
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="mt-8">
        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-4">Recent Activity</p>
        <div class="bg-slate-800 border border-slate-700 rounded-xl divide-y divide-slate-700 overflow-hidden">
            @forelse($recentRequests as $req)
                <div class="flex items-center justify-between px-4 py-3 gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-500">{{ $req->document_number ?? 'N/A' }}</p>
                        <p class="text-xs text-slate-500">
                            {{ $req->user->employee->employee_name ?? '-' }} &middot;
                            {{ $req->requestType->request_type_name ?? '-' }}
                        </p>
                    </div>
                    @php
                        $statusMap = [
                            'pending' => 'bg-yellow-900/50 text-yellow-400',
                            'approved' => 'bg-emerald-900/50 text-emerald-400',
                            'rejected' => 'bg-red-900/50 text-red-400',
                        ];
                        $cls = $statusMap[$req->status] ?? 'bg-slate-700 text-slate-300';
                    @endphp
                    <span class="shrink-0 text-xs font-medium px-2.5 py-1 rounded-full {{ $cls }}">
                        {{ ucfirst($req->status) }}
                    </span>
                </div>
            @empty
                <div class="px-4 py-6 text-center text-sm text-slate-500">No recent requests.</div>
            @endforelse
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
{{-- @extends('layouts.app')

@section('title', 'Request Form Dashboard')
@section('header', 'Request Dashboard')
@section('subtitle', 'Manage and track your procurement requests')
@section('content')
    <style>
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            background-color: var(--bg-hover) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
            border-radius: 0.5rem;
            padding: 0.375rem 0.75rem;
            border-width: 1px;
            border-style: solid;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            color: var(--text-secondary) !important;
            font-size: 0.75rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--text-secondary) !important;
            border-radius: 0.5rem !important;
            border: none !important;
            padding: 0.25rem 0.75rem !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(to right, #3B82F6, #06B6D4) !important;
            color: white !important;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: var(--bg-hover) !important;
            color: var(--text-primary) !important;
        }

        table.dataTable tbody tr {
            background-color: transparent !important;
        }

        table.dataTable tbody tr:hover td {
            background-color: var(--bg-hover) !important;
        }

        table.dataTable thead th {
            border-bottom: 1px solid var(--border-color) !important;
        }

        table.dataTable.no-footer {
            border-bottom: none !important;
        }

        input[type="radio"].sr-only:checked+div {
            ring-width: 2px;
        }
    </style>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4 mb-6 lg:mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl md:rounded-2xl p-4 md:p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs md:text-sm font-semibold opacity-90">Total Request</h3>
                <svg class="w-6 h-6 md:w-8 md:h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </div>
            <p class="text-2xl md:text-3xl font-bold mb-1" id="total-users"></p>
            <p class="text-blue-100 text-xs">Your Request</p>
        </div>
        <div
            class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl md:rounded-2xl p-4 md:p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs md:text-sm font-semibold opacity-90">Approved Request</h3>
                <svg class="w-6 h-6 md:w-8 md:h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div
            class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl md:rounded-2xl p-4 md:p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs md:text-sm font-semibold opacity-90">Unchecked Request</h3>
                <svg class="w-6 h-6 md:w-8 md:h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20M7 7h10" />
                </svg>

            </div>
        </div>
        <div
            class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl md:rounded-2xl p-4 md:p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs md:text-sm font-semibold opacity-90">Rejected Request</h3>
                <svg class="w-6 h-6 md:w-8 md:h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                    </path>
                </svg>
            </div>
            </div>
    </div>
    <div class="rounded-xl lg:rounded-2xl p-4 lg:p-5 mb-6 lg:mb-8 border"
        style="background-color: var(--bg-card); border-color: var(--border-color);">

        <h3 class="text-sm font-semibold mb-4 flex items-center gap-2" style="color: var(--text-secondary)">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
            Approval Workflow
        </h3>

        <div class="flex items-center justify-between">

            <div class="flex flex-col items-center text-center">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-500 text-white font-semibold">
                    1
                </div>
                <p class="text-xs mt-2 font-medium" style="color: var(--text-primary)">User</p>
                <span class="text-[11px]" style="color: var(--text-muted)">Create Draft</span>
            </div>

            <div class="flex-1 h-[2px] mx-2 bg-slate-300 dark:bg-slate-700"></div>

            <div class="flex flex-col items-center text-center">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-yellow-500 text-white font-semibold">
                    2
                </div>
                <p class="text-xs mt-2 font-medium" style="color: var(--text-primary)">Manager</p>
                <span class="text-[11px]" style="color: var(--text-muted)">Approval</span>
            </div>

            <div class="flex-1 h-[2px] mx-2 bg-slate-300 dark:bg-slate-700"></div>

            <div class="flex flex-col items-center text-center">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-green-500 text-white font-semibold">
                    3
                </div>
                <p class="text-xs mt-2 font-medium" style="color: var(--text-primary)">Finance</p>
                <span class="text-[11px]" style="color: var(--text-muted)">Final Process</span>
            </div>

        </div>

    </div>
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">

        <div class="xl:col-span-2">
            <div class="rounded-xl lg:rounded-2xl border overflow-hidden"
                style="background-color: var(--bg-card); border-color: var(--border-color);">

                <div class="px-5 lg:px-6 py-4 lg:py-5 border-b flex items-center justify-between"
                    style="border-color: var(--border-color)">
                    <div>
                        <h2 class="text-base lg:text-lg font-bold" style="color: var(--text-primary)">New Request Form</h2>
                        <p class="text-xs lg:text-sm mt-0.5" style="color: var(--text-secondary)">Fill in the details to
                            submit a procurement request</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('formrequest.post') }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color: var(--text-secondary)">
                            Request Type <span class="text-red-400">*</span>
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2" id="request-type-selector">
                           
                        </div>
                    </div>
                    <div class="border-t" style="border-color: var(--border-color)"></div>
                    <div id="section-CAPEX" class="dynamic-section space-y-4 hidden">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-1 h-5 rounded-full bg-gradient-to-b from-violet-500 to-purple-600"></div>
                            <span class="text-xs font-bold uppercase tracking-wider"
                                style="color: var(--text-muted)">CAPEX Details</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Asset Category <span
                                        class="text-red-400">*</span></label>
                                <select name="asset_category"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-violet-500/40 focus:border-violet-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                    <option value="">Select asset category...</option>
                                    <option value="land">Land & Building</option>
                                    <option value="machinery">Machinery & Equipment</option>
                                    <option value="vehicle">Vehicle</option>
                                    <option value="furniture">Furniture & Fixture</option>
                                    <option value="it_asset">IT Asset</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Useful Life (Years)</label>
                                <input type="number" name="useful_life" placeholder="e.g. 5"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-violet-500/40 focus:border-violet-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Budget Reference / WBS</label>
                                <input type="text" name="budget_reference" placeholder="e.g. WBS-2025-001"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-violet-500/40 focus:border-violet-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Target Completion Date</label>
                                <input type="text" name="target_date" placeholder="DD/MM/YYYY"
                                    class="flatpickr w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-violet-500/40 focus:border-violet-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5"
                                style="color: var(--text-secondary)">Justification / Business Case <span
                                    class="text-red-400">*</span></label>
                            <textarea name="justification" rows="3" placeholder="Explain the business need and expected ROI..."
                                class="w-full px-4 py-3 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-violet-500/40 focus:border-violet-500 resize-none"
                                style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);"></textarea>
                        </div>
                    </div>

                    <div id="section-CA" class="dynamic-section space-y-4 hidden">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-1 h-5 rounded-full bg-gradient-to-b from-amber-500 to-orange-500"></div>
                            <span class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-muted)">Cash
                                Advance Details</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Date <span class="text-red-400">*</span></label>
                                <input type="text" name="activity_date" placeholder="DD/MM/YYYY"
                                    class="flatpickr w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Deadline <span
                                        class="text-red-400">*</span></label>
                                <input type="text" name="activity_date" placeholder="DD/MM/YYYY"
                                    class="flatpickr w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-semibold" style="color: var(--text-secondary)">Item List
                                    <span class="text-red-400">*</span></label>
                                <button type="button" id="add-item-btn"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-blue-500/10 text-blue-400 border border-blue-500/20 hover:bg-blue-500/20 transition-colors">
                                    + Add Item
                                </button>
                            </div>
                            <div class="rounded-xl border overflow-hidden" style="border-color: var(--border-color)">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b"
                                            style="background-color: var(--bg-hover); border-color: var(--border-color)">
                                            <th class="px-4 py-2.5 text-left text-xs font-semibold"
                                                style="color: var(--text-muted)">No.</th>
                                            <th class="px-4 py-2.5 text-left text-xs font-semibold"
                                                style="color: var(--text-muted)">Request</th>
                                            <th class="px-4 py-2.5 text-left text-xs font-semibold"
                                                style="color: var(--text-muted)">Spesification</th>
                                            <th class="px-4 py-2.5 text-left text-xs font-semibold"
                                                style="color: var(--text-muted)">Qty</th>
                                            <th class="px-4 py-2.5 text-left text-xs font-semibold"
                                                style="color: var(--text-muted)">Uom</th>
                                            <th class="px-4 py-2.5 text-left text-xs font-semibold"
                                                style="color: var(--text-muted)">Total Price</th>
                                            <th class="px-4 py-2.5 text-center text-xs font-semibold"
                                                style="color: var(--text-muted)">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="item-list">
                                        <tr class="item-row border-b" style="border-color: var(--border-color)">
                                            <td class="px-4 py-2 text-xs font-medium" style="color: var(--text-muted)">1
                                            </td>
                                            <td class="px-2 py-2">
                                                <input type="text" name="items[0][request]" placeholder="Request"
                                                    class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                            </td>

                                            <td class="px-2 py-2">
                                                <input type="text" name="items[0][specification]"
                                                    placeholder="Specification"
                                                    class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                            </td>
                                            <td class="px-2 py-2"><input type="number" name="items[0][qty]"
                                                    placeholder="1" min="1"
                                                    class="w-16 px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                            </td>
                                            <td class="px-2 py-2">
                                                <select name="items[0][uom]"
                                                    class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                                    <option value="">-- Select UOM --</option>
                                                    @foreach ($uomOptions as $uom)
                                                        <option value="{{ $uom }}">{{ $uom }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-2 py-2"><input type="number" name="items[0][price]"
                                                    placeholder="0"
                                                    class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                            </td>
                                            <td class="px-4 py-2 text-center"><button type="button"
                                                    class="remove-item-btn text-red-400 hover:text-red-300 transition-colors text-xs font-medium opacity-30 cursor-not-allowed"
                                                    disabled>Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex justify-end mt-3">
                                <div class="text-right">
                                    <div class="text-xs mb-1" style="color: var(--text-muted)">
                                        Subtotal
                                    </div>

                                    <div id="subtotal-display" class="text-lg font-semibold"
                                        style="color: var(--text-primary)">
                                        Rp 0
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5"
                                style="color: var(--text-secondary)">Notes</label>
                            <textarea name="notes" rows="3" placeholder="List estimated costs (transport, accommodation, meals, etc.)..."
                                class="w-full px-4 py-3 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 resize-none"
                                style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);"></textarea>
                        </div>
                    </div>

                    <div id="section-PR" class="dynamic-section space-y-4 hidden">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-1 h-5 rounded-full bg-gradient-to-b from-blue-500 to-cyan-500"></div>
                            <span class="text-xs font-bold uppercase tracking-wider"
                                style="color: var(--text-muted)">Purchase Request Details</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Category <span
                                        class="text-red-400">*</span></label>
                                <select name="category"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                    <option value="">Select category...</option>
                                    <option value="office">Office Supplies</option>
                                    <option value="it">IT Equipment</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="furniture">Furniture</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Date Needed <span
                                        class="text-red-400">*</span></label>
                                <input type="text" name="date_needed" placeholder="DD/MM/YYYY"
                                    class="flatpickr w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-semibold" style="color: var(--text-secondary)">Item List
                                    <span class="text-red-400">*</span></label>
                                <button type="button" id="add-item-btn"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-blue-500/10 text-blue-400 border border-blue-500/20 hover:bg-blue-500/20 transition-colors">
                                    + Add Item
                                </button>
                            </div>
                            <div class="rounded-xl border overflow-hidden" style="border-color: var(--border-color)">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b"
                                            style="background-color: var(--bg-hover); border-color: var(--border-color)">
                                            <th class="px-4 py-2.5 text-left text-xs font-semibold"
                                                style="color: var(--text-muted)">No.</th>
                                            <th class="px-4 py-2.5 text-left text-xs font-semibold"
                                                style="color: var(--text-muted)">Item Name</th>
                                            <th class="px-4 py-2.5 text-left text-xs font-semibold"
                                                style="color: var(--text-muted)">Qty</th>
                                            <th class="px-4 py-2.5 text-left text-xs font-semibold"
                                                style="color: var(--text-muted)">Uom</th>
                                            <th class="px-4 py-2.5 text-left text-xs font-semibold"
                                                style="color: var(--text-muted)">Est. Price (Rp)</th>
                                            <th class="px-4 py-2.5 text-center text-xs font-semibold"
                                                style="color: var(--text-muted)">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="item-list">
                                        <tr class="item-row border-b" style="border-color: var(--border-color)">
                                            <td class="px-4 py-2 text-xs font-medium" style="color: var(--text-muted)">1
                                            </td>
                                            <td class="px-2 py-2"><input type="text" name="items[0][name]"
                                                    placeholder="Item name"
                                                    class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                            </td>
                                            <td class="px-2 py-2"><input type="number" name="items[0][qty]"
                                                    placeholder="1" min="1"
                                                    class="w-16 px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                            </td>
                                            <td class="px-2 py-2">
                                                <select name="items[0][uom]"
                                                    class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                                    <option value="">-- Select UOM --</option>
                                                    @foreach ($uomOptions as $uom)
                                                        <option value="{{ $uom }}">{{ $uom }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-2 py-2"><input type="number" name="items[0][price]"
                                                    placeholder="0"
                                                    class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                            </td>
                                            <td class="px-4 py-2 text-center"><button type="button"
                                                    class="remove-item-btn text-red-400 hover:text-red-300 transition-colors text-xs font-medium opacity-30 cursor-not-allowed"
                                                    disabled>Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5"
                                style="color: var(--text-secondary)">Specification / Notes</label>
                            <textarea name="description" rows="3"
                                placeholder="Additional specifications, brand preference, quality standards..."
                                class="w-full px-4 py-3 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 resize-none"
                                style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);"></textarea>
                        </div>
                    </div>

                    <div id="section-PMT" class="dynamic-section space-y-4 hidden">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-1 h-5 rounded-full bg-gradient-to-b from-emerald-500 to-teal-500"></div>
                            <span class="text-xs font-bold uppercase tracking-wider"
                                style="color: var(--text-muted)">Payment Request Details</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Vendor / Payee Name <span
                                        class="text-red-400">*</span></label>
                                <input type="text" name="vendor_name" placeholder="e.g. PT. Sumber Makmur"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Invoice Number <span
                                        class="text-red-400">*</span></label>
                                <input type="text" name="invoice_number" placeholder="e.g. INV/2025/001"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Invoice Date <span
                                        class="text-red-400">*</span></label>
                                <input type="text" name="invoice_date" placeholder="DD/MM/YYYY"
                                    class="flatpickr w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-secondary)">Due
                                    Date <span class="text-red-400">*</span></label>
                                <input type="text" name="due_date" placeholder="DD/MM/YYYY"
                                    class="flatpickr w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Payment Method <span
                                        class="text-red-400">*</span></label>
                                <select name="payment_method"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                    <option value="">Select method...</option>
                                    <option value="transfer">Bank Transfer</option>
                                    <option value="cash">Cash</option>
                                    <option value="giro">Giro</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Bank Account Number</label>
                                <input type="text" name="bank_account" placeholder="e.g. 1234567890"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5"
                                style="color: var(--text-secondary)">Description of Payment <span
                                    class="text-red-400">*</span></label>
                            <textarea name="payment_description" rows="3" placeholder="Describe the goods/services being paid for..."
                                class="w-full px-4 py-3 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 resize-none"
                                style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);"></textarea>
                        </div>
                    </div>

                    <div id="section-RMB" class="dynamic-section space-y-4 hidden">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-1 h-5 rounded-full bg-gradient-to-b from-rose-500 to-pink-500"></div>
                            <span class="text-xs font-bold uppercase tracking-wider"
                                style="color: var(--text-muted)">Reimbursement Details</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Expense Category <span
                                        class="text-red-400">*</span></label>
                                <select name="expense_category"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-rose-500/40 focus:border-rose-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                                    <option value="">Select category...</option>
                                    <option value="transport">Transportation</option>
                                    <option value="meal">Meals & Entertainment</option>
                                    <option value="accommodation">Accommodation</option>
                                    <option value="office">Office Supplies</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Expense Date <span
                                        class="text-red-400">*</span></label>
                                <input type="text" name="expense_date" placeholder="DD/MM/YYYY"
                                    class="flatpickr w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-rose-500/40 focus:border-rose-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Receipt / Reference No.</label>
                                <input type="text" name="receipt_number" placeholder="e.g. RCP-001"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-rose-500/40 focus:border-rose-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1.5"
                                    style="color: var(--text-secondary)">Reimbursement Account <span
                                        class="text-red-400">*</span></label>
                                <input type="text" name="reimbursement_account" placeholder="Bank account number"
                                    class="w-full px-4 py-2.5 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-rose-500/40 focus:border-rose-500"
                                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);">
                            </div>
                        </div>
                        <div class="rounded-xl p-3 border flex items-start gap-3"
                            style="background-color: var(--bg-hover); border-color: var(--border-color);">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-rose-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-xs" style="color: var(--text-secondary)">
                                All receipts and proof of payment <strong>must</strong> be attached below. Reimbursement
                                requests without receipts will be rejected.
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1.5"
                                style="color: var(--text-secondary)">Description of Expense <span
                                    class="text-red-400">*</span></label>
                            <textarea name="expense_description" rows="3" placeholder="Describe what the expense was for..."
                                class="w-full px-4 py-3 rounded-xl text-sm border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-rose-500/40 focus:border-rose-500 resize-none"
                                style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-primary);"></textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-secondary)">
                            Supporting Document
                        </label>

                        <div class="relative border-2 border-dashed rounded-xl p-5 text-center transition-all duration-200 cursor-pointer group"
                            style="border-color: var(--border-color); background-color: var(--bg-hover);">

                            <input type="file" name="attachments[]" id="attachments"
                                class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" multiple>

                            <svg class="w-8 h-8 mx-auto mb-2 transition-colors" style="color: var(--text-muted)"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>

                            <p class="text-sm font-medium" style="color: var(--text-primary)">
                                Click to upload or drag & drop
                            </p>

                            <p class="text-xs mt-1" style="color: var(--text-muted)">
                                PDF, DOC, XLSX, JPG up to 5MB
                            </p>

                        </div>

                        <div id="file-list" class="mt-3 space-y-2 text-sm"></div>
                    </div>




                    <div class="flex flex-col sm:flex-row items-center gap-3 pt-2">
                        <button type="submit"
                            class="w-full sm:w-auto flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl font-semibold shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-200 text-sm hover:scale-[1.01]">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Submit Request
                        </button>
                        <button type="reset"
                            class="w-full sm:w-auto px-6 py-3 rounded-xl font-semibold text-sm border transition-all duration-200 hover:scale-[1.01]"
                            style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-secondary)">
                            Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="space-y-6">

            @role('manager')
                <div class="rounded-xl lg:rounded-2xl border overflow-hidden"
                    style="background-color: var(--bg-card); border-color: var(--border-color);">
                    <div class="px-5 py-4 border-b" style="border-color: var(--border-color)">
                        <h3 class="text-sm font-bold" style="color: var(--text-primary)">Pending Approvals</h3>
                        <p class="text-xs mt-0.5" style="color: var(--text-muted)">8 requests awaiting your review</p>
                    </div>
                    <div class="p-4 space-y-3">
                        @php
                            $pending = [
                                [
                                    'name' => 'John Doe',
                                    'item' => 'IT Equipment',
                                    'amount' => 'Rp 2.500.000',
                                    'date' => '2 hrs ago',
                                    'priority' => 'high',
                                ],
                                [
                                    'name' => 'Jane Smith',
                                    'item' => 'Office Supplies',
                                    'amount' => 'Rp 450.000',
                                    'date' => '5 hrs ago',
                                    'priority' => 'low',
                                ],
                                [
                                    'name' => 'Bob Wilson',
                                    'item' => 'Furniture',
                                    'amount' => 'Rp 7.200.000',
                                    'date' => '1 day ago',
                                    'priority' => 'medium',
                                ],
                            ];
                        @endphp

                        @foreach ($pending as $item)
                            <div class="p-3 rounded-xl border transition-all hover:border-blue-500/30"
                                style="background-color: var(--bg-hover); border-color: var(--border-color);">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold truncate" style="color: var(--text-primary)">
                                            {{ $item['name'] }}</p>
                                        <p class="text-xs truncate" style="color: var(--text-muted)">{{ $item['item'] }}</p>
                                    </div>
                                   
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold"
                                        style="color: var(--text-secondary)">{{ $item['amount'] }}</span>
                                    <span class="text-xs" style="color: var(--text-muted)">{{ $item['date'] }}</span>
                                </div>
                                <div class="flex gap-2 mt-2.5">
                                    <button
                                        class="flex-1 py-1.5 rounded-lg text-xs font-semibold bg-emerald-500/15 text-emerald-400 hover:bg-emerald-500/25 transition-colors border border-emerald-500/20">
                                        ✓ Approve
                                    </button>
                                    <button
                                        class="flex-1 py-1.5 rounded-lg text-xs font-semibold bg-red-500/15 text-red-400 hover:bg-red-500/25 transition-colors border border-red-500/20">
                                        ✗ Reject
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        <a href="#"
                            class="block w-full py-2.5 rounded-xl text-center text-xs font-semibold border transition-all hover:border-blue-500/40 hover:text-blue-400"
                            style="border-color: var(--border-color); color: var(--text-muted)">
                            View All Pending →
                        </a>
                    </div>
                </div>
            @endrole

            @role('finance')
                <div class="rounded-xl lg:rounded-2xl border overflow-hidden"
                    style="background-color: var(--bg-card); border-color: var(--border-color);">
                    <div class="px-5 py-4 border-b" style="border-color: var(--border-color)">
                        <h3 class="text-sm font-bold" style="color: var(--text-primary)">Finance Queue</h3>
                        <p class="text-xs mt-0.5" style="color: var(--text-muted)">5 approved requests to process</p>
                    </div>
                    <div class="p-4 space-y-3">
                        @php
                            $financeQueue = [
                                [
                                    'title' => 'IT Equipment',
                                    'requester' => 'John Doe',
                                    'amount' => 'Rp 2.500.000',
                                    'approved_by' => 'Mgr. Agus',
                                ],
                                [
                                    'title' => 'Furniture',
                                    'requester' => 'Bob Wilson',
                                    'amount' => 'Rp 7.200.000',
                                    'approved_by' => 'Mgr. Agus',
                                ],
                                [
                                    'title' => 'Lab Tools',
                                    'requester' => 'Sari Dewi',
                                    'amount' => 'Rp 3.750.000',
                                    'approved_by' => 'Mgr. Budi',
                                ],
                            ];
                        @endphp

                        @foreach ($financeQueue as $req)
                            <div class="p-3 rounded-xl border"
                                style="background-color: var(--bg-hover); border-color: var(--border-color);">
                                <div class="flex justify-between items-start mb-1.5">
                                    <p class="text-xs font-semibold" style="color: var(--text-primary)">{{ $req['title'] }}
                                    </p>
                                    <span
                                        class="text-xs px-2 py-0.5 rounded-full bg-blue-500/10 text-blue-400 font-medium">Approved</span>
                                </div>
                                <p class="text-xs mb-2" style="color: var(--text-muted)">By {{ $req['requester'] }} ·
                                    {{ $req['approved_by'] }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-emerald-400">{{ $req['amount'] }}</span>
                                    <button
                                        class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/15 text-blue-400 hover:bg-blue-500/25 transition-colors border border-blue-500/20">
                                        Mark Received
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endrole

            <div class="rounded-xl lg:rounded-2xl border overflow-hidden"
                style="background-color: var(--bg-card); border-color: var(--border-color);">
                <div class="px-5 py-4 border-b" style="border-color: var(--border-color)">
                    <h3 class="text-sm font-bold" style="color: var(--text-primary)">My Recent Requests</h3>
                </div>
                <div class="divide-y" style="border-color: var(--border-color)">
                    @php
                        $myRequests = [
                            [
                                'title' => 'Printer Ink Cartridge',
                                'status' => 'approved',
                                'amount' => 'Rp 350.000',
                                'date' => 'Mar 5',
                            ],
                            [
                                'title' => 'Whiteboard Markers',
                                'status' => 'pending',
                                'amount' => 'Rp 120.000',
                                'date' => 'Mar 6',
                            ],
                            [
                                'title' => 'USB Hub x3',
                                'status' => 'finance',
                                'amount' => 'Rp 450.000',
                                'date' => 'Mar 7',
                            ],
                            [
                                'title' => 'Lab Notebook x20',
                                'status' => 'rejected',
                                'amount' => 'Rp 200.000',
                                'date' => 'Mar 3',
                            ],
                        ];
                    @endphp

                    @foreach ($myRequests as $req)
                        <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-opacity-50 transition-colors"
                            style="background-color: transparent">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold truncate" style="color: var(--text-primary)">
                                    {{ $req['title'] }}</p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs" style="color: var(--text-muted)">{{ $req['date'] }}</span>
                                    <span class="text-xs" style="color: var(--text-muted)">·</span>
                                    <span class="text-xs font-medium"
                                        style="color: var(--text-secondary)">{{ $req['amount'] }}</span>
                                </div>
                            </div>
                          
                        </div>
                    @endforeach
                </div>
                <div class="px-5 py-3 border-t" style="border-color: var(--border-color)">
                    <a href="#"
                        class="text-xs font-semibold text-blue-400 hover:text-blue-300 transition-colors">View all requests
                        →</a>
                </div>
            </div>
        </div>
    </div>

    @role('admin|manager')
<div class="mt-6 lg:mt-8 rounded-xl lg:rounded-2xl border overflow-hidden"
     style="background-color: var(--bg-card); border-color: var(--border-color);">
    <div class="px-5 lg:px-6 py-4 lg:py-5 border-b flex items-center justify-between"
         style="border-color: var(--border-color)">
        <div>
            <h2 class="text-base font-bold" style="color: var(--text-primary)">All Requests</h2>
            <p class="text-xs mt-0.5" style="color: var(--text-muted)">Complete list of procurement requests</p>
        </div>
        <div class="flex gap-2">
            <button class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition-all"
                    style="background-color: var(--bg-hover); border-color: var(--border-color); color: var(--text-secondary)">
                Export
            </button>
            <button class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-sm">
                + Filter
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table id="requestsTable" class="w-full text-sm">
            <thead>
                <tr style="background-color: var(--bg-hover); border-color: var(--border-color);">
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted)">#</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted)">Requester</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted)">Item</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted)">Amount</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted)">Priority</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted)">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted)">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: var(--text-muted)">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y" style="border-color: var(--border-color)">
                @php
                    $rows = [
                        [1, 'John Doe',   'IT Equipment',    'Rp 2.500.000', 'high',   'pending',  'Mar 7, 2025'],
                        [2, 'Jane Smith', 'Office Supplies', 'Rp 450.000',   'low',    'approved', 'Mar 6, 2025'],
                        [3, 'Bob Wilson', 'Furniture',       'Rp 7.200.000', 'medium', 'finance',  'Mar 5, 2025'],
                        [4, 'Sari Dewi',  'Lab Tools',       'Rp 3.750.000', 'high',   'approved', 'Mar 5, 2025'],
                        [5, 'Andi K.',    'Whiteboard',      'Rp 890.000',   'low',    'rejected', 'Mar 3, 2025'],
                    ];
                @endphp

                @foreach ($rows as [$no, $name, $item, $amount, $priority, $status, $date])
                <tr class="transition-colors hover:bg-opacity-50"
                    style="background-color: transparent; color: var(--text-primary)">
                    <td class="px-4 py-3.5 text-sm" style="color: var(--text-muted)">{{ $no }}</td>
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-xs font-bold text-white shrink-0">
                                {{ substr($name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium">{{ $name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 text-sm" style="color: var(--text-secondary)">{{ $item }}</td>
                    <td class="px-4 py-3.5 text-sm font-semibold" style="color: var(--text-primary)">{{ $amount }}</td>
                    <td class="px-4 py-3.5">
                    </td>
                    <td class="px-4 py-3.5">
                        
                    </td>
                    <td class="px-4 py-3.5 text-xs" style="color: var(--text-muted)">{{ $date }}</td>
                    <td class="px-4 py-3.5">
                        <div class="flex gap-1.5">
                            <button class="p-1.5 rounded-lg transition-colors hover:bg-blue-500/20 text-blue-400" title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            @if ($status === 'pending')
                            <button class="p-1.5 rounded-lg transition-colors hover:bg-emerald-500/20 text-emerald-400" title="Approve">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                            <button class="p-1.5 rounded-lg transition-colors hover:bg-red-500/20 text-red-400" title="Reject">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endrole

@endsection
@push('scripts')

    <script>
        function getActiveSection() {
            return document.querySelector('.dynamic-section:not(.hidden)');
        }

        function calculateSubtotal() {
            const section = getActiveSection();
            if (!section) return;

            const subtotalEl = section.querySelector('.subtotal-display');
            if (!subtotalEl) return;

            let subtotal = 0;

            section.querySelectorAll('.item-row').forEach(row => {
                const qty   = parseFloat(row.querySelector('input[name*="[qty]"]')?.value)   || 0;
                const price = parseFloat(row.querySelector('input[name*="[price]"]')?.value) || 0;
                subtotal += qty * price;
            });

            subtotalEl.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        }

        document.addEventListener('input', function (e) {
            if (e.target.name && (e.target.name.includes('[qty]') || e.target.name.includes('[price]'))) {
                calculateSubtotal();
            }
        });
    </script>

    <script>
        document.getElementById('attachments')?.addEventListener('change', function (e) {
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = '';

            Array.from(e.target.files).forEach(file => {
                const item = document.createElement('div');
                item.className = 'px-3 py-2 rounded-lg';
                item.style.cssText = 'background-color:var(--bg-secondary);color:var(--text-primary);border:1px solid var(--border-color);';
                item.innerText = `${file.name} (${Math.round(file.size / 1024)} KB)`;
                fileList.appendChild(item);
            });
        });
    </script>

    <script>
        const uomOptions = @json($uomOptions);

        function generateUomOptions() {
            let options = `<option value="">-- Select UOM --</option>`;
            uomOptions.forEach(uom => {
                options += `<option value="${uom}">${uom}</option>`;
            });
            return options;
        }

        document.addEventListener('DOMContentLoaded', function () {

            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeSlideIn {
                    from { opacity: 0; transform: translateY(8px); }
                    to   { opacity: 1; transform: translateY(0); }
                }
            `;
            document.head.appendChild(style);

            const radios   = document.querySelectorAll('.request-type-radio');
            const sections = document.querySelectorAll('.dynamic-section');
            const cards    = document.querySelectorAll('.request-type-card');

            function switchType(selectedRadio) {
                const selectedType = selectedRadio.dataset.type;

                cards.forEach(card => {
                    card.style.borderColor = 'var(--border-color)';
                    card.className = card.className.replace(/ring-\S+/g, '').trim();
                    card.classList.remove('ring-2', 'border-transparent');
                });

                const activeCard = selectedRadio.closest('label').querySelector('.request-type-card');
                activeCard.style.borderColor = 'transparent';
                activeCard.classList.add('ring-2', activeCard.dataset.ring);

                sections.forEach(s => s.classList.add('hidden'));

                const target = document.getElementById('section-' + selectedType);
                if (target) {
                    target.classList.remove('hidden');
                    target.style.animation = 'none';
                    target.offsetHeight; 
                    target.style.animation = 'fadeSlideIn 0.25s ease';
                }

                calculateSubtotal();
            }

            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.checked) switchType(this);
                });
            });

            const checked = document.querySelector('.request-type-radio:checked');
            if (checked) switchType(checked);


            function getItemCount(section) {
                return parseInt(section.dataset.itemCount || '1');
            }
            function setItemCount(section, val) {
                section.dataset.itemCount = val;
            }

            document.addEventListener('click', function (e) {
                const addBtn = e.target.closest('.add-item-btn');
                if (!addBtn) return;

                const section = addBtn.closest('.dynamic-section');
                const tbody   = section.querySelector('.item-list');
                const index   = getItemCount(section);
                setItemCount(section, index + 1);

                const sectionId = section.id.replace('section-', '').toLowerCase(); 

                const tr = document.createElement('tr');
                tr.className = 'item-row border-b';
                tr.style.borderColor = 'var(--border-color)';

                const hasSPec = !!tbody.closest('table').querySelector('th[data-col="specification"]');

                if (sectionId === 'ca') {
                    tr.innerHTML = `
                        <td class="px-4 py-2 text-xs font-medium" style="color:var(--text-muted)">${index + 1}</td>
                        <td class="px-2 py-2">
                            <input type="text" name="items[${index}][request]" placeholder="Request"
                                class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                style="background-color:var(--bg-hover);border-color:var(--border-color);color:var(--text-primary);">
                        </td>
                        <td class="px-2 py-2">
                            <input type="text" name="items[${index}][specification]" placeholder="Specification"
                                class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                style="background-color:var(--bg-hover);border-color:var(--border-color);color:var(--text-primary);">
                        </td>
                        <td class="px-2 py-2">
                            <input type="number" name="items[${index}][qty]" placeholder="1" min="1"
                                class="w-16 px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                style="background-color:var(--bg-hover);border-color:var(--border-color);color:var(--text-primary);">
                        </td>
                        <td class="px-2 py-2">
                            <select name="items[${index}][uom]"
                                class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                style="background-color:var(--bg-hover);border-color:var(--border-color);color:var(--text-primary);">
                                ${generateUomOptions()}
                            </select>
                        </td>
                        <td class="px-2 py-2">
                            <input type="number" name="items[${index}][price]" placeholder="0"
                                class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                style="background-color:var(--bg-hover);border-color:var(--border-color);color:var(--text-primary);">
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button type="button" class="remove-item-btn text-red-400 hover:text-red-300 transition-colors text-xs font-medium">
                                Remove
                            </button>
                        </td>`;
                } else {
                    tr.innerHTML = `
                        <td class="px-4 py-2 text-xs font-medium" style="color:var(--text-muted)">${index + 1}</td>
                        <td class="px-2 py-2">
                            <input type="text" name="items[${index}][name]" placeholder="Item name"
                                class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                style="background-color:var(--bg-hover);border-color:var(--border-color);color:var(--text-primary);">
                        </td>
                        <td class="px-2 py-2">
                            <input type="number" name="items[${index}][qty]" placeholder="1" min="1"
                                class="w-16 px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                style="background-color:var(--bg-hover);border-color:var(--border-color);color:var(--text-primary);">
                        </td>
                        <td class="px-2 py-2">
                            <select name="items[${index}][uom]"
                                class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                style="background-color:var(--bg-hover);border-color:var(--border-color);color:var(--text-primary);">
                                ${generateUomOptions()}
                            </select>
                        </td>
                        <td class="px-2 py-2">
                            <input type="number" name="items[${index}][price]" placeholder="0"
                                class="w-full px-3 py-1.5 rounded-lg text-xs border focus:outline-none focus:ring-1 focus:ring-blue-500"
                                style="background-color:var(--bg-hover);border-color:var(--border-color);color:var(--text-primary);">
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button type="button" class="remove-item-btn text-red-400 hover:text-red-300 transition-colors text-xs font-medium">
                                Remove
                            </button>
                        </td>`;
                }

                tbody.appendChild(tr);
                calculateSubtotal();
                updateRemoveButtons(section);
            });

            document.addEventListener('click', function (e) {
                const removeBtn = e.target.closest('.remove-item-btn');
                if (!removeBtn) return;

                const section = removeBtn.closest('.dynamic-section');
                removeBtn.closest('tr').remove();
                renumberItems(section);
                updateRemoveButtons(section);
                calculateSubtotal();
            });

            function renumberItems(section) {
                section.querySelectorAll('.item-list .item-row').forEach((row, i) => {
                    row.querySelector('td:first-child').textContent = i + 1;
                });
            }

            function updateRemoveButtons(section) {
                const rows = section.querySelectorAll('.item-list .item-row');
                rows.forEach(row => {
                    const btn = row.querySelector('.remove-item-btn');
                    if (!btn) return;
                    const isOnly = rows.length === 1;
                    btn.disabled = isOnly;
                    btn.classList.toggle('opacity-30', isOnly);
                    btn.classList.toggle('cursor-not-allowed', isOnly);
                });
            }
        });
    </script>
  
    <script>
        document.querySelectorAll('.flatpickr').forEach(el => {
            flatpickr(el, {
                dateFormat: 'd/m/Y',
                minDate: 'today',
            });
        });
        @role('admin|manager')
            if (typeof $.fn.DataTable !== 'undefined') {
                $('#requestsTable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    language: {
                        search: '',
                        searchPlaceholder: 'Search requests...',
                    },
                    dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4"lf>rt<"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-4"ip>',
                });
            }
        @endrole
    </script>

@endpush --}}