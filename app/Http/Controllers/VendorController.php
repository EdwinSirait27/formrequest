<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    public function index()
    {
         $banks = Vendor::select('bank_name')
        ->distinct()
        ->orderBy('bank_name')
        ->pluck('bank_name');
         $transfers = Vendor::select('transfer')
        ->distinct()
        ->orderBy('transfer')
        ->pluck('transfer');
         $types = Vendor::select('type')
        ->distinct()
        ->orderBy('type')
        ->pluck('type');
         $statuses = Vendor::select('status')
        ->distinct()
        ->orderBy('status')
        ->pluck('status');
        return view('pages.vendor.vendor',compact('banks','transfers','types','statuses'));
    }
    public function getVendors(Request $request)
    {
        $query = Vendor::select([
            'id',
            'vendor_name',
            'address',
            'bank_name',
            'npwp',
            'bank_account_name',
            'bank_account_number',
            'type',
            'status',
        ]);
        $search = $request->input('search.value');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('vendor_name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('bank_name', 'like', "%{$search}%")
                    ->orWhere('npwp', 'like', "%{$search}%")
                    ->orWhere('bank_account_name', 'like', "%{$search}%")
                    ->orWhere('bank_account_number', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }
        if ($request->filled('bank_name')) {
            $query->where('bank_name', $request->bank_name);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }  
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('action', function ($vendor) {
                $idHashed = substr(hash('sha256', $vendor->id . env('APP_KEY')), 0, 8);
                {
                    $editBtn = '
            <a href="' . route('editvendor', $idHashed) . '"
               class="inline-flex items-center justify-center p-2
                      text-slate-500 hover:text-indigo-600
                      hover:bg-indigo-50 rounded-full transition"
               title="Edit Ticket: ' . e($vendor->vendor_name) . '">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.862 3.487a2.1 2.1 0 013.001 2.949
                             L7.125 19.174 3 21l1.826-4.125
                             L16.862 3.487z" />
                </svg>
            </a>';
                }
                $showBtn = '
        <a href="' . route('showvendor', $idHashed) . '"
           class="inline-flex items-center justify-center p-2
                  text-slate-500 hover:text-emerald-600
                  hover:bg-emerald-50 rounded-full transition"
           title="Show Ticket: ' . e($vendor->vendor_name) . '">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 12s3.75-6.75 9.75-6.75
                         S21.75 12 21.75 12
                         18 18.75 12 18.75
                         2.25 12 2.25 12z" />
                <circle cx="12" cy="12" r="3.25" />
            </svg>
        </a>';
                return $editBtn . $showBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

public function edit($hash)
{
    if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'finance'])) {
    return redirect()
        ->route('vendor')
        ->with('error', 'Anda tidak boleh mengakses halaman ini!');
}
    $vendor = Vendor::get()->first(function ($u) use ($hash) {
        return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
    });
    if (!$vendor) {
        return redirect()
            ->route('vendor')
            ->with('error', 'Data vendor tidak ditemukan!');
    }
    return view('pages.vendor.editvendor', compact('vendor'));
}
    public function show($hash)
    {
        $vendor = Vendor::all()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
        abort_if(!$vendor, 404);
        return view('pages.vendor.showvendor', compact('vendor'));
    }
    public function create()
    {
        $types = ['Vendor', 'Non Vendor'];
        return view('pages.vendor.createvendor', compact('types'));
    }
    public function update(Request $request, $hash)
    {
        $vendor = Vendor::all()->first(function ($v) use ($hash) {
            return substr(hash('sha256', $v->id . config('app.key')), 0, 8) === $hash;
        });
        abort_if(!$vendor, 404);
        $validated = $request->validate([
            'vendor_name' => 'required|string|max:255|unique:vendor,vendor_name,' . $vendor->id,
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'province' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'npwp' => 'nullable|number',
            'bank_name' => 'required|string',
            'bank_account_name' => 'nullable|string',
            'bank_account_number' => 'nullable|string',
            // 'transfer' => 'required|in:ABD,MJM,TNJ,BIB',
            'type' => 'required|in:Vendor,Non Vendor',
            'status' => 'required|in:Active,Inactive',
        ]);
        $vendor->update($validated);
        return redirect()
            ->route('vendor')
            ->with('success', 'Vendor Updated Successfully');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_name' => 'required|string|max:255|unique:vendor,vendor_name',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'npwp' => 'nullable|string|max:50',
            'bank_name' => 'required|string|max:100',
            'bank_account_name' => 'nullable|string|max:100',
            'bank_account_number' => 'nullable|string|max:50',
            // 'transfer' => 'required|in:ABD,MJM,TNJ,BIB',
            'type' => 'required|in:Vendor,Non Vendor',
        ]);
        $validated['status'] = 'Active';
        Vendor::create($validated);
        return redirect()
            ->route('vendor')
            ->with('success', 'Vendor Created Successfully');
    }
}
