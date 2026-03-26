@extends('layouts.app')
@section('title', 'Edit Request Form' . $request->user->employee->employee_name)
@section('header', 'Edit Request Form' . $request->title)
@section('subtitle', 'Edit Request Form')
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
                    <h3 class="text-sm font-semibold text-amber-400 mb-1">Edit Request Form</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Edit the request form information below. Fields marked with <span class="text-red-400">*</span>
                        are required.
                    </p>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('updaterequest', request()->route('hash')) }}" class="space-y-5">
            @csrf
            @method('PUT')
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


                    <select name="company_id" class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                        <option value="">Choose Companies</option>
                        @foreach ($companies as $id => $name)
                            <option value="{{ $id }}"
                                {{ old('company_id', $request->company_id) == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
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
            {{-- <select id="company_id" name="company_id"
                        class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                        <option value="">Choose Companies</option>
                        @foreach ($companies as $id => $name)
                          <option value="{{ $id }}" 
    {{ old('company_id', $request->company_id) == $id ? 'selected' : '' }}>
    {{ $name }}
</option>
                        @endforeach
                    </select> --}}
            <div class="space-y-4">
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
                        class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                        <option value="">Choose Request Type</option>
                        @foreach ($requesttypes as $id => $name)
                            <option value="{{ $id }}"
                                {{ old('request_type_id', $request->request_type_id) == $id ? 'selected' : '' }}>
                                {{ $name }}
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
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="title" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Title Request
                    </label>
                    <input type="text" id="title" name="title" class="form-input w-full px-4 py-3 rounded-xl"
                        value="{{ old('title', $request->title) }}" placeholder="butuh segera untuk bla bla bla" required>
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
                <div>
                    <label for="vendor_id" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Vendor
                    </label>
                    <select id="vendor_id" name="vendor_id"
                        class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                        <option value="">Choose Vendor</option>
                        @foreach ($vendors as $id => $name)
                            <option value="{{ $id }}"
                                {{ old('vendor_id', $request->vendor_id) == $id ? 'selected' : '' }}>
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

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="request_date" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Request Date
                    </label>
                    <input type="date" id="request_date" name="request_date"
                        class="form-input w-full px-4 py-3 rounded-xl"
                        value="{{ old('request_date', optional($request->request_date)->format('Y-m-d')) }}" required>
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
                        Deadline
                    </label>
                    <input type="date" id="deadline" name="deadline" class="form-input w-full px-4 py-3 rounded-xl"
                          value="{{ old('deadline', optional($request->deadline)->format('Y-m-d')) }}" required> 
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

            {{-- Request Items Table --}}
            <div class="mt-6">
                <h3 class="text-sm font-semibold text-slate-300 mb-3">Request Items</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border border-slate-700 rounded-xl overflow-hidden">
                        <thead class="bg-slate-800 text-slate-300">
                            <tr>
                                <th class="p-2">Item Name</th>
                                <th class="p-2">Specification</th>
                                <th class="p-2">Qty</th>
                                <th class="p-2">UOM</th>
                                <th class="p-2">Price</th>
                                <th class="p-2">Total</th>
                                <th class="p-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="items-table">

                        </tbody>
                    </table>
                </div>

                <button type="button" id="add-row"
                    class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                    + Add Item
                </button>
            </div>

            <div>
                <label for="notes" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Notes
                </label>
                <textarea id="notes" name="notes" class="form-input w-full px-4 py-3 rounded-xl"
                    placeholder="butuh segera untuk bla bla bla" rows="4" required>{{ old('notes', $request->notes) }}</textarea>
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
            <div>
                <label for="status" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Status
                </label>

                <select id="status" name="status" class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">

                    <option value="">Choose Status</option>

                    @foreach ($statuses as $key => $label)
                        <option value="{{ $key }}"
                            {{ old('status', $request->status) == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach

                </select>
                @error('status')
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
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
                    Update Request
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#request_date", {
                dateFormat: "Y-m-d",
                allowInput: true
            });
            flatpickr("#deadline", {
                dateFormat: "Y-m-d",
                allowInput: true
            });
        });
    </script>
    <script>
        // let index = {{ $request->items->count() }};
        let index = {{ $request->items->count() }};

        function getUomOptions(selectedUom = '') {
            let uoms = @json($uoms);
            return uoms.map(u => `<option value="${u}" ${u === selectedUom ? 'selected' : ''}>${u}</option>`).join('');
        }

        function createRow() {
            return `
        <tr>
            <td class="p-2">
                <input type="text" placeholder="items name" name="items[${index}][item_name]"
                    class="w-full form-input rounded-lg px-2 py-1" required>
            </td>
            <td class="p-2">
                <input type="text" placeholder="specification" name="items[${index}][specification]"
                    class="w-full form-input rounded-lg px-2 py-1">
            </td>
            <td class="p-2">
                <input type="text" placeholder="5.00" name="items[${index}][qty]"
                    class="qty w-full form-input rounded-lg px-2 py-1" required>
            </td>
            <td class="p-2">
                <select name="items[${index}][uom]" class="select2 w-full form-input rounded-lg px-2 py-1">
                    ${getUomOptions()}
                </select>
            </td>
            <td class="p-2">
                <input type="text" placeholder="0" name="items[${index}][price]"
                    class="price w-full form-input rounded-lg px-2 py-1" required>
            </td>
            <td class="p-2">
                <input type="text" name="items[${index}][total_price]"
                    class="total w-full form-input rounded-lg px-2 py-1" readonly>
            </td>
            <td class="p-2 text-center">
                <button type="button" class="remove-row text-red-500">X</button>
            </td>
        </tr>`;
        }

        $('#add-row').click(function() {
            $('#items-table').append(createRow());
            index++;
            $('.select2').select2({
                placeholder: "Choose",
                allowClear: true,
                width: '100%'
            });
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });

        $(document).on('blur', '.price', function() {
            let input = $(this);
            let angka = parseAngka(input.val());
            if (angka > 0) input.val(formatRibuan(angka));
        });

        $(document).on('focus', '.price', function() {
            let input = $(this);
            let angka = parseAngka(input.val());
            if (angka > 0) input.val(angka.toString().replace('.', ','));
        });

        $(document).on('input', '.qty, .price', function() {
            let row = $(this).closest('tr');
            let qty = parseAngka(row.find('.qty').val());
            let price = parseAngka(row.find('.price').val());
            let total = qty * price;
            row.find('.total').val(!isNaN(total) ? formatRibuan(total) : '');
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

        $(document).ready(function() {
            $('#request_type_id').select2({
                placeholder: "Choose request Types...",
                allowClear: true,
                width: '100%'
            });
            $('#vendor_id').select2({
                placeholder: "Choose Vendors...",
                allowClear: true,
                width: '100%'
            });

            // ✅ TAMBAHAN: Render existing items dari database
            let existingItems = @json($request->items);

            existingItems.forEach(function(item, i) {
                let row = `
            <tr>
                <td class="p-2">
                    <input type="text" placeholder="items name" name="items[${i}][item_name]"
                        value="${item.item_name ?? ''}"
                        class="w-full form-input rounded-lg px-2 py-1" required>
                </td>
                <td class="p-2">
                    <input type="text" placeholder="specification" name="items[${i}][specification]"
                        value="${item.specification ?? ''}"
                        class="w-full form-input rounded-lg px-2 py-1">
                </td>
                <td class="p-2">
                    <input type="text" placeholder="5.00" name="items[${i}][qty]"
                        value="${item.qty ?? ''}"
                        class="qty w-full form-input rounded-lg px-2 py-1" required>
                </td>
                <td class="p-2">
                    <select name="items[${i}][uom]" class="select2 w-full form-input rounded-lg px-2 py-1">
                        ${getUomOptions(item.uom)}
                    </select>
                </td>
                <td class="p-2">
                    <input type="text" placeholder="0" name="items[${i}][price]"
                        value="${formatRibuan(item.price ?? 0)}"
                        class="price w-full form-input rounded-lg px-2 py-1" required>
                </td>
                <td class="p-2">
                    <input type="text" name="items[${i}][total_price]"
                        value="${formatRibuan(item.total_price ?? 0)}"
                        class="total w-full form-input rounded-lg px-2 py-1" readonly>
                </td>
                <td class="p-2 text-center">
                    <button type="button" class="remove-row text-red-500">X</button>
                </td>
            </tr>`;
                $('#items-table').append(row);
            });
            $('.select2').select2({
                placeholder: "Choose",
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

{{-- @extends('layouts.app')

@section('title', 'Edit Request — ' . $formRequest->document_number)
@section('header', 'Edit Request')
@section('subtitle', 'Ubah data request ' . $formRequest->document_number)

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

<style>
:root{
  --ink:#0f1117;--paper:#f5f3ee;--cream:#ece9e1;--rule:#ddd9cf;
  --accent:#c8441a;--accent2:#2a5f8f;--gold:#d4900a;--muted:#7a7568;
  --white:#ffffff;--sh:0 2px 12px rgba(15,17,23,.08);--shl:0 8px 32px rgba(15,17,23,.13);
}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'DM Sans',sans-serif;background:var(--paper);color:var(--ink);}
.re-page{max-width:960px;margin:0 auto;padding:28px 24px 64px;}

/* header info bar */
.re-infobar{background:var(--white);border:1px solid var(--rule);border-radius:14px;
  padding:16px 22px;margin-bottom:20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;box-shadow:var(--sh);}
.re-docnum{font-family:'Syne',sans-serif;font-size:13px;font-weight:700;color:var(--accent2);
  background:#e8f0fb;padding:6px 12px;border-radius:8px;}
.re-info-item{font-size:13px;color:var(--muted);}
.re-info-item strong{color:var(--ink);font-weight:600;}
.sb{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:100px;
  font-size:12px;font-weight:600;}
.sb::before{content:'';width:6px;height:6px;border-radius:50%;background:currentColor;}
.s-draft{background:#f0f0f0;color:#555;}
.s-pending{background:#fff8e1;color:#c17900;}
.s-approved{background:#e8f5e9;color:#2e7d32;}
.s-rejected{background:#fdecea;color:#c62828;}
.s-process{background:#e3f2fd;color:#1565c0;}
.s-done{background:#e8f5e9;color:#1b5e20;}

/* card */
.re-card{background:var(--white);border:1px solid var(--rule);border-radius:14px;box-shadow:var(--sh);margin-bottom:20px;}
.re-card-head{padding:20px 24px;border-bottom:1px solid var(--rule);}
.re-card-head h3{font-family:'Syne',sans-serif;font-size:16px;font-weight:700;}
.re-card-head p{font-size:13px;color:var(--muted);margin-top:3px;}
.re-card-body{padding:24px;}

/* form */
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;}
.form-full{grid-column:span 2;}
.form-group{display:flex;flex-direction:column;gap:6px;}
label.fl{font-size:12px;font-weight:600;letter-spacing:.05em;text-transform:uppercase;color:var(--muted);}
label.fl span{color:var(--accent);margin-left:2px;}
.fi{width:100%;padding:10px 13px;border:1px solid var(--rule);border-radius:10px;
  font-family:'DM Sans',sans-serif;font-size:14px;background:var(--white);color:var(--ink);
  outline:none;transition:border .17s;}
.fi:focus{border-color:var(--accent2);box-shadow:0 0 0 3px rgba(42,95,143,.08);}
.fi:disabled{background:var(--paper);color:var(--muted);cursor:not-allowed;}
textarea.fi{resize:vertical;min-height:90px;}
select.fi{cursor:pointer;}
.fi-hint{font-size:11.5px;color:var(--muted);margin-top:2px;}

/* type display (read-only in edit) */
.type-display{display:flex;align-items:center;gap:10px;padding:12px 16px;
  background:var(--paper);border:1px solid var(--rule);border-radius:10px;}
.type-display-name{font-family:'Syne',sans-serif;font-size:14px;font-weight:700;}
.type-display-code{font-size:12px;color:var(--muted);}
.locked-badge{font-size:10.5px;font-weight:600;padding:3px 8px;border-radius:6px;
  background:#fff8e1;color:#c17900;border:1px solid #ffe082;margin-left:auto;}

/* items */
.items-wrap{border:1px solid var(--rule);border-radius:12px;overflow:hidden;}
.items-head{display:grid;padding:10px 12px;background:var(--paper);
  font-family:'Syne',sans-serif;font-size:10.5px;font-weight:700;letter-spacing:.07em;
  text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--rule);}
.items-head-cols{grid-template-columns:2fr 2fr 80px 90px 90px 100px 32px;}
.item-row{display:grid;gap:6px;padding:10px 12px;border-bottom:1px solid var(--rule);align-items:center;}
.item-row:last-child{border-bottom:none;}
.item-row-cols{grid-template-columns:2fr 2fr 80px 90px 90px 100px 32px;}
.item-row .fi{padding:8px 10px;font-size:13px;}
.del-btn{width:28px;height:28px;border-radius:7px;border:1px solid var(--rule);background:var(--paper);
  display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);transition:all .15s;}
.del-btn:hover{background:var(--accent);color:#fff;border-color:var(--accent);}
.del-btn svg{width:13px;height:13px;}
.items-footer{padding:12px;border-top:1px solid var(--rule);
  display:flex;align-items:center;justify-content:space-between;}
.total-display{font-family:'Syne',sans-serif;font-size:15px;font-weight:800;}
.total-display small{font-size:11px;font-weight:500;color:var(--muted);margin-right:4px;}

/* buttons */
.btn{display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:10px;
  font-family:'DM Sans',sans-serif;font-size:14px;font-weight:500;text-decoration:none;
  cursor:pointer;border:none;transition:all .17s;white-space:nowrap;}
.btn svg{width:16px;height:16px;}
.btn-primary{background:var(--accent2);color:#fff;}
.btn-primary:hover{background:#1a4a6e;transform:translateY(-1px);}
.btn-accent{background:var(--accent);color:#fff;}
.btn-accent:hover{background:#a83615;transform:translateY(-1px);}
.btn-ghost{background:var(--white);color:var(--ink);border:1px solid var(--rule);}
.btn-ghost:hover{background:var(--cream);}
.btn-sm{padding:8px 14px;font-size:13px;}
.form-actions{display:flex;align-items:center;justify-content:space-between;
  padding:20px 24px;border-top:1px solid var(--rule);gap:12px;flex-wrap:wrap;}

/* vendor search */
.vendor-search-wrap{position:relative;}
.vendor-dd{display:none;position:absolute;top:calc(100%+4px);left:0;right:0;
  background:var(--white);border:1px solid var(--rule);border-radius:10px;
  box-shadow:var(--shl);z-index:50;max-height:200px;overflow-y:auto;}
.vendor-dd.show{display:block;}
.vendor-opt{padding:10px 13px;cursor:pointer;font-size:13px;transition:background .12s;border-bottom:1px solid var(--rule);}
.vendor-opt:last-child{border-bottom:none;}
.vendor-opt:hover{background:var(--paper);}
.vendor-opt-name{font-weight:500;}
.vendor-opt-detail{font-size:11px;color:var(--muted);margin-top:1px;}

/* alert */
.alert{padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:20px;display:flex;gap:10px;align-items:flex-start;}
.alert svg{width:16px;height:16px;flex-shrink:0;margin-top:1px;}
.alert-err{background:#fdecea;color:#c62828;border:1px solid #ffcdd2;}
.alert-warn{background:#fff8e1;color:#c17900;border:1px solid #ffe082;}

/* locked overlay for approved/done */
.locked-notice{background:#fff8e1;border:1px solid #ffe082;border-radius:10px;
  padding:12px 16px;font-size:13px;color:#c17900;margin-bottom:20px;display:flex;gap:10px;align-items:center;}
.locked-notice svg{width:16px;height:16px;flex-shrink:0;}

@media(max-width:640px){
  .form-grid{grid-template-columns:1fr;}
  .form-full{grid-column:span 1;}
  .re-infobar{flex-direction:column;align-items:flex-start;}
  .items-head,.item-row{grid-template-columns:1fr!important;}
}
</style>

<div class="re-page">

  <div class="re-infobar">
    <span class="re-docnum">{{ $formRequest->document_number }}</span>
    <div class="re-info-item">Tipe: <strong>{{ $formRequest->requestType->request_type_name ?? '—' }}</strong></div>
    <div class="re-info-item">Dibuat: <strong>{{ \Carbon\Carbon::parse($formRequest->request_date)->format('d M Y') }}</strong></div>
    @php
      $sClass = ['draft'=>'s-draft','pending'=>'s-pending','approved'=>'s-approved','rejected'=>'s-rejected','process'=>'s-process','done'=>'s-done'][$formRequest->status] ?? 's-draft';
    @endphp
    <span class="sb {{ $sClass }}">{{ ucfirst($formRequest->status) }}</span>
    <div style="margin-left:auto;display:flex;gap:8px;">
      <a href="{{ route('form-request.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
    </div>
  </div>

  @if ($errors->any())
  <div class="alert alert-err">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <div><strong>Terdapat kesalahan:</strong><br>@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
  </div>
  @endif

  @if (in_array($formRequest->status, ['approved', 'done']))
  <div class="locked-notice">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
    Request dengan status <strong>{{ ucfirst($formRequest->status) }}</strong> tidak dapat diubah. Hubungi admin untuk membuka kunci.
  </div>
  @endif

  <form method="POST" action="{{ route('form-request.update', $formRequest->id) }}" id="editForm">
    @csrf @method('PUT')

    <div class="re-card">
      <div class="re-card-head">
        <h3>Tipe Request</h3>
        <p>Tipe request tidak dapat diubah setelah dibuat</p>
      </div>
      <div class="re-card-body">
        <input type="hidden" name="request_type_id" value="{{ $formRequest->request_type_id }}">
        <div class="type-display">
          <div>
            <div class="type-display-name">{{ $formRequest->requestType->request_type_name ?? '—' }}</div>
            <div class="type-display-code">{{ $formRequest->requestType->code ?? '' }}</div>
          </div>
          <span class="locked-badge">🔒 Terkunci</span>
        </div>
      </div>
    </div>

    <div class="re-card">
      <div class="re-card-head">
        <h3>Detail Request</h3>
        <p>Informasi utama request</p>
      </div>
      <div class="re-card-body">
        <div class="form-grid">

          <div class="form-group">
            <label class="fl">Tanggal Request <span>*</span></label>
            <input type="date" name="request_date" class="fi"
              value="{{ old('request_date', \Carbon\Carbon::parse($formRequest->request_date)->format('Y-m-d')) }}"
              {{ in_array($formRequest->status,['approved','done'])?'disabled':'' }} required>
          </div>

          <div class="form-group">
            <label class="fl">Deadline</label>
            <input type="date" name="deadline" class="fi"
              value="{{ old('deadline', $formRequest->deadline ? \Carbon\Carbon::parse($formRequest->deadline)->format('Y-m-d') : '') }}"
              {{ in_array($formRequest->status,['approved','done'])?'disabled':'' }}>
          </div>

          @if ($formRequest->vendor_id || !$formRequest->destination)
          <div class="form-group form-full">
            <label class="fl">Vendor</label>
            <div class="vendor-search-wrap">
              <input type="text" class="fi" id="vendorSearch"
                value="{{ $formRequest->vendor->vendor_name ?? '' }}"
                placeholder="Ketik nama vendor…" autocomplete="off"
                {{ in_array($formRequest->status,['approved','done'])?'disabled':'' }}>
              <input type="hidden" name="vendor_id" id="vendorId" value="{{ $formRequest->vendor_id }}">
              <div class="vendor-dd" id="vendorDd"></div>
            </div>
          </div>
          @endif

          @if ($formRequest->destination)
          <div class="form-group form-full">
            <label class="fl">Tujuan / Destinasi</label>
            <input type="text" name="destination" class="fi"
              value="{{ old('destination', $formRequest->destination) }}"
              placeholder="Kota / lokasi tujuan"
              {{ in_array($formRequest->status,['approved','done'])?'disabled':'' }}>
          </div>
          @endif

          <div class="form-group form-full">
            <label class="fl">Catatan</label>
            <textarea name="notes" class="fi"
              {{ in_array($formRequest->status,['approved','done'])?'disabled':'' }}>{{ old('notes', $formRequest->notes) }}</textarea>
          </div>

        </div>
      </div>
    </div>

    <div class="re-card">
      <div class="re-card-head">
        <h3>Item / Barang</h3>
        <p>Edit item yang di-request</p>
      </div>
      <div class="re-card-body" style="padding:16px;">
        <div class="items-wrap">
          <div class="items-head items-head-cols">
            <span>Nama Item</span><span>Spesifikasi</span><span>Qty</span><span>UOM</span><span>Harga</span><span>Total</span><span></span>
          </div>
          <div id="itemsContainer">
            @foreach ($formRequest->requestitems ?? [] as $i => $item)
            <div class="item-row item-row-cols" data-idx="{{ $i }}">
              <input type="hidden" name="items[{{ $i }}][id]" value="{{ $item->id }}">
              <input type="text"   name="items[{{ $i }}][item_name]"    class="fi" value="{{ $item->item_name }}" placeholder="Nama item" required {{ in_array($formRequest->status,['approved','done'])?'disabled':'' }}>
              <input type="text"   name="items[{{ $i }}][spesification]" class="fi" value="{{ $item->spesification }}" placeholder="Spesifikasi" {{ in_array($formRequest->status,['approved','done'])?'disabled':'' }}>
              <input type="number" name="items[{{ $i }}][qty]"           class="fi" value="{{ $item->qty }}" min="1" oninput="calcRow({{ $i }})" {{ in_array($formRequest->status,['approved','done'])?'disabled':'' }}>
              <select              name="items[{{ $i }}][uom]"           class="fi" {{ in_array($formRequest->status,['approved','done'])?'disabled':'' }}>
                @foreach (\App\Models\Requestitem::getUomOptions() as $uom)
                  <option value="{{ $uom }}" {{ $item->uom==$uom?'selected':'' }}>{{ $uom }}</option>
                @endforeach
              </select>
              <input type="number" name="items[{{ $i }}][price]"         class="fi" value="{{ $item->price }}" min="0" oninput="calcRow({{ $i }})" {{ in_array($formRequest->status,['approved','done'])?'disabled':'' }}>
              <input type="number" name="items[{{ $i }}][total_price]"   class="fi" value="{{ $item->total_price }}" readonly id="total_{{ $i }}">
              @if (!in_array($formRequest->status, ['approved', 'done']))
              <button type="button" class="del-btn" onclick="removeItem(this)">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              </button>
              @else
              <div></div>
              @endif
            </div>
            @endforeach
          </div>
          <div class="items-footer">
            @if (!in_array($formRequest->status, ['approved', 'done']))
            <button type="button" class="btn btn-ghost btn-sm" onclick="addItem()">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
              Tambah Item
            </button>
            @else
            <div></div>
            @endif
            <div>
              <span style="font-size:13px;color:var(--muted);margin-right:10px;">Grand Total:</span>
              <span class="total-display"><small>IDR</small><span id="grandTotal">{{ number_format($formRequest->total_amount,0,',','.') }}</span></span>
            </div>
          </div>
        </div>
        <input type="hidden" name="total_amount" id="totalAmountInput" value="{{ $formRequest->total_amount }}">
      </div>
    </div>

    <div class="re-card">
      <div class="form-actions">
        <a href="{{ route('form-request.index') }}" class="btn btn-ghost">Batal</a>
        @if (!in_array($formRequest->status, ['approved', 'done']))
        <div style="display:flex;gap:10px;">
          <button type="submit" name="action" value="draft" class="btn btn-ghost">
            Simpan Draft
          </button>
          <button type="submit" name="action" value="submit" class="btn btn-accent">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20,6 9,17 4,12"/></svg>
            Update & Submit
          </button>
        </div>
        @else
        <span style="font-size:13px;color:var(--muted);">🔒 Form terkunci — status {{ ucfirst($formRequest->status) }}</span>
        @endif
      </div>
    </div>

  </form>
</div>

<script>
const uomOptions = @json(\App\Models\Requestitem::getUomOptions());
const vendors    = @json($vendors ?? []);
let itemCount    = {{ count($formRequest->requestitems ?? []) }};

function addItem(){
  const idx = itemCount++;
  const uomOpts = uomOptions.map(u => `<option value="${u}">${u}</option>`).join('');
  const row = document.createElement('div');
  row.className = 'item-row item-row-cols';
  row.dataset.idx = idx;
  row.innerHTML = `
    <input type="text"   name="items[${idx}][item_name]"     class="fi" placeholder="Nama item" required>
    <input type="text"   name="items[${idx}][spesification]"  class="fi" placeholder="Spesifikasi">
    <input type="number" name="items[${idx}][qty]"            class="fi" placeholder="Qty" min="1" value="1" oninput="calcRow(${idx})">
    <select              name="items[${idx}][uom]"            class="fi">${uomOpts}</select>
    <input type="number" name="items[${idx}][price]"          class="fi" placeholder="0" min="0" oninput="calcRow(${idx})">
    <input type="number" name="items[${idx}][total_price]"    class="fi" readonly placeholder="0" id="total_${idx}">
    <button type="button" class="del-btn" onclick="removeItem(this)">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>`;
  document.getElementById('itemsContainer').appendChild(row);
  calcGrandTotal();
}

function removeItem(btn){
  btn.closest('.item-row').remove();
  calcGrandTotal();
}

function calcRow(idx){
  const row = document.querySelector(`[data-idx="${idx}"]`);
  if(!row) return;
  const qty   = parseFloat(row.querySelector('[name$="[qty]"]').value)   || 0;
  const price = parseFloat(row.querySelector('[name$="[price]"]').value) || 0;
  row.querySelector(`#total_${idx}`).value = qty * price;
  calcGrandTotal();
}

function calcGrandTotal(){
  let sum = 0;
  document.querySelectorAll('[name$="[total_price]"]').forEach(inp => sum += parseFloat(inp.value)||0);
  document.getElementById('grandTotal').textContent = new Intl.NumberFormat('id-ID').format(sum);
  document.getElementById('totalAmountInput').value = sum;
}

// Init totals
document.querySelectorAll('.item-row').forEach(row => {
  const idx = row.dataset.idx;
  if(idx !== undefined) calcRow(parseInt(idx));
});

// Vendor search
let vt;
const vsEl = document.getElementById('vendorSearch');
if(vsEl){
  vsEl.addEventListener('input', function(){
    clearTimeout(vt);
    const q = this.value.toLowerCase();
    if(q.length < 2){ document.getElementById('vendorDd').classList.remove('show'); return; }
    vt = setTimeout(()=>{
      const filtered = vendors.filter(v => v.vendor_name.toLowerCase().includes(q));
      const dd = document.getElementById('vendorDd');
      dd.innerHTML = !filtered.length
        ? '<div class="vendor-opt" style="color:var(--muted)">Vendor tidak ditemukan</div>'
        : filtered.slice(0,8).map(v =>
            `<div class="vendor-opt" onclick="pickVendor('${v.id}','${v.vendor_name}')">
              <div class="vendor-opt-name">${v.vendor_name}</div>
              <div class="vendor-opt-detail">${v.city||''} ${v.email||''}</div>
            </div>`).join('');
      dd.classList.add('show');
    }, 250);
  });
}
function pickVendor(id, name){
  document.getElementById('vendorId').value = id;
  document.getElementById('vendorSearch').value = name;
  document.getElementById('vendorDd').classList.remove('show');
}
document.addEventListener('click', e => {
  const dd = document.getElementById('vendorDd');
  if(dd && !e.target.closest('.vendor-search-wrap')) dd.classList.remove('show');
});
</script>
@endsection --}}
{{-- Render existing items dari database --}}
{{-- @foreach ($request->items as $i => $item)
                        <tr>
                            <td class="p-2">
                                <input type="text" placeholder="items name"
                                    name="items[{{ $i }}][item_name]"
                                    value="{{ old("items.$i.item_name", $item->item_name) }}"
                                    class="w-full form-input rounded-lg px-2 py-1" required>
                            </td>
                            <td class="p-2">
                                <input type="text" placeholder="specification"
                                    name="items[{{ $i }}][specification]"
                                    value="{{ old("items.$i.specification", $item->specification) }}"
                                    class="w-full form-input rounded-lg px-2 py-1">
                            </td>
                            <td class="p-2">
                                <input type="text" placeholder="5.00"
                                    name="items[{{ $i }}][qty]"
                                    value="{{ old("items.$i.qty", $item->qty) }}"
                                    class="qty w-full form-input rounded-lg px-2 py-1" required>
                            </td>
                            <td class="p-2">
                                <select name="items[{{ $i }}][uom]"
                                    class="select2 w-full form-input rounded-lg px-2 py-1">
                                    @foreach ($uoms as $uom)
                                        <option value="{{ $uom }}"
                                            {{ old("items.$i.uom", $item->uom) == $uom ? 'selected' : '' }}>
                                            {{ $uom }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-2">
                                <input type="text" placeholder="0"
                                    name="items[{{ $i }}][price]"
                                    value="{{ old("items.$i.price", number_format($item->price, 2, ',', '.')) }}"
                                    class="price w-full form-input rounded-lg px-2 py-1" required>
                            </td>
                            <td class="p-2">
                                <input type="text"
                                    name="items[{{ $i }}][total_price]"
                                    value="{{ old("items.$i.total_price", number_format($item->total_price, 2, ',', '.')) }}"
                                    class="total w-full form-input rounded-lg px-2 py-1" readonly>
                            </td>
                            <td class="p-2 text-center">
                                <button type="button" class="remove-row text-red-500">X</button>
                            </td>
                        </tr>
                        @endforeach --}}
