@extends('layouts.app')
@section('title', 'Create Request Form')
@section('header', 'Create Request Form')
@section('subtitle', 'Create Request Form')
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
                    <h3 class="text-sm font-semibold text-amber-400 mb-1">Create Request Form</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Create the request form information below. Fields marked with <span class="text-red-400">*</span>
                        are required.
                    </p>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('storerequest') }}"class="space-y-5">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="company_id" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Company Name<span class="text-red-400">*</span>
                    </label>
                    @if ($isMainCompany)
                        <select id="company_id" name="company_id"
                            class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                            <option value="">Choose Companies</option>
                            @foreach ($companies as $id => $name)
                                <option value="{{ $id }}"
                                    {{ $id == old('company_id', $userCompanyId) ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" class="form-input w-full px-4 py-3 rounded-xl"
                            value="{{ $companies[$userCompanyId] ?? '-' }}" readonly>

                        <input type="hidden" name="company_id" value="{{ $userCompanyId }}">
                    @endif
                    @error('company_id')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="request_type_id" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Request Type<span class="text-red-400">*</span>
                </label>
                <select id="request_type_id" name="request_type_id"
                    class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm" required>
                    <option value="">Choose Request Type</option>

                    @foreach ($requesttypes as $type)
                        <option value="{{ $type->id }}" data-code="{{ $type->code }}"
                            {{ old('request_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->request_type_name }}
                        </option>
                    @endforeach
                </select>
                @error('request_type_id')
                    <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="title" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Title Request<span class="text-red-400">*</span>
                    </label>
                    <input type="text" id="title" name="title"class="form-input w-full px-4 py-3 rounded-xl"
                        value="{{ old('title') }}" placeholder="butuh segera untuk bla bla bla" required>
                    @error('title')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div id="vendor_wrapper">
                    <div>
                        <label for="vendor_id" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                            <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            Vendor<span class="text-red-400">*</span>
                        </label>
                        <select id="vendor_id" name="vendor_id"
                            class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                            <option value="">Choose Vendor</option>
                            @foreach ($vendors as $id => $name)
                                <option value="{{ $id }}" {{ old('vendor_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('vendor_id')
                            <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
            <div id="assets_wrapper">
                <div>
                    <label for="assets" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Assets<span class="text-red-400">*</span>
                    </label>
                    <select id="assets" name="assets"
                        class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                        <option value="">Choose Assets</option>
                        @foreach ($assets as $key => $value)
                            <option value="{{ $key }}" {{ old('assets') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('assets')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div id="capex_type_wrapper">
                <div>
                    <label for="capex_type_id" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Capex Type<span class="text-red-400">*</span>
                    </label>
                    <select id="capex_type_id" name="capex_type_id"
                        class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                        <option value="">Choose CAPEX Type</option>
                        @foreach ($capextypes as $item)
                            @if ($item->user?->employee)
                                <option value="{{ $item->id }}">
                                    {{ $item->code }} - {{ $item->user->employee->employee_name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('assets')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="request_date" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Request Date<span class="text-red-400">*</span>
                    </label>
                    <input type="date" id="request_date"
                        name="request_date"class="form-input w-full px-4 py-3 rounded-xl"
                        value="{{ old('request_date') }}" placeholder="YYYY-MM-DD" required>
                    @error('request_date')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="deadline" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Deadline<span class="text-red-400">*</span>
                    </label>
                    <input type="date" id="deadline" name="deadline"class="form-input w-full px-4 py-3 rounded-xl"
                        value="{{ old('deadline') }}" placeholder="YYYY-MM-DD" required>
                    @error('deadline')
                        <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <h3 class="text-sm font-semibold text-slate-300 mb-3">
                    Request Items <span class="text-red-400">*</span>
                </h3>

                <div class="overflow-x-auto" id="table-container">
                </div>

                <button type="button" id="add-row"
                    class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                    + Add Item
                </button>
            </div>
            <div>
                <label class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    Link Reference / Attachments
                </label>

                <div id="links-wrapper" class="space-y-2">
                    <div class="flex gap-2 link-row">
                        <input type="text" name="links[0][link]" class="form-input w-full px-4 py-3 rounded-xl"
                            placeholder="link referal product or link product photo">

                        <button type="button" class="remove-link px-3 py-2 bg-red-500 text-white rounded-lg">
                            ✕
                        </button>
                    </div>
                </div>
                <button type="button" id="add-link"
                    class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                    + Add Links
                </button>

                @error('links.*.link')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <label for="notes" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Applicant Notes
            </label>
            <textarea id="notes" name="notes" class="form-input w-full px-4 py-3 rounded-xl"
                placeholder="butuh segera dan diperuntukkan bla bla bla" rows="4" required>{{ old('notes') }}</textarea>

            @error('notes')
                <p class="mt-1.5 text-xs text-red-400 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
    </div>
    <div class="flex gap-3 pt-2">
        <a href="{{ route('request') }}"
            class="flex-1 py-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 font-semibold rounded-xl
                       transition-all duration-200 flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back
        </a>
        <button type="submit"
            class="flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-500
                       hover:from-amber-600 hover:to-orange-600
                       text-white font-semibold rounded-xl
                       shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50
                       transition-all duration-200
                       hover:scale-[1.02] active:scale-[0.98]
                       flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Create Request
        </button>
    </div>

    </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
        let index = 0;

        function getCurrentCode() {
            let code = $('#request_type_id option:selected').data('code');
            return code || null;
        }

        function getUomOptions() {
            return @json($uoms);
        }
        const vendors = @json($vendors);

        function renderTable(code) {
            index = 0;

            if (code === 'CA') {
                $('#table-container').html(`
            <table class="w-full text-sm text-left border border-slate-700 rounded-xl">
                <thead>
                    <tr>
                        <th class="p-2">Item Name</th>
                        <th class="p-2">Specification</th>
                        <th class="p-2">Qty</th>
                        <th class="p-2">UOM</th>
                        <th class="p-2">Price</th>
                        <th class="p-2">Total</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody id="items-table"></tbody>
            </table>
        `);
            } else if (code === 'CAPEX') {
                $('#table-container').html(`
            <table class="w-full text-sm text-left border border-slate-700 rounded-xl">
                <thead>
                    <tr>
                       <th class="p-2">Item Name</th>
                        <th class="p-2">QTY</th>
                        <th class="p-2">Uoms</th>
                        <th class="p-2">Vendor I</th>
                        <th class="p-2">Vendor II</th>
                        <th class="p-2">Vendor III</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody id="items-table"></tbody>
            </table>
        `);
            } else if (code === 'PAYREQ') {
                $('#table-container').html(`
            <table class="w-full text-sm text-left border border-slate-700 rounded-xl">
                <thead>
                    <tr>
                        <th class="p-2">Item Name</th>
                        <th class="p-2">Specification</th>
                        <th class="p-2">Qty</th>
                        <th class="p-2">UOM</th>
                        <th class="p-2">Price</th>
                        <th class="p-2">Total</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody id="items-table"></tbody>
            </table>
        `);
            } else if (code === 'PR') {
                $('#table-container').html(`
            <table class="w-full text-sm text-left border border-slate-700 rounded-xl">
                <thead>
                    <tr>
                        <th class="p-2">Item Name</th>
                        <th class="p-2">Specification</th>
                        <th class="p-2">Qty</th>
                        <th class="p-2">UOM</th>
                        <th class="p-2">Price</th>
                        <th class="p-2">Total</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody id="items-table"></tbody>
            </table>
        `);
            } else if (code === 'RE') {
                $('#table-container').html(`
            <table class="w-full text-sm text-left border border-slate-700 rounded-xl">
                <thead>
                    <tr>
                        <th class="p-2">Item Name</th>
                        <th class="p-2">Specification</th>
                        <th class="p-2">Qty</th>
                        <th class="p-2">UOM</th>
                        <th class="p-2">Price</th>
                        <th class="p-2">Total</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody id="items-table"></tbody>
            </table>
        `);
            } else {
                $('#table-container').html('');
            }
        }

        /* =========================
           ROW CA
        ========================= */
        function createRowCA() {
            let uoms = getUomOptions();
            let uomOptions = '';

            uoms.forEach(u => {
                uomOptions += `<option value="${u}">${u}</option>`;
            });

            return `
    <tr>
        <td class="p-2">
            <input type="text" placeholder="items name" 
                name="items[${index}][item_name]" 
                class="w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <input type="text" placeholder="specification" 
                name="items[${index}][specification]" 
                class="w-full form-input rounded-lg px-2 py-1">
        </td>
        <td class="p-2">
            <input type="text" placeholder="5 / 0,5" 
                name="items[${index}][qty]" 
                class="qty w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <select name="items[${index}][uom]" 
                class="select2-uom w-full form-input rounded-lg px-2 py-1">
                ${uomOptions}
            </select>
        </td>
        <td class="p-2">
            <input type="text" placeholder="0" 
                name="items[${index}][price]" 
                class="price w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][total_price]" 
                class="total w-full form-input rounded-lg px-2 py-1" readonly>
        </td>
        <td class="p-2 text-center">
            <button type="button" class="remove-row text-red-500">X</button>
        </td>
    </tr>
    `;
        }

        function createRowPAYREQ() {
            let uoms = getUomOptions();
            let uomOptions = '';

            uoms.forEach(u => {
                uomOptions += `<option value="${u}">${u}</option>`;
            });

            return `
    <tr>
        <td class="p-2">
            <input type="text" placeholder="items name" 
                name="items[${index}][item_name]" 
                class="w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <input type="text" placeholder="specification" 
                name="items[${index}][specification]" 
                class="w-full form-input rounded-lg px-2 py-1">
        </td>
        <td class="p-2">
            <input type="text" placeholder="5 / 0,5" 
                name="items[${index}][qty]" 
                class="qty w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <select name="items[${index}][uom]" 
                class="select2-uom w-full form-input rounded-lg px-2 py-1">
                ${uomOptions}
            </select>
        </td>
        <td class="p-2">
            <input type="text" placeholder="0" 
                name="items[${index}][price]" 
                class="price w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][total_price]" 
                class="total w-full form-input rounded-lg px-2 py-1" readonly>
        </td>
        <td class="p-2 text-center">
            <button type="button" class="remove-row text-red-500">X</button>
        </td>
    </tr>
    `;
        }

        function createRowPR() {
            let uoms = getUomOptions();
            let uomOptions = '';

            uoms.forEach(u => {
                uomOptions += `<option value="${u}">${u}</option>`;
            });

            return `
    <tr>
        <td class="p-2">
            <input type="text" placeholder="items name" 
                name="items[${index}][item_name]" 
                class="w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <input type="text" placeholder="specification" 
                name="items[${index}][specification]" 
                class="w-full form-input rounded-lg px-2 py-1">
        </td>
        <td class="p-2">
            <input type="text" placeholder="5 / 0,5" 
                name="items[${index}][qty]" 
                class="qty w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <select name="items[${index}][uom]" 
                class="select2-uom w-full form-input rounded-lg px-2 py-1">
                ${uomOptions}
            </select>
        </td>
        <td class="p-2">
            <input type="text" placeholder="0" 
                name="items[${index}][price]" 
                class="price w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][total_price]" 
                class="total w-full form-input rounded-lg px-2 py-1" readonly>
        </td>
        <td class="p-2 text-center">
            <button type="button" class="remove-row text-red-500">X</button>
        </td>
    </tr>
    `;
        }

        function createRowRE() {
            let uoms = getUomOptions();
            let uomOptions = '';

            uoms.forEach(u => {
                uomOptions += `<option value="${u}">${u}</option>`;
            });

            return `
    <tr>
        <td class="p-2">
            <input type="text" placeholder="items name" 
                name="items[${index}][item_name]" 
                class="w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <input type="text" placeholder="specification" 
                name="items[${index}][specification]" 
                class="w-full form-input rounded-lg px-2 py-1">
        </td>
        <td class="p-2">
            <input type="text" placeholder="5 / 0,5" 
                name="items[${index}][qty]" 
                class="qty w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <select name="items[${index}][uom]" 
                class="select2-uom w-full form-input rounded-lg px-2 py-1">
                ${uomOptions}
            </select>
        </td>
        <td class="p-2">
            <input type="text" placeholder="0" 
                name="items[${index}][price]" 
                class="price w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][total_price]" 
                class="total w-full form-input rounded-lg px-2 py-1" readonly>
        </td>
        <td class="p-2 text-center">
            <button type="button" class="remove-row text-red-500">X</button>
        </td>
    </tr>
    `;
        }

        function createRowCAPEX() {
            const options = Object.entries(vendors)
                .map(([id, name]) => `<option value="${id}">${name}</option>`)
                .join('');
            let uoms = getUomOptions();
            let uomOptions = '';

            uoms.forEach(u => {
                uomOptions += `<option value="${u}">${u}</option>`;
            });
            const row = `
    <tr>
        {{-- Item Name --}}
        <td class="p-2">
            <input type="text" placeholder="Item Name" 
                name="items[${index}][item_name]" 
                class="w-full form-input rounded-lg px-2 py-1" required>
        </td>
        {{-- QTY --}}
        <td class="p-2">
            <input type="text" placeholder="5 / 0.5" 
                name="items[${index}][qty]" 
                class="qty w-full form-input rounded-lg px-2 py-1" required>
        </td>
         <td class="p-2">
            <select name="items[${index}][uom]" 
                class="select2-uom w-full form-input rounded-lg px-2 py-1">
                ${uomOptions}
            </select>
        </td>
        {{-- Vendor 1 --}}
        <td class="p-2">
            <select name="items[${index}][vendors][0][vendor_id]" 
                class="select2-vendor w-full rounded-lg px-2 py-1"required>
                <option value="">-- Vendor 1 --</option>
                ${options}
            </select>
            <input type="text" placeholder="Price" 
                name="items[${index}][vendors][0][price]" 
                class="price mt-1 w-full form-input rounded-lg px-2 py-1"required>
        </td>
        
        {{-- Vendor 2 --}}
        <td class="p-2">
            <select name="items[${index}][vendors][1][vendor_id]" 
                class="select2-vendor w-full rounded-lg px-2 py-1">
                <option value="">-- Vendor 2 --</option>
                ${options}
            </select>
            <input type="text" placeholder="Price" 
                name="items[${index}][vendors][1][price]" 
                class="price mt-1 w-full form-input rounded-lg px-2 py-1">
        </td>
        {{-- Vendor 3 --}}
        <td class="p-2">
            <select name="items[${index}][vendors][2][vendor_id]" 
                class="select2-vendor w-full rounded-lg px-2 py-1">
                <option value="">-- Vendor 3 --</option>
                ${options}
            </select>
            <input type="text" placeholder="Price" 
                name="items[${index}][vendors][2][price]" 
                class="price mt-1 w-full form-input rounded-lg px-2 py-1">
        </td>
        {{-- Action --}}
        <td class="p-2 text-center">
            <button type="button" class="remove-row text-red-500">X</button>
        </td>
    </tr>
    `;
            index++;
            return row;
        }
        /* =========================
           INIT
        ========================= */
        $(document).ready(function() {

            // Init Select2 request type
            $('#request_type_id').select2({
                placeholder: "Choose Request Type",
                allowClear: true,
                width: '100%'
            });
            $('#assets').select2({
                placeholder: "Choose Assets",
                allowClear: true,
                width: '100%'
            });
            $('#capex_type_id').select2({
                placeholder: "Choose Capex Type",
                allowClear: true,
                width: '100%'
            });
            $('#request_type_id').on('select2:select select2:clear', function() {
                let code = getCurrentCode();
                console.log('CODE:', code);
                renderTable(code);
            });
            let initCode = getCurrentCode();
            if (initCode) {
                renderTable(initCode);
            }
        });
        $('#add-row').click(function() {
            let code = getCurrentCode();
            if (!code) {
    toastr.error('Pilih request type dulu ya!');
    return;
}
            let row = '';
            if (code === 'CA') {
                row = createRowCA();
            } else if (code === 'CAPEX') {
                row = createRowCAPEX();
            } else {
                alert('Type tidak dikenali');
                return;
            }
            $('#items-table').append(row);
            index++;
            $('.select2-uom').select2({
                placeholder: "Choose",
                allowClear: true,
                width: '100%'
            });
            $('.select2-vendor').select2({
                placeholder: "Choose",
                allowClear: true,
                width: '100%'
            });
        });
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
        $(document).on('blur', '.price, .budget', function() {
            let input = $(this);
            let angka = parseAngka(input.val());
            if (angka > 0) {
                input.val(formatRibuan(angka));
            }
        });
        $(document).on('focus', '.price, .budget', function() {
            let input = $(this);
            let angka = parseAngka(input.val());
            if (angka > 0) {
                input.val(angka.toString().replace('.', ','));
            }
        });
        $(document).on('input', '.qty, .price', function() {
            let row = $(this).closest('tr');
            let qty = parseAngka(row.find('.qty').val());
            let price = parseAngka(row.find('.price').val());
            let total = qty * price;
            if (!isNaN(total)) {
                row.find('.total').val(formatRibuan(total));
            } else {
                row.find('.total').val('');
            }
        });

        function parseAngka(str) {
            if (!str) return 0;
            str = str.replace(/\./g, '').replace(',', '.');
            return parseFloat(str) || 0;
        }

        function formatRibuan(angka) {
            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(angka);
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#request_type_id').select2({
                placeholder: "Choose request Types...",
                allowClear: true,
                width: '100%'
            });
        });
        $(document).ready(function() {
            $('#vendor_id').select2({
                placeholder: "Choose Vendors...",
                allowClear: true,
                width: '100%'
            });
        });
        $(document).ready(function() {
            $('#company_id').select2({
                placeholder: "Choose Companies...",
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const vendorWrapper = document.getElementById('vendor_wrapper');
            const hideVendorTypes = ['CAPEX'];

            function toggleVendor() {
                const selected = $('#request_type_id').find(':selected');
                const code = selected.data('code');
                console.log('CODE:', code);
                if (code && hideVendorTypes.includes(code)) {
                    vendorWrapper.style.display = 'none';
                    $('#vendor_id').val(null).trigger('change');
                } else {
                    vendorWrapper.style.display = 'block';
                }
            }
            $('#request_type_id').on('change', toggleVendor);
            toggleVendor();
        });
        document.addEventListener('DOMContentLoaded', function() {
            const assetsWrapper = document.getElementById('assets_wrapper');
            const hideAssets = ['CA', 'PAYREQ', 'PR', 'RE'];

            function toggleAssets() {
                const selected = $('#request_type_id').find(':selected');
                const code = selected.data('code');
                console.log('CODE:', code);
                if (code && hideAssets.includes(code)) {
                    assetsWrapper.style.display = 'none';
                    $('#assets').val(null).trigger('change');
                } else {
                    assetsWrapper.style.display = 'block';
                }
            }
            $('#request_type_id').on('change', toggleAssets);
            toggleAssets();
        });
        // document.addEventListener('DOMContentLoaded', function() {
        //     const CapextypeWrapper = document.getElementById('capex_type_wrapper');
        //     const hideCapextype = ['CA', 'PAYREQ', 'PR', 'RE'];

        //     function toggleCapextype() {
        //         const selected = $('#capex_type_id').find(':selected');
        //         const code = selected.data('code');
        //         console.log('CODE:', code);
        //         if (code && hideCapextype.includes(code)) {
        //             CapextypeWrapper.style.display = 'none';
        //             $('#capex_type_id').val(null).trigger('change');
        //         } else {
        //             CapextypeWrapper.style.display = 'block';
        //         }
        //     }
        //     $('#capex_type_id').on('change', toggleCapextype);
        //     toggleCapextype();
        // });
          document.addEventListener('DOMContentLoaded', function() {
            const capextypeWrapper = document.getElementById('capex_type_wrapper');
            const hideCapexTypes = ['CAPEX', 'PAYREQ', 'RE'];

            function toggleVendor() {
                const selected = $('#request_type_id').find(':selected');
                const code = selected.data('code');
                console.log('CODE:', code);
                if (code && hideCapexTypes.includes(code)) {
                    capexWrapper.style.display = 'none';
                    $('#capex_type_id').val(null).trigger('change');
                } else {
                    capextypeWrapper.style.display = 'block';
                }
            }
            $('#request_type_id').on('change', toggleCapextype);
            toggleCapextype();
        });
    </script>
    <script id="edwin27">
        let linkIndex = 1;
        document.getElementById('add-link').addEventListener('click', function() {
            let wrapper = document.getElementById('links-wrapper');
            let row = `
        <div class="flex gap-2 link-row">
            <input type="text" 
                name="links[${linkIndex}][link]" 
                class="form-input w-full px-4 py-3 rounded-xl"
                placeholder="link referal product or link product photo">
            <button type="button" 
                class="remove-link px-3 py-2 bg-red-500 text-white rounded-lg">
                ✕
            </button>
        </div>
    `;
            wrapper.insertAdjacentHTML('beforeend', row);
            linkIndex++;
        });
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-link')) {
                e.target.closest('.link-row').remove();
            }
        });
    </script>
@endsection
