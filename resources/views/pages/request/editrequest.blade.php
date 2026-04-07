{{-- @extends('layouts.app')
@section('title', 'Edit Request Form - ' . $request->user->employee->employee_name)
@section('header', 'Edit Request Form - ' . $request->title)
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
                    <label for="user_id" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Applicant
                    </label>


                     <input type="text" id="user_id" name="user_id" class="form-input w-full px-4 py-3 rounded-xl"
                        value="{{ old('user_id', $request->user->employee->employee_name) }}" placeholder="butuh segera untuk bla bla bla" disabled>
                </div>
            </div>
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


                    <option value="">Choose Companies</option>
                    <select name="company_id" id="company_id"class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
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
            @if(auth()->user()->hasRole('finance'))
            <div>
                <label for="ca_number" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    CA Number
                </label>

              <input type="text"
    id="ca_number"
    name="ca_number"
    class="form-input w-full px-4 py-3 rounded-xl"
    value="{{ old('ca_number', optional($request)->ca_number) }}"
     required>
                @error('ca_number')
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
@endif
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
let index = 0;

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
                class="total w-full form-input rounded-lg px-2 py-1" readonly>
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

    newRow.find('.select2').select2({
        placeholder: "Choose",
        allowClear: true,
        width: '100%'
    });
});

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
        .replace(/\./g, '')   
        .replace(',', '.');   

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

    let qty   = parseAngka(row.find('.qty').val());
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
                    class="w-full form-input rounded-lg px-2 py-1" required>
            </td>
            <td class="p-2">
                <input type="text" name="items[${index}][specification]"
                    value="${item.specification ?? ''}"
                    class="w-full form-input rounded-lg px-2 py-1">
            </td>
            <td class="p-2">
                <input type="text" name="items[${index}][qty]"
                    value="${formatRibuan(item.qty ?? 0)}"
                    class="qty w-full form-input rounded-lg px-2 py-1" required>
            </td>
            <td class="p-2">
                <select name="items[${index}][uom]" class="select2 w-full">
                    ${getUomOptions(item.uom)}
                </select>
            </td>
            <td class="p-2">
                <input type="text" name="items[${index}][price]"
                    value="${formatRibuan(item.price ?? 0)}"
                    class="price w-full form-input rounded-lg px-2 py-1" required>
            </td>
            <td class="p-2">
                <input type="text" name="items[${index}][total_price]"
                    value="${formatRibuan(item.total_price ?? 0)}"
                    class="total w-full form-input rounded-lg px-2 py-1" readonly>
            </td>
            <td class="p-2 text-center">
                <button type="button" class="remove-row text-red-500">X</button>
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
 
@endsection --}}





@extends('layouts.app')
@section('title', 'Edit Request Form - ' . $request->user->employee->employee_name)
@section('header', 'Edit Request Form - ' . $request->title)
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
                    <label for="user_id" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                        <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Applicant
                    </label>


                     <input type="text" id="user_id" name="user_id" class="form-input w-full px-4 py-3 rounded-xl"
                        value="{{ old('user_id', $request->user->employee->employee_name) }}" placeholder="butuh segera untuk bla bla bla" disabled>
                </div>
            </div>
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


                    <option value="">Choose Companies</option>
                    <select name="company_id" id="company_id"class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm">
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
            <input type="hidden" name="request_type_id" value="{{ $request->request_type_id }}">
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
                        class="select2 w-full sm:w-40 px-3 py-2 border rounded-lg text-sm" disabled>
                        <option value="">Choose Request Type</option>
                       @foreach ($requesttypes as $type)
            <option value="{{ $type->id }}"
                data-code="{{ $type->code }}"
                {{ old('request_type_id', $request->request_type_id) == $type->id ? 'selected' : '' }}>
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
                <div id="vendor_wrapper">

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
                @foreach($assets as $key => $value)
        <option value="{{ $key }}"
            {{ old('asset') == $key ? 'selected' : '' }}>
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

            {{-- <div class="mt-6">
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

                        </tbody>
                    </table>
                </div>

                <button type="button" id="add-row"
                    class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                    + Add Item
                </button>
            </div> --}}
              <div class="mt-6">
    <h3 class="text-sm font-semibold text-slate-300 mb-3">
        Request Items <span class="text-red-400">*</span>
    </h3>

    <div class="overflow-x-auto" id="table-container">
        <!-- TABLE DINAMIS MASUK SINI -->
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

    @php
    $links = old('links', $request->links ?? []);
@endphp

@if(count($links))
    @foreach($links as $i => $link)
        <div class="flex gap-2 link-row">
            <input type="text" 
                name="links[{{ $i }}][link]" 
                class="form-input w-full px-4 py-3 rounded-xl"
                value="{{ is_array($link) ? ($link['link'] ?? '') : ($link->link ?? '') }}"
                placeholder="link referal product or link product photo">

            <button type="button" 
                class="remove-link px-3 py-2 bg-red-500 text-white rounded-lg">
                ✕
            </button>
        </div>
    @endforeach
@else
            {{-- fallback kalau kosong --}}
            <div class="flex gap-2 link-row">
                <input type="url" 
                    name="links[0][link]" 
                    class="form-input w-full px-4 py-3 rounded-xl"
                    placeholder="link referal product or link product photo">

                <button type="button" 
                    class="remove-link px-3 py-2 bg-red-500 text-white rounded-lg">
                    ✕
                </button>
            </div>
        @endif

    </div> 

    <button type="button" id="add-link"
        class="mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
        + Add Links
    </button>

    @error('links.*.link')
        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
    @enderror
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
            {{-- @if(auth()->user()->hasRole('finance'))
            <div>
                <label for="ca_number" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
                    <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    CA Number
                </label>

              <input type="text"
    id="ca_number"
    name="ca_number"
    class="form-input w-full px-4 py-3 rounded-xl"
    value="{{ old('ca_number', optional($request)->ca_number) }}"
     required>
                @error('ca_number')
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
@endif --}}
@if(auth()->user()->hasRole('finance') && optional($request->requesttype)->code == 'CA')
    <div>
        <label for="ca_number" class="flex items-center gap-2 text-sm font-semibold text-slate-300 mb-2">
            <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
            </svg>
            CA Number
        </label>

        <input type="text"
            id="ca_number"
            name="ca_number"
            class="form-input w-full px-4 py-3 rounded-xl"
            value="{{ old('ca_number', optional($request)->ca_number) }}"
            required>

        @error('ca_number')
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
@endif
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
    const isDirector = @json($isDirector);
</script>
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
    } 
    else if (code === 'CAPEX') {
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
    } 
    else if (code === 'PAYREQ') {
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
    } 
    else if (code === 'PR') {
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
    } 
    else if (code === 'RE') {
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
    } 
    else {
        $('#table-container').html('');
    }
}
function createRowCA(item = null) {
    let uoms = getUomOptions();
    let uomOptions = '';

    uoms.forEach(u => {
        let selected = item?.uom == u ? 'selected' : '';
        uomOptions += `<option value="${u}" ${selected}>${u}</option>`;
    });
  const row = `
    <tr>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][item_name]" 
                value="${item?.item_name ?? ''}"
                class="w-full form-input rounded-lg px-2 py-1" placeholder="item name" required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][specification]" 
                value="${item?.specification ?? ''}"
                class="w-full form-input rounded-lg px-2 py-1"placeholder="specification" >
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][qty]" 
                value="${item?.qty ?? ''}"
                class="qty w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <select name="items[${index}][uom]" 
                class="select2-uom w-full form-input rounded-lg px-2 py-1">
                ${uomOptions}
            </select>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][price]" 
                value="${item?.price ?? ''}"
                class="price w-full form-input rounded-lg px-2 py-1" placeholder="price "required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][total_price]" 
                value="${item?.total_price ?? ''}"
                class="total w-full form-input rounded-lg px-2 py-1" placeholder="total price" readonly>
        </td>
        <td class="p-2 text-center">
            <button type="button" class="remove-row text-red-500">X</button>
        </td>
    </tr>
    `;
    index++;
return row;
}
function createRowPAYREQ(item = null) {
    let uoms = getUomOptions();
    let uomOptions = '';

    uoms.forEach(u => {
        let selected = item?.uom == u ? 'selected' : '';
        uomOptions += `<option value="${u}" ${selected}>${u}</option>`;
    });
  const row = `
    <tr>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][item_name]" 
                value="${item?.item_name ?? ''}"
                class="w-full form-input rounded-lg px-2 py-1" placeholder="item name" required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][specification]" 
                value="${item?.specification ?? ''}"
                class="w-full form-input rounded-lg px-2 py-1"placeholder="specification" >
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][qty]" 
                value="${item?.qty ?? ''}"
                class="qty w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <select name="items[${index}][uom]" 
                class="select2-uom w-full form-input rounded-lg px-2 py-1">
                ${uomOptions}
            </select>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][price]" 
                value="${item?.price ?? ''}"
                class="price w-full form-input rounded-lg px-2 py-1" placeholder="price "required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][total_price]" 
                value="${item?.total_price ?? ''}"
                class="total w-full form-input rounded-lg px-2 py-1" placeholder="total price" readonly>
        </td>
        <td class="p-2 text-center">
            <button type="button" class="remove-row text-red-500">X</button>
        </td>
    </tr>
    `;
    index++;
return row;
}
function createRowPR(item = null) {
    let uoms = getUomOptions();
    let uomOptions = '';

    uoms.forEach(u => {
        let selected = item?.uom == u ? 'selected' : '';
        uomOptions += `<option value="${u}" ${selected}>${u}</option>`;
    });
  const row = `
    <tr>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][item_name]" 
                value="${item?.item_name ?? ''}"
                class="w-full form-input rounded-lg px-2 py-1" placeholder="item name" required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][specification]" 
                value="${item?.specification ?? ''}"
                class="w-full form-input rounded-lg px-2 py-1"placeholder="specification" >
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][qty]" 
                value="${item?.qty ?? ''}"
                class="qty w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <select name="items[${index}][uom]" 
                class="select2-uom w-full form-input rounded-lg px-2 py-1">
                ${uomOptions}
            </select>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][price]" 
                value="${item?.price ?? ''}"
                class="price w-full form-input rounded-lg px-2 py-1" placeholder="price "required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][total_price]" 
                value="${item?.total_price ?? ''}"
                class="total w-full form-input rounded-lg px-2 py-1" placeholder="total price" readonly>
        </td>
        <td class="p-2 text-center">
            <button type="button" class="remove-row text-red-500">X</button>
        </td>
    </tr>
    `;
    index++;
return row;
}
function createRowRE(item = null) {
    let uoms = getUomOptions();
    let uomOptions = '';

    uoms.forEach(u => {
        let selected = item?.uom == u ? 'selected' : '';
        uomOptions += `<option value="${u}" ${selected}>${u}</option>`;
    });
  const row = `
    <tr>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][item_name]" 
                value="${item?.item_name ?? ''}"
                class="w-full form-input rounded-lg px-2 py-1" placeholder="item name" required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][specification]" 
                value="${item?.specification ?? ''}"
                class="w-full form-input rounded-lg px-2 py-1"placeholder="specification" >
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][qty]" 
                value="${item?.qty ?? ''}"
                class="qty w-full form-input rounded-lg px-2 py-1" required>
        </td>
        <td class="p-2">
            <select name="items[${index}][uom]" 
                class="select2-uom w-full form-input rounded-lg px-2 py-1">
                ${uomOptions}
            </select>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][price]" 
                value="${item?.price ?? ''}"
                class="price w-full form-input rounded-lg px-2 py-1" placeholder="price "required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][total_price]" 
                value="${item?.total_price ?? ''}"
                class="total w-full form-input rounded-lg px-2 py-1" placeholder="total price" readonly>
        </td>
        <td class="p-2 text-center">
            <button type="button" class="remove-row text-red-500">X</button>
        </td>
    </tr>
    `;
    index++;
return row;
}
function createRowCAPEX(item = null) {
    let uoms = getUomOptions();
    let uomOptions = '';
    uoms.forEach(u => {
        let selected = item?.uom == u ? 'selected' : '';
        uomOptions += `<option value="${u}" ${selected}>${u}</option>`;
    });

    // Pindahkan vendorOption ke luar dan fix logicnya
    function vendorOption(selectedId) {
        return Object.entries(vendors)
            .map(([id, name]) => {
                let selected = String(id) === String(selectedId) ? 'selected' : '';
                return `<option value="${id}" ${selected}>${name}</option>`;
            })
            .join('');
    }

    const row = `
    <tr>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][item_name]" 
                value="${item?.item_name ?? ''}"
                class="w-full form-input rounded-lg px-2 py-1" placeholder="item name"required>
        </td>
        <td class="p-2">
            <input type="text" 
                name="items[${index}][qty]" 
                value="${item?.qty ?? ''}"
                class="qty w-full form-input rounded-lg px-2 py-1" placeholder="qty"required>
        </td>
        <td class="p-2">
            <select name="items[${index}][uom]" 
                class="select2-uom w-full form-input rounded-lg px-2 py-1">
                ${uomOptions}
            </select>
        </td>
        ${[0,1,2].map(i => `
      <td class="p-2">
    <div class="flex items-start gap-2">
        
        <!-- Kiri: select + price -->
        <div class="flex-1">
            <select name="items[${index}][vendors][${i}][vendor_id]" 
                class="select2-vendor w-full rounded-lg px-2 py-1">
                <option value="">-- Vendor ${i+1} --</option>
                ${vendorOption(item?.vendors?.[i]?.vendor_id)}
            </select>

            <input type="text" 
                name="items[${index}][vendors][${i}][price]" 
                value="${item?.vendors?.[i]?.price ?? ''}"
                class="price mt-1 w-full form-input rounded-lg px-2 py-1"
                placeholder="price">
        </div>
        ${isDirector ? `
        <!-- Kanan: radio -->
        <div class="flex items-center mt-1">
            <label class="flex items-center gap-1 text-xs text-slate-400 whitespace-nowrap">
                <input type="radio" 
                    name="items[${index}][selected_vendor]" 
                    value="${i}"
                    ${item?.vendors?.[i]?.is_selected ? 'checked' : ''}>
                Choose
            </label>
        </div>
        ` : ``}
    </div>
</td>
    </label>
        </td>
        `).join('')}
        <td class="p-2 text-center">
            <button type="button" class="remove-row text-red-500">X</button>
        </td>
    </tr>
    `;
    index++;
    return row;
}
function renderExistingItems() {
    let items = @json($request->items ?? []);
    let code = getCurrentCode();
    if (!items.length) return;
    items.forEach(item => {
        let row = '';
        if (code === 'CA') {
            row = createRowCA(item);
        } else if (code === 'CAPEX') {
            row = createRowCAPEX(item);
        }
        $('#items-table').append(row);
        });
    $('.select2-uom').select2({ width: '100%' });
    $('.select2-vendor').select2({ width: '100%' });
    $('.price, .total').each(function () {
    let val = parseAngka($(this).val());
    if (val > 0) {
        $(this).val(formatRibuan(val));
    }
});
}

/* =========================
   INIT
========================= */
$(document).ready(function () {

    // Init Select2 request type
    $('#request_type_id').select2({
        placeholder: "Choose Request Type",
        allowClear: true,
        width: '100%'
    });
    $('#company_id').select2({
        placeholder: "Choose Request Type",
        allowClear: true,
        width: '100%'
    });
    $('#status').select2({
        placeholder: "Choose Request Type",
        allowClear: true,
        width: '100%'
    });
    $('#vendor_id').select2({
        placeholder: "Choose Vendor",
        allowClear: true,
        width: '100%'
    });
    $('#assets').select2({
        placeholder: "Choose Assets",
        allowClear: true,
        width: '100%'
    });

    // Listener pilih request type
    $('#request_type_id').on('select2:select select2:clear', function () {
        let code = getCurrentCode();
        console.log('CODE:', code);
        renderTable(code);
    });
    let initCode = getCurrentCode();
if (initCode) {
    renderTable(initCode);
    renderExistingItems(); // 🔥 ini penting
}
});

/* =========================
   ADD ROW
========================= */
$('#add-row').click(function () {
    let code = getCurrentCode();
    if (!code) {
        alert('Pilih request type dulu yeah!');
        return;
    }
    let row = '';
    if (code === 'CA') {
        row = createRowCA();
    } 
    else if (code === 'CAPEX') {
        row = createRowCAPEX();
    } 
    else {
        alert('Type tidak dikenali');
        return;
    }
    $('#items-table').append(row);
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

/* =========================
   REMOVE ROW
========================= */
$(document).on('click', '.remove-row', function () {
    $(this).closest('tr').remove();
});
/* =========================
   FORMAT PRICE (BLUR & FOCUS)
========================= */

$(document).on('blur', '.price, .budget', function () {
    let input = $(this);
    let angka = parseAngka(input.val());
    if (angka > 0) {
        input.val(formatRibuan(angka));
    }
});
$(document).on('focus', '.price, .budget', function () {
    let input = $(this);
    let angka = parseAngka(input.val());
    if (angka > 0) {
        input.val(angka.toString().replace('.', ','));
    }
});
/* =========================
   HITUNG TOTAL (CA ONLY)
========================= */
$(document).on('input', '.qty, .price', function () {
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
/* =========================
   FORMAT ANGKA
========================= */
// function parseAngka(str) {
//     if (!str) return 0;
//     str = str.replace(/\./g, '').replace(',', '.');
//     return parseFloat(str) || 0;
// }
function parseAngka(str) {
    if (!str) return 0;
    str = str.toString().trim();

    if (str.includes(',')) {
        // Format Indonesia: 70.000,00 → hapus titik ribuan, ganti koma jadi titik
        str = str.replace(/\./g, '').replace(',', '.');
    }

    return parseFloat(str) || 0;
}

// Format saat halaman load
$(document).ready(function () {
    $('.price, .budget').each(function () {
        let input = $(this);
        let raw = input.val().toString().trim();
        
        // Pakai parseAngka bukan parseFloat, karena value sudah format Indonesia
        let angka = parseAngka(raw);
        if (angka > 0) {
            input.val(formatRibuan(angka));
        }
    });
});
function formatRibuan(angka) {
    return new Intl.NumberFormat('id-ID', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(angka);
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
</script>
   <script>
  document.addEventListener('DOMContentLoaded', function () {
    const vendorWrapper = document.getElementById('vendor_wrapper');
    const hideVendorTypes = ['CAPEX', 'PAYREQ', 'RE'];
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
    // 🔥 penting untuk select2
    $('#request_type_id').on('change', toggleVendor);
    // trigger saat load
    toggleVendor();
});
  document.addEventListener('DOMContentLoaded', function () {
    const assetsWrapper = document.getElementById('assets_wrapper');

    const hideAssets = ['CA', 'PAYREQ', 'PR','RE'];

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

    // 🔥 penting untuk select2
    $('#request_type_id').on('change', toggleAssets);

    // trigger saat load
    toggleAssets();
});
    </script>
    {{-- untuk edit links --}}
    <script>
let linkIndex = document.querySelectorAll('#links-wrapper .link-row').length;

// add more
document.getElementById('add-link').addEventListener('click', function () {
    let wrapper = document.getElementById('links-wrapper');
    let row = `
        <div class="flex gap-2 link-row">
            <input type="text" 
                name="links[${linkIndex}][link]" 
                class="form-input w-full px-4 py-3 rounded-xl"
                placeholder="link product or link photo product">
            <button type="button" 
                class="remove-link px-3 py-2 bg-red-500 text-white rounded-lg">
                ✕
            </button>
        </div>
    `;
    wrapper.insertAdjacentHTML('beforeend', row);
    linkIndex++;
});
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-link')) {
        e.target.closest('.link-row').remove();
    }
});
</script>
@endsection