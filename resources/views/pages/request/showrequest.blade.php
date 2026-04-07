@extends('layouts.app')
@section('title', 'Show Request Form - ' . ($request->user->employee->employee_name ?? ''))
@section('header', 'Show Request Form - ' . $request->title)
{{-- @section('header', 'Show Request Form - ' . ($request->title ?? '')) --}}
@section('subtitle', 'Show Request Form')
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
                    <h3 class="text-sm font-semibold text-amber-400 mb-1">Show Request Form</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Show the request form information below. Fields marked with

                    </p>
                </div>
            </div>
        </div>
        <div class="space-y-4">
            <div>
                <label for="user_id" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Applicant
                </label>


                <input type="text" id="user_id" name="user_id" class="form-input w-full px-4 py-3 rounded-xl"
                    value="{{ old('user_id', $request->user->employee->employee_name) }}"
                    placeholder="butuh segera untuk bla bla bla" disabled>
            </div>
        </div>
        <br>
        <div class="space-y-4">
            <div>
                <label for="company_id" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Company Name
                </label>


                {{-- <option value="">Choose Companies</option> --}}
                <select name="company_id" id="company_id"class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm"
                    disabled>
                    @foreach ($companies as $id => $name)
                        <option value="{{ $id }}"
                            {{ old('company_id', $request->company_id) == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>
        <br>
        <div class="space-y-4">
            <div>
                <label for="request_type_id" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Request Type
                </label>
                <select id="request_type_id" name="request_type_id"
                    class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm" disabled>
                    <option value="">Choose Request Type</option>
                    @foreach ($requesttypes as $id => $name)
                        <option value="{{ $id }}"
                            {{ old('request_type_id', $request->request_type_id) == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>
        <br>

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
                    value="{{ old('title', $request->title) }}" placeholder="butuh segera untuk bla bla bla" disabled>

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
                    class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm"disabled>
                    <option value="">Choose Vendor</option>
                    @foreach ($vendors as $id => $name)
                        <option value="{{ $id }}"
                            {{ old('vendor_id', $request->vendor_id) == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>
        <br>

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
                <input type="date" id="request_date" name="request_date" class="form-input w-full px-4 py-3 rounded-xl"
                    value="{{ old('request_date', optional($request->request_date)->format('Y-m-d')) }}" disabled>

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
                    value="{{ old('deadline', optional($request->deadline)->format('Y-m-d')) }}" disabled>

            </div>

        </div>
        @if (($request->revision_number ?? 0) != 0)
            <br>
            <div>
                <label for="revision_number" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Revision Number
                </label>
                <input type="text" id="revision_number" name="revision_number"
                    class="form-input w-full px-4 py-3 rounded-xl"
                    value="{{ old('revision_number', $request->revision_number) }}" disabled>
            </div>
        @endif
        {{-- Request Items Table --}}
        <div class="mt-6">
            <h3 class="text-sm font-semibold text-slate-300 mb-3">Request Items</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border border-slate-700 rounded-xl overflow-hidden">
                    <thead class="bg-slate-800 text-slate-300">
                        <tr>
                            <th class="p-2 text-center">Item Name</th>
                            <th class="p-2 text-center">Specification</th>
                            <th class="p-2 text-center">Qty</th>
                            <th class="p-2 text-center">UOM</th>
                            <th class="p-2 text-center">Price</th>
                            <th class="p-2 text-center">Total</th>
                            {{-- <th class="p-2 text-center">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody id="items-table">

                    </tbody>
                </table>
            </div>

            {{-- <button type="button" id="add-row"
                    class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                    + Add Item
                </button> --}}
        </div>
        <div>
            <label class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                Link Reference / Attachments
            </label>

            <div id="links-wrapper" class="space-y-2">
                @if (old('links', $request->links)->count())

                    @foreach (old('links', $request->links) as $i => $link)
                        <div class="flex gap-2 link-row">
                            <input type="url" name="links[{{ $i }}][link]"
                                class="form-input w-full px-4 py-3 rounded-xl"
                                value="{{ is_array($link) ? $link['link'] : $link->link }}" disabled>


                        </div>
                    @endforeach
                @else
                    {{-- fallback kalau kosong --}}
                    <div class="flex gap-2 link-row">
                        <input type="url" name="links[0][link]" class="form-input w-full px-4 py-3 rounded-xl"
                            placeholder="empty" disabled>

                    </div>
                @endif
            </div>
        </div>
        <br>

        <div>
            <label for="notes" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Applicant Notes
            </label>
            <textarea id="notes" name="notes" class="form-input w-full px-4 py-3 rounded-xl"
                placeholder="butuh segera untuk bla bla bla" rows="4" disabled>{{ old('notes', $request->notes) }}</textarea>

        </div>
        <br>
        @if ($request->approval?->approver1)
            <div>
                <label for="approver1" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Approved by Manager
                </label>
                <input type="text"class="form-input w-full px-4 py-3 rounded-xl"
                    value="{{ data_get($request, 'approval.approver1User.employee.employee_name') }}" disabled>
            </div>
            <br>
            <div>
                <label for="approver1_at" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Approved by Manager at
                </label>
                <input type="text"class="form-input w-full px-4 py-3 rounded-xl"
                    value="{{ data_get($request, 'approval.approver1_at') }}" disabled>
            </div>
            <br>
        @endif
        @if ($request->approval?->approver2)
            <div>
                <label for="approver2" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Approved by Director
                </label>
                <input type="text"class="form-input w-full px-4 py-3 rounded-xl"
                    value="{{ data_get($request, 'approval.approver2User.employee.employee_name') }}" disabled>
            </div>
            <br>
            <div>
                <label for="approver2_at" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Approved by Director at
                </label>
                <input type="text"class="form-input w-full px-4 py-3 rounded-xl"
                    value="{{ data_get($request, 'approval.approver2_at') }}" disabled>
            </div>

            <br>
        @endif
        <div>
            <label for="status" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                Status
            </label>

            <select id="status" name="status"
                class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm"disabled>

                <option value="">Choose Status</option>

                @foreach ($statuses as $key => $label)
                    <option value="{{ $key }}" {{ old('status', $request->status) == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach

            </select>

        </div>

        <br>


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

        </div>
        {{-- </form> --}}
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
        let index = 0; // ✅ FIX: mulai dari 0, nanti disesuaikan

        function getUomOptions(selectedUom = '') {
            let uoms = @json($uoms);
            return uoms.map(u =>
                `<option value="${u}" ${u === selectedUom ? 'selected' : ''}>${u}</option>`
            ).join('');
        }

        function createRow() {
            let row = `
    <tr>
        <td class="p-2">
            <input type="text" name="items[${index}][item_name]"
                class="w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <input type="text" name="items[${index}][specification]"
                class="w-full form-input rounded-lg px-2 py-1">
        </td>
        <td class="p-2">
            <input type="text" name="items[${index}][qty]"
                class="qty w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <select name="items[${index}][uom]" class="select2 w-full">
                ${getUomOptions()}
            </select>
        </td>
        <td class="p-2">
            <input type="text" name="items[${index}][price]"
                class="price w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <input type="text" name="items[${index}][total_price]"
                class="total w-full form-input rounded-lg px-2 py-1" disabled>
        </td>
        <td class="p-2 text-center">
            <button type="button" class="remove-row text-red-500">X</button>
        </td>
    </tr>`;

            index++;
            return row;
        }

        // ✅ ADD ROW
        $('#add-row').click(function() {
            let newRow = $(createRow());
            $('#items-table').append(newRow);

            // ✅ FIX: init select2 hanya untuk elemen baru
            newRow.find('.select2').select2({
                placeholder: "Choose",
                allowClear: true,
                width: '100%'
            });
        });

        // ✅ REMOVE ROW
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });

        // =======================
        // 🔥 FORMAT ANGKA FIX
        // =======================

        // parse aman (ID format)
        function parseAngka(str) {
            if (!str) return 0;

            str = str.toString()
                .replace(/\./g, '') // hapus ribuan
                .replace(',', '.'); // ubah desimal

            return parseFloat(str) || 0;
        }

        // format ribuan
        function formatRibuan(angka) {
            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(angka);
        }

        // =======================
        // 🔥 FORMAT INPUT QTY & PRICE
        // =======================

        // PRICE
        $(document).on('blur', '.price', function() {
            let angka = parseAngka($(this).val());
            if (angka > 0) $(this).val(formatRibuan(angka));
        });

        $(document).on('focus', '.price', function() {
            let angka = parseAngka($(this).val());
            if (angka > 0) $(this).val(angka);
        });

        // QTY (FIX TAMBAHAN)
        $(document).on('blur', '.qty', function() {
            let angka = parseAngka($(this).val());
            if (angka > 0) $(this).val(formatRibuan(angka));
        });

        $(document).on('focus', '.qty', function() {
            let angka = parseAngka($(this).val());
            if (angka > 0) $(this).val(angka);
        });

        // =======================
        // 🔥 AUTO HITUNG TOTAL
        // =======================
        $(document).on('input', '.qty, .price', function() {
            let row = $(this).closest('tr');

            let qty = parseAngka(row.find('.qty').val());
            let price = parseAngka(row.find('.price').val());

            let total = qty * price;

            row.find('.total').val(
                (!isNaN(total) && total > 0) ? formatRibuan(total) : ''
            );
        });

        // =======================
        // 🔥 INIT SELECT2 + EXISTING DATA
        // =======================
        $(document).ready(function() {

            $('#request_type_id').select2({
                placeholder: "Choose request Types...",
                allowClear: true,
                width: '100%'
            });
            $('#company_id').select2({
                placeholder: "Choose Companies...",
                allowClear: true,
                width: '100%'
            });
            $('#status').select2({
                placeholder: "Choose Statuses...",
                allowClear: true,
                width: '100%'
            });

            $('#vendor_id').select2({
                placeholder: "Choose Vendors...",
                allowClear: true,
                width: '100%'
            });

            let existingItems = @json($request->items);

            existingItems.forEach(function(item) {

                let row = `
        <tr>
            <td class="p-2">
                <input type="text" name="items[${index}][item_name]"
                    value="${item.item_name ?? ''}"
                    class="w-full form-input rounded-lg px-2 py-1" disabled>
            </td>
            <td class="p-2">
                <input type="text" name="items[${index}][specification]"
                    value="${item.specification ?? ''}"
                    class="w-full form-input rounded-lg px-2 py-1" disabled>
            </td>
            <td class="p-2">
                <input type="text" name="items[${index}][qty]"
                    value="${formatRibuan(item.qty ?? 0)}"
                    class="qty w-full form-input rounded-lg px-2 py-1" disabled>
            </td>
            <td class="p-2">
                <select name="items[${index}][uom]" class="select2 w-full"disabled>
                    ${getUomOptions(item.uom)}
                </select>
            </td>
            <td class="p-2">
                <input type="text" name="items[${index}][price]"
                    value="${formatRibuan(item.price ?? 0)}"
                    class="price w-full form-input rounded-lg px-2 py-1" disabled>
            </td>
            <td class="p-2">
                <input type="text" name="items[${index}][total_price]"
                    value="${formatRibuan(item.total_price ?? 0)}"
                    class="total w-full form-input rounded-lg px-2 py-1" disabled>
            </td>
        </tr>`;
                let newRow = $(row);
                $('#items-table').append(newRow);
                newRow.find('.select2').select2({
                    placeholder: "Choose",
                    allowClear: true,
                    width: '100%'
                });
                index++; // ✅ FIX: index naik aman
            });
        });
    </script>
@endsection
