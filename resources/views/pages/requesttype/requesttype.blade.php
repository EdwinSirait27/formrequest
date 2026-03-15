@extends('layouts.app')
@section('title', 'Request Type')
@section('header', 'Request Type List')
@section('subtitle', 'Manage Request Type for Form')
@section('content')
    <style>
        /* =============================================
           CSS VARIABLES - Dark & Light Theme
           ============================================= */
        :root,
        .dark {
            --bg-card: #1e293b;
            --bg-card-header: #0f172a;
            --bg-table-head: #0f172a;
            --bg-table-body: #1e293b;
            --bg-table-hover: #334155;
            --bg-input: #334155;
            --bg-mobile-card: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            --bg-page-btn: #1e293b;
            --bg-page-btn-hover: #334155;

            --border-card: #334155;
            --border-input: #475569;
            --border-row: #334155;
            --border-page-btn: #334155;

            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --text-table: #cbd5e1;
            --text-th: #ffffff;
            --text-page-btn: #cbd5e1;
            --text-page-btn-hover: #f1f5f9;

            --accent-gradient: linear-gradient(to right, #3b82f6, #06b6d4);
            --accent-shadow: rgba(59, 130, 246, 0.3);
            --badge-gradient: linear-gradient(135deg, #8b5cf6, #6366f1);

            --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        }

        /* Light Theme Overrides */
        html:not(.dark) {
            --bg-card: #ffffff;
            --bg-card-header: #f8fafc;
            --bg-table-head: #f1f5f9;
            --bg-table-body: #ffffff;
            --bg-table-hover: #f0f9ff;
            --bg-input: #ffffff;
            --bg-mobile-card: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            --bg-page-btn: #ffffff;
            --bg-page-btn-hover: #f1f5f9;

            --border-card: #e2e8f0;
            --border-input: #cbd5e1;
            --border-row: #e2e8f0;
            --border-page-btn: #e2e8f0;

            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --text-table: #334155;
            --text-th: #1e293b;
            --text-page-btn: #475569;
            --text-page-btn-hover: #1e293b;

            --accent-shadow: rgba(59, 130, 246, 0.2);
            --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.08);
        }

        /* =============================================
           DataTables Controls
           ============================================= */
        .dataTables_wrapper {
            font-family: inherit;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid var(--border-input);
            border-radius: 0.5rem;
            padding: 0.5rem;
            font-size: 0.875rem;
            margin: 0 0.5rem;
            background-color: var(--bg-input);
            color: var(--text-primary);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        /* =============================================
           Table Styling
           ============================================= */
        #users-table {
            width: 100% !important;
        }

        #users-table thead {
            background: var(--bg-table-head);
        }

        #users-table thead th {
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border: none;
            white-space: nowrap;
            color: var(--text-th);
        }

        #users-table tbody {
            background-color: var(--bg-table-body);
        }

        #users-table tbody tr {
            border-bottom: 1px solid var(--border-row);
            transition: background-color 0.2s;
        }

        #users-table tbody tr:hover {
            background-color: var(--bg-table-hover);
        }

        #users-table tbody td {
            padding: 1rem;
            color: var(--text-table);
            font-size: 0.875rem;
            vertical-align: middle;
        }

        /* =============================================
           Pagination
           ============================================= */
        .dataTables_wrapper .dataTables_paginate {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: 1rem;
            gap: 0.5rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            display: inline-block;
            padding: 0.5rem 0.75rem;
            margin: 0 0.125rem;
            border: 1px solid var(--border-page-btn);
            border-radius: 0.5rem;
            background-color: var(--bg-page-btn);
            color: var(--text-page-btn) !important;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            min-width: 2rem;
            text-align: center;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: var(--bg-page-btn-hover) !important;
            border-color: var(--border-input);
            color: var(--text-page-btn-hover) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--accent-gradient) !important;
            border-color: transparent !important;
            color: white !important;
            box-shadow: 0 4px 6px -1px var(--accent-shadow);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
            background-color: var(--bg-page-btn) !important;
            color: var(--text-page-btn) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
        .dataTables_wrapper .dataTables_paginate .paginate_button.next {
            font-weight: 600;
        }

        /* =============================================
           Action Buttons
           ============================================= */
        .btn-action {
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
            border: none;
            cursor: pointer;
        }

        .btn-action svg {
            width: 1rem;
            height: 1rem;
        }

        .btn-edit {
            background: var(--accent-gradient);
            color: white;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px var(--accent-shadow);
        }

        .btn-delete {
            background: linear-gradient(to right, #ef4444, #dc2626);
            color: white;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.35);
        }

        /* =============================================
           Card & Input (main container)
           ============================================= */
        .vendor-card-container {
            background-color: var(--bg-card);
            border-color: var(--border-card);
            box-shadow: var(--shadow-card);
            transition: background-color 0.3s, border-color 0.3s;
        }

        .vendor-card-header {
            border-color: var(--border-card) !important;
            background-color: var(--bg-card-header);
            transition: background-color 0.3s, border-color 0.3s;
        }

        .vendor-title {
            color: var(--text-primary);
        }

        .vendor-subtitle {
            color: var(--text-secondary);
        }

        .search-input {
            background-color: var(--bg-input) !important;
            border-color: var(--border-input) !important;
            color: var(--text-primary) !important;
            transition: background-color 0.3s, border-color 0.3s, color 0.3s;
        }

        .search-input::placeholder {
            color: var(--text-muted) !important;
        }

        .search-input:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
            outline: none;
        }

        .search-icon {
            color: var(--text-muted);
        }

        /* =============================================
           Mobile Responsive
           ============================================= */
        @media (max-width: 767px) {
            #users-table-wrapper {
                display: none !important;
            }

            #mobile-cards-view {
                display: block !important;
            }

            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_info {
                display: none !important;
            }

            .dataTables_wrapper .dataTables_paginate {
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.25rem;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 0.4rem 0.6rem;
                font-size: 0.813rem;
            }
        }

        @media (min-width: 768px) {
            #mobile-cards-view {
                display: none !important;
            }

            #users-table-wrapper {
                display: block !important;
            }
        }

        /* =============================================
           Mobile Card Styles
           ============================================= */
        .user-card {
            background: var(--bg-mobile-card);
            border: 1px solid var(--border-card);
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-card);
            transition: all 0.3s;
        }

        .user-card:active {
            transform: scale(0.98);
        }

        .user-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-card);
        }

        .user-card-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--accent-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .user-card-title {
            flex: 1;
            margin-left: 0.75rem;
        }

        .user-card-name {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.125rem;
        }

        .user-card-username {
            color: var(--text-secondary);
            font-size: 0.813rem;
        }

        .user-card-body {
            display: grid;
            gap: 0.75rem;
        }

        .user-card-field {
            display: flex;
            align-items: flex-start;
        }

        .user-card-label {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            min-width: 110px;
            flex-shrink: 0;
        }

        .user-card-value {
            color: var(--text-table);
            font-size: 0.875rem;
            flex: 1;
        }

        .user-card-badge {
            display: inline-block;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            background: var(--badge-gradient);
            color: white;
        }

        .user-card-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
            padding-top: 0.75rem;
            border-top: 1px solid var(--border-card);
        }

        .user-card-actions .btn-action {
            flex: 1;
            justify-content: center;
            padding: 0.625rem;
            font-size: 0.875rem;
        }

        /* Mobile Pagination */
        #mobile-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 1.5rem;
            gap: 0.5rem;
        }

        .mobile-page-btn {
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border-page-btn);
            border-radius: 0.5rem;
            background-color: var(--bg-page-btn);
            color: var(--text-page-btn);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .mobile-page-btn:active {
            transform: scale(0.95);
        }

        .mobile-page-btn.active {
            background: var(--accent-gradient);
            color: white;
            border-color: transparent;
        }

        .mobile-page-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .mobile-info-text {
            color: var(--text-secondary);
            font-size: 0.813rem;
            text-align: center;
            margin-top: 0.75rem;
        }

        /* Loading state */
        #loading-state p {
            color: var(--text-secondary);
        }

        /* Dividers for table */
        .divide-themed {
            border-color: var(--border-row);
        }

        /* Table wrapper background fix */
        .table-body-bg {
            background-color: var(--bg-table-body);
        }
        #users-table th{
    text-align: center;
}
    </style>

    <div class="space-y-4 md:space-y-6">

        {{-- Main Content Card --}}
        <div class="vendor-card-container rounded-xl md:rounded-2xl shadow-lg border overflow-hidden">

            {{-- Card Header --}}
            <div class="vendor-card-header px-4 py-4 md:px-6 md:py-5 border-b">
                <div class="flex flex-col gap-3 md:gap-4">
                    <div>
                        <h2 class="vendor-title text-lg md:text-xl font-bold">All Request Type</h2>
                        <p class="vendor-subtitle text-xs md:text-sm mt-1">Manage and view all system Request Type</p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 md:gap-3">

    {{-- Search Input --}}
    <div class="relative flex-1">
        <input type="text" id="table-search" placeholder="Search Request Type..."
            class="search-input w-full pl-10 pr-4 py-2 border rounded-lg text-sm">
        <svg class="search-icon absolute left-3 top-2.5 w-5 h-5" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </div>

    {{-- Create Vendor Button --}}
    <a href="{{ route('createrequesttype') }}"
        class="inline-flex items-center justify-center gap-2 px-4 py-2
               bg-blue-600 hover:bg-blue-700
               text-white text-sm font-medium
               rounded-lg shadow-sm transition">

        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-4 h-4"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 4v16m8-8H4" />
        </svg>

        Create Request Type
    </a>

</div>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="p-4 md:p-6">

                {{-- Loading State --}}
                <div id="loading-state" class="flex items-center justify-center py-12">
                    <div class="text-center">
                        <svg class="animate-spin h-10 w-10 text-blue-500 mx-auto mb-4" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <p class="text-sm">Loading Request Type...</p>
                    </div>
                </div>

                {{-- Desktop Table View --}}
                <div id="users-table-wrapper" class="overflow-x-auto -mx-4 md:mx-0" style="display: none;">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full" id="users-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Request Type Name</th>
                                        <th class="text-center">Code</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Mobile Cards View --}}
                <div id="mobile-cards-view" style="display: none;">
                    <div id="mobile-cards-container"></div>
                    <div id="mobile-pagination"></div>
                    <div id="mobile-info" class="mobile-info-text"></div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
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
        </script>

        <script>
            $(function() {
                var table = $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    ajax: "{{ route('requesttypes.requesttypes') }}",
                    columns: [
                        { data: 'request_type_name',          name: 'request_type_name',          className: 'text-center' },
                        { data: 'code',          name: 'code',          className: 'text-center' },
                      
                        { data: 'action',               name: 'action',               orderable: false, searchable: false, className: 'text-center' },
                    ],
                    language: {
                        lengthMenu: "_MENU_",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "Showing 0 to 0 of 0 entries",
                        infoFiltered: "(filtered from _MAX_ total entries)",
                        paginate: {
                            first: "First",
                            last: "Last",
                            next: "Next",
                            previous: "Prev"
                        }
                    },
                    pageLength: 10,
                    dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"<"length-wrapper"l><"info-wrapper"i>>rtip',
                    initComplete: function() {
                        $('#loading-state').hide();
                        $('#users-table-wrapper').fadeIn();
                        renderMobileCards();
                    },
                    drawCallback: function() {
                        if ($(window).width() < 768) {
                            renderMobileCards();
                        }
                    }
                });

                // Custom search
                $('#table-search').on('keyup', function() {
                    table.search(this.value).draw();
                });

                // Render mobile cards
                function renderMobileCards() {
                    if ($(window).width() >= 768) return;

                    var data = table.rows({ page: 'current' }).data();
                    var container = $('#mobile-cards-container');
                    container.empty();

                    if (data.length === 0) {
                        container.html('<div class="text-center py-8" style="color:var(--text-secondary)">No vendors found</div>');
                        return;
                    }

                    data.each(function(requesttype) {
                        var initials = requesttype.request_type_name
                            ? requesttype.request_type_name.substring(0, 2).toUpperCase()
                            : 'VN';

                        var card = `
                            <div class="user-card">
                                <div class="user-card-header">
                                    <div class="user-card-avatar">${initials}</div>
                                    <div class="user-card-title">
                                        <div class="user-card-name">Name : ${requesttype.request_type_name || 'N/A'}</div>
                                        <div class="user-card-name">Code : ${requesttype.code || 'N/A'}</div>
                                        </div>
                                </div>
                               
                                <div class="user-card-actions">
                                    ${vendor.action}
                                </div>
                            </div>
                        `;
                        container.append(card);
                    });

                    renderMobilePagination();
                }

                // Mobile pagination
                function renderMobilePagination() {
                    var info = table.page.info();
                    var pagination = $('#mobile-pagination');
                    pagination.empty();

                    var prevBtn = $('<button class="mobile-page-btn">Prev</button>');
                    if (info.page === 0) prevBtn.prop('disabled', true);
                    prevBtn.on('click', function() { table.page('previous').draw('page'); });
                    pagination.append(prevBtn);

                    var pageInfo = $(`<span class="mobile-page-btn active">${info.page + 1} / ${info.pages}</span>`);
                    pagination.append(pageInfo);

                    var nextBtn = $('<button class="mobile-page-btn">Next</button>');
                    if (info.page >= info.pages - 1) nextBtn.prop('disabled', true);
                    nextBtn.on('click', function() { table.page('next').draw('page'); });
                    pagination.append(nextBtn);

                    $('#mobile-info').text(`Showing ${info.start + 1} to ${info.end} of ${info.recordsTotal} entries`);
                }

                $(window).on('resize', function() {
                    if ($(window).width() < 768) renderMobileCards();
                });
            });
        </script>
    @endpush
@endsection
    {{-- Statistics Cards --}}
        {{-- <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
            <div
                class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl md:rounded-2xl p-4 md:p-6 text-white shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-xs md:text-sm font-semibold opacity-90">Total Users</h3>
                    <svg class="w-6 h-6 md:w-8 md:h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <p class="text-2xl md:text-3xl font-bold mb-1" id="total-users"></p>
                <p class="text-blue-100 text-xs">Active accounts</p>
            </div>
            <div
                class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl md:rounded-2xl p-4 md:p-6 text-white shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-xs md:text-sm font-semibold opacity-90">Yang Maha Besar</h3>
                    <svg class="w-6 h-6 md:w-8 md:h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-2xl md:text-xl font-bold mb-1">Christopher Edwin Sirait, S.Kom</p>
                <p class="text-emerald-100 text-xs">~bukan sarjana kaleng"</p>
            </div>
            <div
                class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl md:rounded-2xl p-4 md:p-6 text-white shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-xs md:text-sm font-semibold opacity-90">1 Thessalonians 5:17</h3>
                    <svg class="w-6 h-6 md:w-8 md:h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2v20M7 7h10" />
                    </svg>

                </div>
                <p class="text-2xl md:text-3xl font-bold mb-1">pray without ceasing</p>
                <p class="text-purple-100 text-xs">Christ is King!</p>
            </div>
            <div
                class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl md:rounded-2xl p-4 md:p-6 text-white shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-xs md:text-sm font-semibold opacity-90">Administrators</h3>
                    <svg class="w-6 h-6 md:w-8 md:h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
                <p class="text-2xl md:text-3xl font-bold mb-1">Edwin Sirait</p>
                <p class="text-orange-100 text-xs">namanya juga yang buat ya mau gimana</p>
            </div>
        </div> --}}