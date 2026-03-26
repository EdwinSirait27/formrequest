@extends('layouts.app')
@section('title', 'Request Form')
@section('header', 'Request Form List')
@section('subtitle', 'Manage Request Form')
@section('content')
    <style>
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
            /* text-transform: uppercase; */
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
            /* text-transform: uppercase; */
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

        #loading-state p {
            color: var(--text-secondary);
        }

        .divide-themed {
            border-color: var(--border-row);
        }

        .table-body-bg {
            background-color: var(--bg-table-body);
        }

        #users-table th {
            text-align: center;
        }

        /* select 2 */
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
    @role('admin')

    <div class="space-y-4 md:space-y-6">
        <div class="vendor-card-container rounded-xl md:rounded-2xl shadow-lg border overflow-hidden">
            <div class="vendor-card-header px-4 py-4 md:px-6 md:py-5 border-b">
                <div class="flex flex-col gap-3 md:gap-4">
                    <div>
                        <h2 class="vendor-title text-lg md:text-xl font-bold">All Request Form</h2>
                        <p class="vendor-subtitle text-xs md:text-sm mt-1">Manage and view all system request Form</p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 md:gap-3">
            
                        <select id="request-type-filter" class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                            <option value="">All Request Types</option>
                            @foreach ($requesttypes as $requesttype)
                                <option value="{{ $requesttype }}">{{ $requesttype }}</option>
                            @endforeach
                        </select>
                        <select id="vendor-filter" class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                            <option value="">All Vendors</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor }}">{{ $vendor }}</option>
                            @endforeach
                        </select>
                        <select id="company-filter" class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                            <option value="">All Companies</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company }}">{{ $company }}</option>
                            @endforeach
                        </select>
                        
                         <label for="request_date" class="text-xs text-slate-300">Request Date</label>

                        <input type="date" id="request_date" placeholder="YYYY-MM-DD"
                            class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                        <label for="deadline" class="text-xs text-slate-300">Deadline</label>
                        <input placeholder="YYYY-MM-DD" type="date" id="deadline"
                            class="w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">

                        <select id="status-filter" class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                            <option value="">All Statuses</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                        <div class="flex gap-2">
                            <button id="btnFilter"class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                                Apply
                            </button>
                            <a href="{{ url()->current() }}" class="text-red-400 py-2">Reset</a>
                        </div>
                        <!-- SEARCH -->
                        <div class="relative flex-1">
                            <input type="text" id="table-search" placeholder="Search requests..."
                                class="search-input w-full pl-10 pr-4 py-2 border rounded-lg text-sm">

                            <svg class="search-icon absolute left-3 top-2.5 w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0
                                    7 7 0 0114 0z">
                                </path>

                            </svg>
                        </div>

                        <!-- BUTTON -->
                        <a href="{{ route('createrequest') }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2
        bg-blue-600 hover:bg-blue-700
        text-white text-sm font-medium
        rounded-lg shadow-sm transition">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">

                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>

                            Create Request
                        </a>

                    </div>
                </div>
            </div>

            <div class="p-4 md:p-6">

                <div id="loading-state" class="flex items-center justify-center py-12">
                    <div class="text-center">
                        <svg class="animate-spin h-10 w-10 text-blue-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <p class="text-sm">Loading request...</p>
                    </div>
                </div>

                <div id="users-table-wrapper" class="overflow-x-auto -mx-4 md:mx-0" style="display: none;">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full" id="users-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Document Number</th>
                                        <th class="text-center">Companies</th>
                                        <th class="text-center">Request Type</th>
                                        <th class="text-center">Towards</th>
                                        <th class="text-center">User</th>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Request Date</th>
                                        <th class="text-center">Deadline</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="mobile-cards-view" style="display: none;">
                    <div id="mobile-cards-container"></div>
                    <div id="mobile-pagination"></div>
                    <div id="mobile-info" class="mobile-info-text"></div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
       
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
           <script>
              document.addEventListener('DOMContentLoaded', function() {
                    flatpickr("#request_date", {
                        dateFormat: "Y-m-d",
                        defaultDate: "{{ request('request_date') }}",
                        allowInput: true
                    });
                });
                document.addEventListener('DOMContentLoaded', function() {
                    flatpickr("#deadline", {
                        dateFormat: "Y-m-d",
                        defaultDate: "{{ request('deadline') }}",
                        allowInput: true
                    });
                });
            </script>
        <script>
            $(document).ready(function() {
                $('#request-type-filter').select2({
                    placeholder: "All Types...",
                    allowClear: false
                });
            });
            $(document).ready(function() {
                $('#vendor-filter').select2({
                    placeholder: "All Vendors...",
                    allowClear: true
                });
            });
            $(document).ready(function() {
                $('#company-filter').select2({
                    placeholder: "All Companies...",
                    allowClear: true
                });
            });
            $(document).ready(function() {
                $('#status-filter').select2({
                    placeholder: "All Statuses...",
                    allowClear: true
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
        </script>

        <script>
            $(function() {
                var table = $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                  dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"' +
     '<"flex items-center gap-2"lB>' +
     '<"info-wrapper"i>' +
     '>' +
     'rt' +
     '<"flex justify-between items-center mt-4"ip>',
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        title: 'All Form Request',
                        filename: 'All Form Request',
                        className: 'bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm',
                        exportOptions: {
    columns: ':not(.no-export)'
}
                        
                    }],
                  
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    ajax: {
    url: "{{ route('requestsdata') }}", // sesuaikan nama route Anda
    data: function(d) {
        d.request_type_name = $('#request-type-filter').val();
        d.name       = $('#company-filter').val();
        d.vendor_name       = $('#vendor-filter').val();
        d.request_date      = $('#request_date').val();
        d.deadline          = $('#deadline').val();
        d.status            = $('#status-filter').val();
    }
},
columns: [
    {
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        width: '5%',
        className: 'text-center',
        orderable: false,
        searchable: false
    },
    {
        data: 'document_number',
        name: 'document_number',
        className: 'text-center'
    },
    {
        data: 'name',
        name: 'name',
        className: 'text-center'
    },
    {
        data: 'request_type_name',
        name: 'request_type_name',
        className: 'text-center'
    },
    {
        data: 'vendor_name',
        name: 'vendor_name',
        className: 'text-center'
    },
    {
        data: 'employee_name',
        name: 'employee_name',
        className: 'text-center',
                                orderable: false,
                                searchable: false
    },
    {
        data: 'title',
        name: 'title',
        className: 'text-center'
    },
    {
        data: 'request_date',
        name: 'request_date',
        className: 'text-center'
    },
    {
        data: 'deadline',
        name: 'deadline',
        className: 'text-center'
    },
    {
        data: 'status',
        name: 'status',
        width: '10%',
        className: 'text-center',
        render: function(data, type, row) {
            if (!data) return '-';

            let status = data.toLowerCase();
            let badgeClass = 'bg-slate-500 text-white';

            if (status === 'approved') {
                badgeClass = 'bg-green-600 text-white';
            } else if (status === 'pending') {
                badgeClass = 'bg-yellow-500 text-white';
            } else if (status === 'rejected') {
                badgeClass = 'bg-red-500 text-white';
            } else if (status === 'on progress') {
                badgeClass = 'bg-blue-500 text-white';
            }

            return `<span class="px-3 py-1 rounded-full text-xs font-semibold ${badgeClass}">${data}</span>`;
        }
    },
    {
        data: 'action',
        name: 'action',
        className: 'text-center no-export',
        orderable: false,
        searchable: false
    }
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
                    // dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"<"length-wrapper"l><"info-wrapper"i>>rtip',
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
                $('#btnFilter').on('click', function() {
                    table.ajax.reload();
                });
                $('#btnReset').click(function() {
                    $('#bank-name-filter').val(null).trigger('change');
                    $('#transfer-filter').val(null).trigger('change');
                    $('#type-filter').val(null).trigger('change');
                    $('#company-filter').val(null).trigger('change');
                    $('#status-filter').val(null).trigger('change');
                    table.ajax.reload();
                });

                $('#table-search').on('keyup', function() {
                    table.search(this.value).draw();
                });

                function renderMobileCards() {
                    if ($(window).width() >= 768) return;

                    var data = table.rows({
                        page: 'current'
                    }).data();
                    var container = $('#mobile-cards-container');
                    container.empty();

                    if (data.length === 0) {
                        container.html(
                            '<div class="text-center py-8" style="color:var(--text-secondary)">No Form Requests found</div>'
                        );
                        return;
                    }

                    // data.each(function(request) {
                    //     var initials = request.user.employee.employee_name ?
                    //         request.user.employee.employee_name.substring(0, 2).toUpperCase() :
                    //         'VN';

                    //     var card = `
                    //         <div class="user-card">
                    //             <div class="user-card-header">
                    //                 <div class="user-card-avatar">${initials}</div>
                    //                 <div class="user-card-title">
                    //                     <div class="user-card-name">Name : ${request.user.employee_name || 'N/A'}</div>
                    //                     <div class="user-card-username">Document Number : ${request.document_number || '-'}</div>
                    //                 </div>
                    //             </div>
                    //             <div class="user-card-body">
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Company :</div>
                    //                     <div class="user-card-value">${request.company && request.company.name ? request.company.name : '-'}</div>
                                        
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Request Type :</div>
                    //                     <div class="user-card-value">${request.requesttype.request_type_name || 'N/A'}</div>
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Title Request</div>
                    //                     <div class="user-card-value">${request.title || 'N/A'}</div>
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Towards</div>
                    //                     <div class="user-card-value">${request.vendor.vendor_name || 'N/A'}</div>
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Request Date</div>
                    //                     <div class="user-card-value">${request.request_date || 'N/A'}</div>
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Deadline</div>
                    //                     <div class="user-card-value">${request.deadline || 'N/A'}</div>
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Transfer By</div>
                    //                     <div class="user-card-value">
                    //                         <span class="user-card-badge">${request.transfer || '-'}</span>
                    //                     </div>
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Status</div>
                    //                         <div class="user-card-value">
                    //                             ${
                    //                                 request.status 
                    //                                     ? `<span class="px-3 py-1 rounded-full text-xs font-semibold ${
                    //                                             request.status.toLowerCase() === 'active'
                    //                                             ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400'
                    //                                             : 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400'
                    //                                         }">
                    //                                             ${requedt.status}
                    //                                            </span>`
                    //                                 : 'N/A'
                    //                             }
                    //                 </div>
                    //                 </div>
                    //                 </div>
                    //             <div class="user-card-actions">
                    //                 ${request.action}
                    //             </div>
                    //         </div>
                    //     `;
                    //     container.append(card);
                    // });
                    data.each(function(request) {

    var initials = request.user?.employee?.employee_name
        ? request.user.employee.employee_name.substring(0, 2).toUpperCase()
        : 'VN';

    var card = `
        <div class="user-card">
            <div class="user-card-header">
                <div class="user-card-avatar">${initials}</div>
                <div class="user-card-title">
                    <div class="user-card-name">Name : ${request.employee_name || 'N/A'}</div>
                    <div class="user-card-username">Document Number : ${request.document_number || '-'}</div>
                </div>
            </div>

            <div class="user-card-body">
                <div class="user-card-field">
                    <div class="user-card-label">Company :</div>
                    <div class="user-card-value">${request.company?.name || '-'}</div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Request Type :</div>
                    <div class="user-card-value">${request.requesttype?.request_type_name || 'N/A'}</div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Title Request</div>
                    <div class="user-card-value">${request.title || 'N/A'}</div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Towards</div>
                    <div class="user-card-value">${request.vendor?.vendor_name || 'N/A'}</div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Request Date</div>
                    <div class="user-card-value">${request.request_date || 'N/A'}</div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Deadline</div>
                    <div class="user-card-value">${request.deadline || 'N/A'}</div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Transfer By</div>
                    <div class="user-card-value">
                        <span class="user-card-badge">${request.transfer || '-'}</span>
                    </div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Status</div>
                    <div class="user-card-value">
                        ${
                            request.status 
                                ? `<span class="px-3 py-1 rounded-full text-xs font-semibold ${
                                        request.status.toLowerCase() === 'active'
                                        ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400'
                                        : 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400'
                                    }">
                                        ${request.status}
                                   </span>`
                                : 'N/A'
                        }
                    </div>
                </div>
            </div>

            <div class="user-card-actions">
                ${request.action}
            </div>
        </div>
    `;

    container.append(card);
});
                    renderMobilePagination();
                }

                function renderMobilePagination() {
                    var info = table.page.info();
                    var pagination = $('#mobile-pagination');
                    pagination.empty();
                    var prevBtn = $('<button class="mobile-page-btn">Prev</button>');
                    if (info.page === 0) prevBtn.prop('disabled', true);
                    prevBtn.on('click', function() {
                        table.page('previous').draw('page');
                    });
                    pagination.append(prevBtn);
                    var pageInfo = $(`<span class="mobile-page-btn active">${info.page + 1} / ${info.pages}</span>`);
                    pagination.append(pageInfo);
                    var nextBtn = $('<button class="mobile-page-btn">Next</button>');
                    if (info.page >= info.pages - 1) nextBtn.prop('disabled', true);
                    nextBtn.on('click', function() {
                        table.page('next').draw('page');
                    });
                    pagination.append(nextBtn);
                    $('#mobile-info').text(`Showing ${info.start + 1} to ${info.end} of ${info.recordsTotal} entries`);
                }
                $(window).on('resize', function() {
                    if ($(window).width() < 768) renderMobileCards();
                });
            });
        </script>
    @endpush
    @endrole
     @role('manager')

    <div class="space-y-4 md:space-y-6">
        <div class="vendor-card-container rounded-xl md:rounded-2xl shadow-lg border overflow-hidden">
            <div class="vendor-card-header px-4 py-4 md:px-6 md:py-5 border-b">
                <div class="flex flex-col gap-3 md:gap-4">
                    <div>
                        <h2 class="vendor-title text-lg md:text-xl font-bold">All Request Form</h2>
                        <p class="vendor-subtitle text-xs md:text-sm mt-1">Manage and view all system request Form</p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 md:gap-3">
            
                        <select id="request-type-filter" class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                            <option value="">All Request Types</option>
                            @foreach ($requesttypes as $requesttype)
                                <option value="{{ $requesttype }}">{{ $requesttype }}</option>
                            @endforeach
                        </select>
                        <select id="vendor-filter" class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                            <option value="">All Vendors</option>
                            @foreach ($vendors as $vendor)
                                <option value="{{ $vendor }}">{{ $vendor }}</option>
                            @endforeach
                        </select>
                        <select id="company-filter" class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                            <option value="">All Companies</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company }}">{{ $company }}</option>
                            @endforeach
                        </select>
                        
                         <label for="request_date" class="text-xs text-slate-300">Request Date</label>

                        <input type="date" id="request_date" placeholder="YYYY-MM-DD"
                            class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                        <label for="deadline" class="text-xs text-slate-300">Deadline</label>
                        <input placeholder="YYYY-MM-DD" type="date" id="deadline"
                            class="w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">

                        <select id="status-filter" class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                            <option value="">All Statuses</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                        <div class="flex gap-2">
                            <button id="btnFilter"class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                                Apply
                            </button>
                            <a href="{{ url()->current() }}" class="text-red-400 py-2">Reset</a>
                        </div>
                        <!-- SEARCH -->
                        <div class="relative flex-1">
                            <input type="text" id="table-search" placeholder="Search requests..."
                                class="search-input w-full pl-10 pr-4 py-2 border rounded-lg text-sm">

                            <svg class="search-icon absolute left-3 top-2.5 w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0
                                    7 7 0 0114 0z">
                                </path>

                            </svg>
                        </div>

                        <!-- BUTTON -->
                        <a href="{{ route('createrequest') }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2
        bg-blue-600 hover:bg-blue-700
        text-white text-sm font-medium
        rounded-lg shadow-sm transition">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">

                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>

                            Create Request
                        </a>

                    </div>
                </div>
            </div>

            <div class="p-4 md:p-6">

                <div id="loading-state" class="flex items-center justify-center py-12">
                    <div class="text-center">
                        <svg class="animate-spin h-10 w-10 text-blue-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <p class="text-sm">Loading request...</p>
                    </div>
                </div>

                <div id="users-table-wrapper" class="overflow-x-auto -mx-4 md:mx-0" style="display: none;">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full" id="users-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Document Number</th>
                                        <th class="text-center">Companies</th>
                                        <th class="text-center">Request Type</th>
                                        <th class="text-center">Towards</th>
                                        <th class="text-center">User</th>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Request Date</th>
                                        <th class="text-center">Deadline</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="mobile-cards-view" style="display: none;">
                    <div id="mobile-cards-container"></div>
                    <div id="mobile-pagination"></div>
                    <div id="mobile-info" class="mobile-info-text"></div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
       
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
           <script>
              document.addEventListener('DOMContentLoaded', function() {
                    flatpickr("#request_date", {
                        dateFormat: "Y-m-d",
                        defaultDate: "{{ request('request_date') }}",
                        allowInput: true
                    });
                });
                document.addEventListener('DOMContentLoaded', function() {
                    flatpickr("#deadline", {
                        dateFormat: "Y-m-d",
                        defaultDate: "{{ request('deadline') }}",
                        allowInput: true
                    });
                });
            </script>
        <script>
            $(document).ready(function() {
                $('#request-type-filter').select2({
                    placeholder: "All Types...",
                    allowClear: false
                });
            });
            $(document).ready(function() {
                $('#vendor-filter').select2({
                    placeholder: "All Vendors...",
                    allowClear: true
                });
            });
            $(document).ready(function() {
                $('#company-filter').select2({
                    placeholder: "All Companies...",
                    allowClear: true
                });
            });
            $(document).ready(function() {
                $('#status-filter').select2({
                    placeholder: "All Statuses...",
                    allowClear: true
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
        </script>

        <script>
            $(function() {
                var table = $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                  dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"' +
     '<"flex items-center gap-2"lB>' +
     '<"info-wrapper"i>' +
     '>' +
     'rt' +
     '<"flex justify-between items-center mt-4"ip>',
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        title: 'All Form Request',
                        filename: 'All Form Request',
                        className: 'bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm',
                        exportOptions: {
    columns: ':not(.no-export)'
}
                        
                    }],
                  
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    ajax: {
    url: "{{ route('requestsdata') }}", // sesuaikan nama route Anda
    data: function(d) {
        d.request_type_name = $('#request-type-filter').val();
        d.name       = $('#company-filter').val();
        d.vendor_name       = $('#vendor-filter').val();
        d.request_date      = $('#request_date').val();
        d.deadline          = $('#deadline').val();
        d.status            = $('#status-filter').val();
    }
},
columns: [
    {
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        width: '5%',
        className: 'text-center',
        orderable: false,
        searchable: false
    },
    {
        data: 'document_number',
        name: 'document_number',
        className: 'text-center'
    },
    {
        data: 'name',
        name: 'name',
        className: 'text-center'
    },
    {
        data: 'request_type_name',
        name: 'request_type_name',
        className: 'text-center'
    },
    {
        data: 'vendor_name',
        name: 'vendor_name',
        className: 'text-center'
    },
    {
        data: 'employee_name',
        name: 'employee_name',
        className: 'text-center',
                                orderable: false,
                                searchable: false
    },
    {
        data: 'title',
        name: 'title',
        className: 'text-center'
    },
    {
        data: 'request_date',
        name: 'request_date',
        className: 'text-center'
    },
    {
        data: 'deadline',
        name: 'deadline',
        className: 'text-center'
    },
    {
        data: 'status',
        name: 'status',
        width: '10%',
        className: 'text-center',
        render: function(data, type, row) {
            if (!data) return '-';

            let status = data.toLowerCase();
            let badgeClass = 'bg-slate-500 text-white';

            if (status === 'approved') {
                badgeClass = 'bg-green-600 text-white';
            } else if (status === 'pending') {
                badgeClass = 'bg-yellow-500 text-white';
            } else if (status === 'rejected') {
                badgeClass = 'bg-red-500 text-white';
            } else if (status === 'on progress') {
                badgeClass = 'bg-blue-500 text-white';
            }

            return `<span class="px-3 py-1 rounded-full text-xs font-semibold ${badgeClass}">${data}</span>`;
        }
    },
    {
        data: 'action',
        name: 'action',
        className: 'text-center no-export',
        orderable: false,
        searchable: false
    }
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
                    // dom: '<"flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4"<"length-wrapper"l><"info-wrapper"i>>rtip',
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
                $('#btnFilter').on('click', function() {
                    table.ajax.reload();
                });
                $('#btnReset').click(function() {
                    $('#bank-name-filter').val(null).trigger('change');
                    $('#transfer-filter').val(null).trigger('change');
                    $('#type-filter').val(null).trigger('change');
                    $('#company-filter').val(null).trigger('change');
                    $('#status-filter').val(null).trigger('change');
                    table.ajax.reload();
                });

                $('#table-search').on('keyup', function() {
                    table.search(this.value).draw();
                });

                function renderMobileCards() {
                    if ($(window).width() >= 768) return;

                    var data = table.rows({
                        page: 'current'
                    }).data();
                    var container = $('#mobile-cards-container');
                    container.empty();

                    if (data.length === 0) {
                        container.html(
                            '<div class="text-center py-8" style="color:var(--text-secondary)">No Form Requests found</div>'
                        );
                        return;
                    }

                    // data.each(function(request) {
                    //     var initials = request.user.employee.employee_name ?
                    //         request.user.employee.employee_name.substring(0, 2).toUpperCase() :
                    //         'VN';

                    //     var card = `
                    //         <div class="user-card">
                    //             <div class="user-card-header">
                    //                 <div class="user-card-avatar">${initials}</div>
                    //                 <div class="user-card-title">
                    //                     <div class="user-card-name">Name : ${request.user.employee_name || 'N/A'}</div>
                    //                     <div class="user-card-username">Document Number : ${request.document_number || '-'}</div>
                    //                 </div>
                    //             </div>
                    //             <div class="user-card-body">
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Company :</div>
                    //                     <div class="user-card-value">${request.company && request.company.name ? request.company.name : '-'}</div>
                                        
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Request Type :</div>
                    //                     <div class="user-card-value">${request.requesttype.request_type_name || 'N/A'}</div>
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Title Request</div>
                    //                     <div class="user-card-value">${request.title || 'N/A'}</div>
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Towards</div>
                    //                     <div class="user-card-value">${request.vendor.vendor_name || 'N/A'}</div>
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Request Date</div>
                    //                     <div class="user-card-value">${request.request_date || 'N/A'}</div>
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Deadline</div>
                    //                     <div class="user-card-value">${request.deadline || 'N/A'}</div>
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Transfer By</div>
                    //                     <div class="user-card-value">
                    //                         <span class="user-card-badge">${request.transfer || '-'}</span>
                    //                     </div>
                    //                 </div>
                    //                 <div class="user-card-field">
                    //                     <div class="user-card-label">Status</div>
                    //                         <div class="user-card-value">
                    //                             ${
                    //                                 request.status 
                    //                                     ? `<span class="px-3 py-1 rounded-full text-xs font-semibold ${
                    //                                             request.status.toLowerCase() === 'active'
                    //                                             ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400'
                    //                                             : 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400'
                    //                                         }">
                    //                                             ${requedt.status}
                    //                                            </span>`
                    //                                 : 'N/A'
                    //                             }
                    //                 </div>
                    //                 </div>
                    //                 </div>
                    //             <div class="user-card-actions">
                    //                 ${request.action}
                    //             </div>
                    //         </div>
                    //     `;
                    //     container.append(card);
                    // });
                    data.each(function(request) {

    var initials = request.user?.employee?.employee_name
        ? request.user.employee.employee_name.substring(0, 2).toUpperCase()
        : 'VN';

    var card = `
        <div class="user-card">
            <div class="user-card-header">
                <div class="user-card-avatar">${initials}</div>
                <div class="user-card-title">
                    <div class="user-card-name">Name : ${request.employee_name || 'N/A'}</div>
                    <div class="user-card-username">Document Number : ${request.document_number || '-'}</div>
                </div>
            </div>

            <div class="user-card-body">
                <div class="user-card-field">
                    <div class="user-card-label">Company :</div>
                    <div class="user-card-value">${request.company?.name || '-'}</div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Request Type :</div>
                    <div class="user-card-value">${request.requesttype?.request_type_name || 'N/A'}</div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Title Request</div>
                    <div class="user-card-value">${request.title || 'N/A'}</div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Towards</div>
                    <div class="user-card-value">${request.vendor?.vendor_name || 'N/A'}</div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Request Date</div>
                    <div class="user-card-value">${request.request_date || 'N/A'}</div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Deadline</div>
                    <div class="user-card-value">${request.deadline || 'N/A'}</div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Transfer By</div>
                    <div class="user-card-value">
                        <span class="user-card-badge">${request.transfer || '-'}</span>
                    </div>
                </div>

                <div class="user-card-field">
                    <div class="user-card-label">Status</div>
                    <div class="user-card-value">
                        ${
                            request.status 
                                ? `<span class="px-3 py-1 rounded-full text-xs font-semibold ${
                                        request.status.toLowerCase() === 'active'
                                        ? 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-400'
                                        : 'bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400'
                                    }">
                                        ${request.status}
                                   </span>`
                                : 'N/A'
                        }
                    </div>
                </div>
            </div>

            <div class="user-card-actions">
                ${request.action}
            </div>
        </div>
    `;

    container.append(card);
});
                    renderMobilePagination();
                }

                function renderMobilePagination() {
                    var info = table.page.info();
                    var pagination = $('#mobile-pagination');
                    pagination.empty();
                    var prevBtn = $('<button class="mobile-page-btn">Prev</button>');
                    if (info.page === 0) prevBtn.prop('disabled', true);
                    prevBtn.on('click', function() {
                        table.page('previous').draw('page');
                    });
                    pagination.append(prevBtn);
                    var pageInfo = $(`<span class="mobile-page-btn active">${info.page + 1} / ${info.pages}</span>`);
                    pagination.append(pageInfo);
                    var nextBtn = $('<button class="mobile-page-btn">Next</button>');
                    if (info.page >= info.pages - 1) nextBtn.prop('disabled', true);
                    nextBtn.on('click', function() {
                        table.page('next').draw('page');
                    });
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
