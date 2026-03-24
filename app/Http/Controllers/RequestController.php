<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Requesttype;
use App\Models\Requestitem;
use Illuminate\Support\Facades\DB;
use App\Models\Formrequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\Structuresnew;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
class RequestController extends Controller
{
    public function formpage()
    {
        $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
        $requesttypes = Requesttype::pluck('request_type_name', 'id');
        // $statuses = ['draft', 'submitted', 'approved manager', 'rejected manager', 'approved finance', 'rejected finance'];
        $statuses = [
    'Draft' => 'Draft',
    'Submitted' => 'Submitted',
    'Approved Manager' => 'Approved Manager',
    'Rejected Manager' => 'Rejected Manager',
    'Approved Finance' => 'Approved Finance',
    'Rejected Finance' => 'Rejected Finance',
    'Rejected Director' => 'Rejected Director',
    'Approved Director' => 'Approved Director',
    'Done' => 'Done',
];
        return view('pages.request.request', compact('vendors', 'requesttypes', 'statuses'));
    }
    public function getRequests(Request $request)
    {
        $query = Formrequest::with([
            'vendor',
            'requesttype',
            'user.employee'
        ])->select([
            'id',
            'request_type_id',
            'vendor_id',
            'destination',
            'document_number',
            'user_id',
            'title',
            'request_date',
            'deadline',
            'status',
        ]);
        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('document_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('request_date', 'like', "%{$search}%")
                    ->orWhere('deadline', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('vendor', function ($q2) use ($search) {
                        $q2->where('vendor_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('requesttype', function ($q2) use ($search) {
                        $q2->where('request_type_name', 'like', "%{$search}%");
                    });
                // ->orWhereHas('user.employee', function ($q2) use ($search) {
                //     $q2->where('employee_name', 'like', "%{$search}%");
                // });
            });
        }
        if ($request->filled('request_type_name')) {
            $query->whereHas('requesttype', function ($q) use ($request) {
                $q->where('request_type_name', $request->request_type_name);
            });
        }
        if ($request->filled('vendor_name')) {
            $query->whereHas('vendor', function ($q) use ($request) {
                $q->where('vendor_name', $request->vendor_name);
            });
        }
        if ($request->filled('request_date')) {
            $query->whereDate('request_date', $request->request_date);
        }
        if ($request->filled('deadline')) {
            $query->whereDate('deadline', $request->deadline);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // =============================
        // 📊 DATATABLES RESPONSE
        // =============================
        return DataTables::eloquent($query)
            ->addIndexColumn()

            ->addColumn('vendor_name', function ($row) {
                return optional($row->vendor)->vendor_name ?? '-';
            })
            ->filterColumn('vendor_name', function ($query, $keyword) {
                $query->whereHas('vendor', fn($q) => $q->where('vendor_name', 'like', "%{$keyword}%"));
            })

            ->addColumn('request_type_name', function ($row) {
                return optional($row->requesttype)->request_type_name ?? '-';
            })
            ->filterColumn('request_type_name', function ($query, $keyword) {
                $query->whereHas('requesttype', fn($q) => $q->where('request_type_name', 'like', "%{$keyword}%"));
            })

            ->addColumn('employee_name', function ($row) {
                return optional($row->user->employee ?? null)->employee_name ?? '-';
            })
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('user.employee', fn($q) => $q->where('employee_name', 'like', "%{$keyword}%"));
            })
            ->addColumn('action', function ($row) {
                $idHashed = substr(hash('sha256', $row->id . config('app.key')), 0, 8);
                $id = $row->id;
                $editBtn = '
                <a href="' . route('editrequest', $idHashed) . '"
                   class="inline-flex items-center justify-center p-2
                          text-slate-500 hover:text-indigo-600
                          hover:bg-indigo-50 rounded-full transition"
                   title="Edit Request: ' . e(optional($row->requesttype)->request_type_name) . ' - ' . e($row->title) . '">
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
                $showBtn = '
                <a href="' . route('showrequest', $idHashed) . '"
                   class="inline-flex items-center justify-center p-2
                          text-slate-500 hover:text-emerald-600
                          hover:bg-emerald-50 rounded-full transition"
                   title="Show Request: ' . e(optional($row->requesttype)->request_type_name) . ' - ' . e($row->title) . '">
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
                $pdfBtn = '
        <a href="' . route('request.pdf', $id) . '"
           class="inline-flex items-center justify-center p-2
                  text-slate-500 hover:text-red-600
                  hover:bg-red-50 rounded-full transition"
           title="Download PDF: ' . e(optional($row->requesttype)->request_type_name) . ' - ' . e($row->title) . '"
           target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 16v-8m0 8l-3-3m3 3l3-3M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2" />
            </svg>
        </a>';
                return $editBtn . $showBtn . $pdfBtn;
            })
            ->editColumn('request_date', function ($request) {
                return optional($request->request_date)
                    ->timezone('Asia/Makassar')
                    ->translatedFormat('d F Y');
            })

            ->editColumn('deadline', function ($request) {
                return optional($request->deadline)
                    ->timezone('Asia/Makassar')
                    ->translatedFormat('d F Y');
            })
            ->rawColumns(['action'])
            ->make(true);
    }
  
    public function edit($hash)
    {
        $request = Formrequest::with('items')->get()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
        abort_if(!$request, 404);
        $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
        $requesttypes = Requesttype::pluck('request_type_name', 'id');
        // $statuses = ['draft', 'submitted', 'approved manager', 'rejected manager', 'approved finance', 'rejected finance'];
          $statuses = [
    'Draft' => 'Draft',
    'Submitted' => 'Submitted',
    'Approved Manager' => 'Approved Manager',
    'Rejected Manager' => 'Rejected Manager',
    'Approved Finance' => 'Approved Finance',
    'Rejected Finance' => 'Rejected Finance',
    'Rejected Director' => 'Rejected Director',
    'Approved Director' => 'Approved Director',
    'Done' => 'Done',
];
        $uoms = Requestitem::getUomOptions();

        return view('pages.request.editrequest', compact('request', 'vendors', 'requesttypes', 'statuses', 'uoms'));
    }
    public function show($hash)
    {
        $request = Formrequest::with('items')->get()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
        abort_if(!$request, 404);
        $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
        $requesttypes = Requesttype::pluck('request_type_name', 'id');
        // $statuses = ['draft', 'submitted', 'approved manager', 'rejected manager', 'approved finance', 'rejected finance'];
          $statuses = [
    'Draft' => 'Draft',
    'Submitted' => 'Submitted',
    'Approved Manager' => 'Approved Manager',
    'Rejected Manager' => 'Rejected Manager',
    'Approved Finance' => 'Approved Finance',
    'Rejected Finance' => 'Rejected Finance',
    'Rejected Director' => 'Rejected Director',
    'Approved Director' => 'Approved Director',
    'Done' => 'Done',
];
        $uoms = Requestitem::getUomOptions();
        return view('pages.request.showrequest', compact('request', 'vendors', 'requesttypes', 'statuses', 'uoms'));
    }
//     public function pdfview($id)
//     {
//         set_time_limit(120);
//         ini_set('memory_limit', '512M');

//         $request = Formrequest::with([
//             'vendor',
//             'requesttype',
//             'items',
//             'user.employee.company',
//         ])->findOrFail($id);

//         $employee  = $request->user?->employee;
//         $companyId = $employee?->company?->id;

//         $requestDate = $request->request_date
//             ->timezone('Asia/Makassar')
//             ->translatedFormat('d F Y');
//         $Deadline = $request->deadline
//             ->timezone('Asia/Makassar')
//             ->translatedFormat('d F Y');

//         // ✅ Signature requester
//         $signatureBase64 = null;
//         if ($employee && $employee->signature) {
//             $path = public_path('storage/' . $employee->signature);
//             if (file_exists($path)) {
//                 $image = file_get_contents($path);
//                 $mime  = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
//                 $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
//             }
//         }
//         $managerName            = null;
//         $positionName            = null;
//         $managerSignatureBase64 = null;
//         if ($employee) {
//             try {
//                 $response = Http::withoutVerifying()
//                     ->get("https://hrx.asianbay.co.id/api/employee/{$employee->id}/manager");

//                 if ($response->successful()) {
//                     $managerData  = $response->json('manager');
//                     $managerName  = $managerData['employee_name'] ?? null;
//                     $positionName  = $managerData['position'] ?? null;
//                     $signatureUrl = $managerData['signature_url'] ?? null;
//                     if ($signatureUrl) {
//                         $image = file_get_contents($signatureUrl);
//                         if ($image !== false) {
//                             $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
//                             $managerSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
//                         }
//                     }
//                 }
//             } catch (\Exception $e) {
//                 Log::error('Manager fetch error: ' . $e->getMessage());
//             }
//         }
//         $logoBase64 = null;
//         if ($companyId) {
//             try {
//                 $response = Http::withoutVerifying()
//                     ->get("https://hrx.asianbay.co.id/api/company/" . $companyId);
//                 if ($response->successful()) {
//                     $logoUrl = $response->json('logo_url');
//                     $image   = file_get_contents($logoUrl);
//                     if ($image !== false) {
//                         $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
//                         $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
//                     }
//                 }
//             } catch (\Exception $e) {
//                 Log::error('Logo fetch error: ' . $e->getMessage());
//             }
//         }
//           $financestaff = User::with(['employee.position', 'roles'])->findOrFail($id);

//     return response()->json([
//         'id' => $financestaff->id,
//         'employee_name' => $financestaff->employee->employee_name,
//         'position' => $financestaff->employee->position->name,
//         'roles' => $financestaff->user->roles
//                         ->where('name', 'finance')
//                         ->pluck('name')
//                         ->first(),
//         'signature_url' => $financestaff->employee->signature
//                                ? url('storage/' . $financestaff->employee->signature)
//                                : null,
//     ]);
// }
//         $total     = $request->items->sum('total_price');
//         $itemCount = $request->items->count();
//         return Pdf::loadView('pages.request.pdf', [
//             'request'=>$request,
//             'logoBase64'=>$logoBase64,
//             'signatureBase64'=>$signatureBase64,        
//             'managerSignatureBase64'=>$managerSignatureBase64, 
//             'managerName'=>$managerName,            
//             'positionName'=>$positionName,
//             'total'=>$total,
//             'Deadline'=>$Deadline,
//             'requestDate'=>$requestDate,
//             'itemCount'=>$itemCount,
//         ])
//             ->setPaper('A4')
//             ->setOptions(['isRemoteEnabled' => true])
//             ->download('request-' . $request->document_number . '.pdf');
//     }
public function pdfview($id)
{
    set_time_limit(120);
    ini_set('memory_limit', '512M');

    $request = Formrequest::with([
        'vendor',
        'requesttype',
        'items',
        'user.employee.company',
    ])->findOrFail($id);

    $employee  = $request->user?->employee;
    $companyId = $employee?->company?->id;

    $requestDate = $request->request_date
        ->timezone('Asia/Makassar')
        ->translatedFormat('d F Y');
    $Deadline = $request->deadline
        ->timezone('Asia/Makassar')
        ->translatedFormat('d F Y');

    // ✅ Signature requester
    $signatureBase64 = null;
    if ($employee && $employee->signature) {
        $path = public_path('storage/' . $employee->signature);
        if (file_exists($path)) {
            $image = file_get_contents($path);
            $mime  = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
            $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
        }
    }

    // ✅ Manager signature — tampil hanya jika status "approved manager" atau lebih
    $managerName            = null;
    $positionName           = null;
    $managerSignatureBase64 = null;
    $showManagerSignature = in_array($request->status, ['Approved Manager', 'Approved Finance']);

    if ($employee && $showManagerSignature) {
        try {
            $response = Http::withoutVerifying()
                ->get("https://hrx.asianbay.co.id/api/employee/{$employee->id}/manager");

            if ($response->successful()) {
                $managerData  = $response->json('manager');
                $managerName  = $managerData['employee_name'] ?? null;
                $positionName = $managerData['position'] ?? null;
                $signatureUrl = $managerData['signature_url'] ?? null;
                if ($signatureUrl) {
                    $image = file_get_contents($signatureUrl);
                    if ($image !== false) {
                        $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
                        $managerSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Manager fetch error: ' . $e->getMessage());
        }
    }

   
$financeName            = null;
$financePosition        = null;
$financeSignatureBase64 = null;

$showFinanceSignature = $request->status === 'Approved Finance';

if ($showFinanceSignature) {
    try {
        $financeUser = User::with(['employee.position', 'roles'])
            ->whereHas('roles', fn($q) => $q->where('name', 'finance'))
            ->first();

        if ($financeUser && $financeUser->employee) {
            $financeName     = $financeUser->employee->employee_name;
            $financePosition = $financeUser->employee->position->name ?? null;

            $signaturePath = public_path('storage/' . $financeUser->employee->signature);
            if ($financeUser->employee->signature && file_exists($signaturePath)) {
                $image = file_get_contents($signaturePath);
                if ($image !== false) {
                    $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
                    $financeSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
                }
            }
        }
    } catch (\Exception $e) {
        Log::error('Finance fetch error: ' . $e->getMessage());
    }
}

    // ✅ Logo perusahaan
    $logoBase64 = null;
    if ($companyId) {
        try {
            $response = Http::withoutVerifying()
                ->get("https://hrx.asianbay.co.id/api/company/" . $companyId);
            if ($response->successful()) {
                $logoUrl = $response->json('logo_url');
                $image   = file_get_contents($logoUrl);
                if ($image !== false) {
                    $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
                    $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
                }
            }
        } catch (\Exception $e) {
            Log::error('Logo fetch error: ' . $e->getMessage());
        }
    }

    $total     = $request->items->sum('total_price');
    $itemCount = $request->items->count();

    return Pdf::loadView('pages.request.pdf', [
        'request'                => $request,
        'logoBase64'             => $logoBase64,
        'signatureBase64'        => $signatureBase64,
        'managerSignatureBase64' => $managerSignatureBase64,
        'managerName'            => $managerName,
        'positionName'           => $positionName,
        'financeSignatureBase64' => $financeSignatureBase64, // ✅ tambahan
        'financeName'            => $financeName,            // ✅ tambahan
        'financePosition'        => $financePosition,        // ✅ tambahan
        'total'                  => $total,
        'Deadline'               => $Deadline,
        'requestDate'            => $requestDate,
        'itemCount'              => $itemCount,
    ])
        ->setPaper('A4')
        ->setOptions(['isRemoteEnabled' => true])
        ->download('request-' . $request->document_number . '.pdf');
}
    public function create()
    {
        $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
        $requesttypes = Requesttype::pluck('request_type_name', 'id');
        // $statuses = ['draft', 'submitted', 'approved manager', 'rejected manager', 'approved finance', 'rejected finance'];
          $statuses = [
    'Draft' => 'Draft',
    'Submitted' => 'Submitted',
    'Approved Manager' => 'Approved Manager',
    'Rejected Manager' => 'Rejected Manager',
    'Approved Finance' => 'Approved Finance',
    'Rejected Finance' => 'Rejected Finance',
    'Rejected Director' => 'Rejected Director',
    'Approved Director' => 'Approved Director',
    'Done' => 'Done',
];
        $uoms = Requestitem::getUomOptions();
        return view('pages.request.createrequest', compact('uoms', 'vendors', 'requesttypes', 'statuses'));
    }
    // private function resolveHashedId(string $hashedId): Formrequest
    // {
    //     $formrequest = Formrequest::all()->first(function ($row) use ($hashedId) {
    //         return substr(hash('sha256', $row->id . config('app.key')), 0, 8) === $hashedId;
    //     });

    //     abort_if(!$formrequest, 404);
    //     return $formrequest;
    // }
    //  private function getUserStructure(): ?Structuresnew
    // {
    //     $employee = Auth::user()->employee;
    //     if (!$employee) return null;

    //     return $employee->structuresnew;
    // }
    // private function findManagerStructureAbove(Structuresnew $structure): ?Structuresnew
    // {
    //     $current = $structure->parent;
    //     while ($current) {
    //         if ($current->is_manager) {
    //             return $current;
    //         }
    //         $current = $current->parent;
    //     }
    //     return null;
    // }
    // private function isManagerOf(Formrequest $formrequest): bool
    // {
    //     $user = Auth::user();
    //     $requesterEmployee  = optional($formrequest->user)->employee;
    //     if (!$requesterEmployee) return false;
    //     $requesterStructure = $requesterEmployee->structuresnew;
    //     if (!$requesterStructure) return false;
    //     $managerStructure = $this->findManagerStructureAbove($requesterStructure);
    //     if (!$managerStructure) return false;
    //     return Employee::where('structure_id', $managerStructure->id)
    //         ->where('user_id', $user->id)
    //         ->exists();
    // }
    // private function isFinance(): bool
    // {
    //     return Auth::user()->hasRole('finance');
    // }
    // private function isAdmin(): bool
    // {
    //     return Auth::user()->hasRole('admin');
    // }
    public function store(Request $request)
    {
        $request->merge([
            'items' => collect($request->items)->map(function ($item) {
                $item['qty'] = isset($item['qty'])
                    ? str_replace(['.', ','], ['', '.'], $item['qty'])
                    : 0;

                $item['price'] = isset($item['price'])
                    ? str_replace(['.', ','], ['', '.'], $item['price'])
                    : 0;

                return $item;
            })->toArray()
        ]);
        $validated = $request->validate([
            'request_type_id'       => ['required', 'exists:request_type,id'],
            'vendor_id'             => ['nullable', 'exists:vendor,id'],
            'request_date'          => ['required', 'date'],
            'deadline'              => ['required', 'date', 'after_or_equal:request_date'],
            'title'                 => ['required', 'string', 'max:255'],
            'notes'                 => ['nullable', 'string'],
            'destination'           => ['nullable', 'string', 'max:255'],
            'items'                 => ['required', 'array', 'min:1'],
            'items.*.item_name'     => ['required', 'string', 'max:255'],
            'items.*.specification' => ['nullable', 'string'],
            'items.*.qty'           => ['required', 'numeric', 'min:0'],
            'items.*.uom'           => ['required', Rule::in(Requestitem::getUomOptions())],
            'items.*.price'         => ['required', 'numeric', 'min:0'],
            'items.*.total_price'   => ['nullable'],
        ]);
        DB::beginTransaction();
        try {
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $totalAmount += $item['qty'] * $item['price'];
            }
            $formrequest = Formrequest::create([
                'request_type_id' => $validated['request_type_id'],
                'vendor_id'       => $validated['vendor_id'] ?? null,
                'user_id'         => Auth::id(),
                'request_date'    => $validated['request_date'],
                'deadline'        => $validated['deadline'],
                'title'           => $validated['title'],
                'notes'           => $validated['notes'] ?? null,
                'total_amount'    => round($totalAmount, 2),
                'status'          => 'Draft',
            ]);
            foreach ($validated['items'] as $item) {
                Requestitem::create([
                    'request_id'    => $formrequest->id,
                    'item_name'     => $item['item_name'],
                    'specification' => $item['specification'] ?? null,
                    'qty'           => $item['qty'],
                    'uom'           => $item['uom'],
                    'price'         => $item['price'],
                ]);
            }
            DB::commit();
            return redirect()
                ->route('request')
                ->with('success', 'Request berhasil dibuat.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat request: ' . $e->getMessage());
        }
    }
    // public function update(Request $request, string $hashedId)
    // {
    //     $formrequest = $this->resolveHashedId($hashedId);
    //     $user        = Auth::user();
    //     $current     = $formrequest->status;
    //     $newStatus   = $request->input('status');
    //     $isOwner   = $formrequest->user_id === $user->id;
    //     $isAdmin   = $this->isAdmin();
    //     $isManager = $this->isManagerOf($formrequest);
    //     $isFinance = $this->isFinance();
    //     if (!$isOwner && !$isAdmin && !$isManager && !$isFinance) {
    //         abort(403, 'Anda tidak memiliki akses.');
    //     }
    //     $allowedTransitions = [];
    //     if ($isOwner || $isAdmin) {
    //         $allowedTransitions['draft'] = ['submitted'];
    //     }
    //     if ($isManager || $isAdmin) {
    //         $allowedTransitions['submitted'] = ['approved manager', 'rejected manager'];
    //     }
    //     if ($isFinance || $isAdmin) {
    //         $allowedTransitions['approved manager'] = ['approved finance', 'rejected finance'];
    //     }
    //     if ($newStatus && $newStatus !== $current) {
    //         $allowed = $allowedTransitions[$current] ?? [];
    //         if (!in_array($newStatus, $allowed)) {
    //             return back()->with(
    //                 'error',
    //                 "Tidak dapat mengubah status dari '{$current}' ke '{$newStatus}'."
    //             );
    //         }
    //     }
    //     $canEditData = ($isOwner || $isAdmin) && $current === 'draft';
    //     $rules = [
    //         'status' => ['sometimes', 'nullable', Rule::in([
    //             'draft',
    //             'submitted',
    //             'approved manager',
    //             'rejected manager',
    //             'approved finance',
    //             'rejected finance',
    //         ])],
    //     ];
    //     if ($canEditData) {
    //         $rules = array_merge($rules, [
    //             'request_type_id'        => ['required', 'exists:request_type,id'],
    //             'vendor_id'              => ['nullable', 'exists:vendors,id'],
    //             'request_date'           => ['required', 'date'],
    //             'deadline'               => ['required', 'date', 'after_or_equal:request_date'],
    //             'title'                  => ['required', 'string', 'max:255'],
    //             'notes'                  => ['nullable', 'string'],
    //             'total_amount'           => ['nullable', 'numeric', 'min:0'],
    //             'destination'            => ['nullable', 'string', 'max:255'],
    //             'items'                  => ['required', 'array', 'min:1'],
    //             'items.*.id'             => ['nullable', 'exists:request_item,id'],
    //             'items.*.item_name'      => ['required', 'string', 'max:255'],
    //             'items.*.spesification'  => ['nullable', 'string'],
    //             'items.*.qty'            => ['required', 'numeric', 'min:1'],
    //             'items.*.uom'            => ['required', Rule::in(Requestitem::getUomOptions())],
    //             'items.*.price'          => ['required', 'numeric', 'min:0'],
    //             'items.*.total_price'    => ['required', 'numeric', 'min:0'],
    //             'deleted_item_ids'       => ['nullable', 'array'],
    //             'deleted_item_ids.*'     => ['exists:request_item,id'],
    //         ]);
    //     }
    //     $validated = $request->validate($rules);
    //     DB::beginTransaction();
    //     try {
    //         $updateData = [];
    //         if ($newStatus && $newStatus !== $current) {
    //             $updateData['status'] = $newStatus;
    //         }
    //         if ($canEditData) {
    //             $updateData = array_merge($updateData, [
    //                 'request_type_id' => $validated['request_type_id'],
    //                 'vendor_id'       => $validated['vendor_id'] ?? null,
    //                 'request_date'    => $validated['request_date'],
    //                 'deadline'        => $validated['deadline'],
    //                 'title'           => $validated['title'],
    //                 'notes'           => $validated['notes'] ?? null,
    //                 'total_amount'    => $validated['total_amount'] ?? 0,
    //                 'destination'     => $validated['destination'] ?? null,
    //             ]);
    //         }
    //         if (!empty($updateData)) {
    //             $formrequest->update($updateData);
    //         }
    //         if ($canEditData) {
    //             if (!empty($validated['deleted_item_ids'])) {
    //                 Requestitem::whereIn('id', $validated['deleted_item_ids'])
    //                     ->where('request_id', $formrequest->id)
    //                     ->delete();
    //             }

    //             foreach ($validated['items'] as $itemData) {
    //                 if (!empty($itemData['id'])) {
    //                     Requestitem::where('id', $itemData['id'])
    //                         ->where('request_id', $formrequest->id)
    //                         ->update([
    //                             'item_name'     => $itemData['item_name'],
    //                             'spesification' => $itemData['spesification'] ?? null,
    //                             'qty'           => $itemData['qty'],
    //                             'uom'           => $itemData['uom'],
    //                             'price'         => $itemData['price'],
    //                             'total_price'   => $itemData['total_price'],
    //                         ]);
    //                 } else {
    //                     Requestitem::create([
    //                         'request_id'    => $formrequest->id,
    //                         'item_name'     => $itemData['item_name'],
    //                         'spesification' => $itemData['spesification'] ?? null,
    //                         'qty'           => $itemData['qty'],
    //                         'uom'           => $itemData['uom'],
    //                         'price'         => $itemData['price'],
    //                         'total_price'   => $itemData['total_price'],
    //                     ]);
    //                 }
    //             }
    //         }

    //         DB::commit();

    //         return redirect()
    //             ->route('requests.index')
    //             ->with('success', 'Request berhasil diperbarui.');
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         return back()->withInput()->with('error', 'Gagal memperbarui request: ' . $e->getMessage());
    //     }
    // }
//     public function update(Request $request, $hash)
// {
//     $request->merge([
//         'items' => collect($request->items)->map(function ($item) {
//             $item['qty'] = isset($item['qty'])
//                 ? str_replace(['.', ','], ['', '.'], $item['qty'])
//                 : 0;

//             $item['price'] = isset($item['price'])
//                 ? str_replace(['.', ','], ['', '.'], $item['price'])
//                 : 0;

//             return $item;
//         })->toArray()
//     ]);

//     $validated = $request->validate([
//         'request_type_id'       => ['required', 'exists:request_type,id'],
//         'vendor_id'             => ['nullable', 'exists:vendor,id'],
//         'request_date'          => ['required', 'date'],
//         'deadline'              => ['required', 'date', 'after_or_equal:request_date'],
//         'title'                 => ['required', 'string', 'max:255'],
//         'notes'                 => ['nullable', 'string'],
//         'destination'           => ['nullable', 'string', 'max:255'],
//         'status'                => ['required', 'string'], // ✅ tambahan
//         'items'                 => ['required', 'array', 'min:1'],
//         'items.*.item_name'     => ['required', 'string', 'max:255'],
//         'items.*.specification' => ['nullable', 'string'],
//         'items.*.qty'           => ['required', 'numeric', 'min:0'],
//         'items.*.uom'           => ['required', Rule::in(Requestitem::getUomOptions())],
//         'items.*.price'         => ['required', 'numeric', 'min:0'],
//         'items.*.total_price'   => ['nullable'],
//     ]);

//     DB::beginTransaction();

//     try {
//         // $formrequest = Formrequest::findOrFail($id);
//         $formrequest = Formrequest::with('items')->get()->first(function ($u) use ($hash) {
//             return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
//         });

//         $totalAmount = 0;
//         foreach ($validated['items'] as $item) {
//             $totalAmount += $item['qty'] * $item['price'];
//         }

//         $formrequest->update([
//             'request_type_id' => $validated['request_type_id'],
//             'vendor_id'       => $validated['vendor_id'] ?? null,
//             'request_date'    => $validated['request_date'],
//             'deadline'        => $validated['deadline'],
//             'title'           => $validated['title'],
//             'notes'           => $validated['notes'] ?? null,
//             'total_amount'    => round($totalAmount, 2),
//             'status'          => $validated['status'], // ✅ pakai dari request
//         ]);

//         Requestitem::where('request_id', $formrequest->id)->delete();

//         foreach ($validated['items'] as $item) {
//             Requestitem::create([
//                 'request_id'    => $formrequest->id,
//                 'item_name'     => $item['item_name'],
//                 'specification' => $item['specification'] ?? null,
//                 'qty'           => $item['qty'],
//                 'uom'           => $item['uom'],
//                 'price'         => $item['price'],
//             ]);
//         }

//         DB::commit();

//         return redirect()
//             ->route('request')
//             ->with('success', 'Request berhasil diupdate.');

//     } catch (\Throwable $e) {
//         DB::rollBack();

//         return back()
//             ->withInput()
//             ->with('error', 'Gagal update request: ' . $e->getMessage());
//     }
// }

public function update(Request $request, $hash)
{
    Log::info('UPDATE REQUEST - START', [
        'hash' => $hash,
        'user_id' => auth()->id(),
        'payload' => $request->all()
    ]);

    $request->merge([
        'items' => collect($request->items)->map(function ($item) {
            $item['qty'] = isset($item['qty'])
                ? str_replace(['.', ','], ['', '.'], $item['qty'])
                : 0;

            $item['price'] = isset($item['price'])
                ? str_replace(['.', ','], ['', '.'], $item['price'])
                : 0;

            return $item;
        })->toArray()
    ]);

    $validated = $request->validate([
        'request_type_id'       => ['required', 'exists:request_type,id'],
        'vendor_id'             => ['nullable', 'exists:vendor,id'],
        'request_date'          => ['required', 'date'],
        'deadline'              => ['required', 'date', 'after_or_equal:request_date'],
        'title'                 => ['required', 'string', 'max:255'],
        'notes'                 => ['nullable', 'string'],
        'destination'           => ['nullable', 'string', 'max:255'],
        // 'status'                => ['required', 'string'],
            'status' => 'required|in:Draft,Submitted,Approved Manager,Rejected Manager,Approved Finance,Rejected Finance,Approved Director,Rejected Director,Done',

        'items'                 => ['required', 'array', 'min:1'],
        'items.*.item_name'     => ['required', 'string', 'max:255'],
        'items.*.specification' => ['nullable', 'string'],
        'items.*.qty'           => ['required', 'numeric', 'min:0'],
        'items.*.uom'           => ['required', Rule::in(Requestitem::getUomOptions())],
        'items.*.price'         => ['required', 'numeric', 'min:0'],
        'items.*.total_price'   => ['nullable'],
    ]);

    DB::beginTransaction();

    try {
        $formrequest = Formrequest::with('items')->get()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });

        if (!$formrequest) {
            Log::warning('UPDATE REQUEST - NOT FOUND', ['hash' => $hash]);
            return back()->with('error', 'Data tidak ditemukan.');
        }

        Log::info('UPDATE REQUEST - BEFORE UPDATE', [
            'id' => $formrequest->id,
            'data' => $formrequest->toArray()
        ]);

        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $totalAmount += $item['qty'] * $item['price'];
        }

        $formrequest->update([
            'request_type_id' => $validated['request_type_id'],
            'vendor_id'       => $validated['vendor_id'] ?? null,
            'request_date'    => $validated['request_date'],
            'deadline'        => $validated['deadline'],
            'title'           => $validated['title'],
            'notes'           => $validated['notes'] ?? null,
            'total_amount'    => round($totalAmount, 2),
            'status'          => $validated['status'],
        ]);

        // log setelah update header
        Log::info('UPDATE REQUEST - AFTER HEADER UPDATE', [
            'id' => $formrequest->id,
            'data' => $formrequest->fresh()->toArray()
        ]);

        // delete items lama
        Requestitem::where('request_id', $formrequest->id)->delete();

        // insert ulang
        foreach ($validated['items'] as $item) {
            Requestitem::create([
                'request_id'    => $formrequest->id,
                'item_name'     => $item['item_name'],
                'specification' => $item['specification'] ?? null,
                'qty'           => $item['qty'],
                'uom'           => $item['uom'],
                'price'         => $item['price'],
            ]);
        }

        Log::info('UPDATE REQUEST - ITEMS REPLACED', [
            'request_id' => $formrequest->id,
            'total_items' => count($validated['items'])
        ]);

        DB::commit();

        Log::info('UPDATE REQUEST - SUCCESS', [
            'request_id' => $formrequest->id
        ]);

        return redirect()
            ->route('request')
            ->with('success', 'Request berhasil diupdate.');

    } catch (\Throwable $e) {
        DB::rollBack();

        Log::error('UPDATE REQUEST - ERROR', [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
            'trace'   => $e->getTraceAsString()
        ]);

        return back()
            ->withInput()
            ->with('error', 'Gagal update request: ' . $e->getMessage());
    }
}

   
}
