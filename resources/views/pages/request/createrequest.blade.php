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

                    {{-- <select id="company_id" name="company_id"
                        class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
                        <option value="">Choose Companies</option>
                        @foreach ($companies as $id => $name)
                            <option value="{{ $id }}" {{ $id == $companyId ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select> --}}
                    @if ($isMainCompany)
    <select id="company_id" name="company_id"
        class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
        <option value="">Choose Companies</option>
        @foreach ($companies as $id => $name)
            <option value="{{ $id }}" {{ $id == old('company_id', $userCompanyId) ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>
@else
    {{-- <input type="text"
        class="w-full sm:w-40 px-3 py-2 border rounded-lg text-sm bg-gray-100"
        value="{{ $companies[$userCompanyId] ?? '-' }}"
        readonly> --}}
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
            {{-- <div class="space-y-4"> --}}
            <div>
                <label for="request_type_name" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
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
                        <option value="{{ $id }}" {{ old('request_type_id') == $id ? 'selected' : '' }}>
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
            {{-- </div> --}}
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
                        Deadline
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
                                <th class="p-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="items-table">
                            <!-- dynamic row -->
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
                    Applicant Notes
                </label>
                <textarea id="notes" name="notes" class="form-input w-full px-4 py-3 rounded-xl"
                    placeholder="butuh segera untuk bla bla bla" rows="4" required>{{ old('notes') }}</textarea>

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
    {{-- untuk request item --}}
    <script>
        let index = 0;

        function getUomOptions() {
            return @json($uoms);
        }

        function createRow() {
            let uoms = getUomOptions();
            let uomOptions = '';

            uoms.forEach(u => {
                uomOptions += `<option value="${u}">${u}</option>`;
            });

            return `
    <tr>
        <td class="p-2">
            <input type="text" placeholder="items name" name="items[${index}][item_name]" class="w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <input type="text" placeholder="specification" name="items[${index}][specification]" class="w-full form-input rounded-lg px-2 py-1">
        </td>
        <td class="p-2">
            <input type="text" placeholder="5.00 / 0.5" step="0.01"
       name="items[${index}][qty]" 
       class="qty w-full form-input rounded-lg px-2 py-1"
       
       required>
        </td>
        
        <td class="p-2" id="uom">
            <select name="items[${index}][uom]" placeholder="unit of measure" class="select2 w-full form-input rounded-lg px-2 py-1">
                ${uomOptions}
            </select>
        </td>
      <td class="p-2">
    <input type="text" placeholder="0" 
        name="items[${index}][price]" 
        class="price w-full form-input rounded-lg px-2 py-1"
        required>
</td>
  <td class="p-2">
    <input type="text" name="items[${index}][total_price]" 
        class="total w-full form-input rounded-lg px-2 py-1" 
        readonly>
</td>
      
        <td class="p-2 text-center">
            <button type="button" class="remove-row text-red-500">X</button>
        </td>
    </tr>
    `;
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

            if (angka > 0) {
                input.val(formatRibuan(angka));
            }
        });

        $(document).on('focus', '.price', function() {
            let input = $(this);
            let angka = parseAngka(input.val());

            if (angka > 0) {
                input.val(angka.toString().replace('.', ','));
            }
        });

        // Hitung total saat qty atau price berubah
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
            str = str.replace(/\./g, '');
            str = str.replace(',', '.');
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
@endsection
