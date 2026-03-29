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
use App\Models\Requestapproval;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestMail;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\Structuresnew;
use App\Models\Vendor;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;


class RequestController extends Controller
{
    public function formpage()
    {
        $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
        $requesttypes = Requesttype::pluck('request_type_name', 'id');
        $companies = Company::pluck('name', 'id');
        $statuses = [
            'Draft' => 'Draft',
            'Submitted' => 'Submitted',
            'Approved Manager' => 'Approved Manager',
            'Rejected Manager' => 'Rejected Manager',
            'Rejected Director' => 'Rejected Director',
            'Approved Director' => 'Approved Director',
            'Done' => 'Done',
        ];
        return view('pages.request.request', compact('vendors', 'requesttypes', 'statuses', 'companies'));
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
            'transfer',
            'company_id',
            'destination',
            'document_number',
            'user_id',
            'total_amount',
            'title',
            'request_date',
            'deadline',
            'status',
        ]);
        $search = $request->input('search.value');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $companyIds = Company::on('hrx')
                    ->where('name', 'like', "%{$search}%")
                    ->pluck('id')
                    ->toArray();
                $q->where('document_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('request_date', 'like', "%{$search}%")
                    ->orWhere('deadline', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('vendor', function ($q2) use ($search) {
                        $q2->where('vendor_name', 'like', "%{$search}%");
                    })

                    ->orWhereIn('company_id', $companyIds)
                    ->orWhereHas('requesttype', function ($q2) use ($search) {
                        $q2->where('request_type_name', 'like', "%{$search}%");
                    });
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
        if ($request->filled('name')) {
            $companyIds = Company::on('hrx')
                ->where('name', $request->name)
                ->pluck('id')
                ->toArray();

            $query->whereIn('company_id', $companyIds);
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
        // untuk manager
        $user = auth()->user();
if ($user->hasRole('admin')) {
    // 🔥 admin lihat semua, tidak perlu filter apa pun
} 
        elseif ($user->hasRole('manager')) {
            $employee = $user->employee;

            if ($employee && $employee->structure_id) {

                $structure = Structuresnew::with('allChildren')
                    ->find($employee->structure_id);

                if ($structure) {

                    $structureIds = $structure->getAllIds();

                    // ambil employee dari HRX
                    $employeeIds = Employee::whereIn('structure_id', $structureIds)
                        ->pluck('id');

                    // ambil user_id dari DB utama (form)
                    $userIds = User::whereIn('employee_id', $employeeIds)
                        ->pluck('id');

                    // ✅ filter pakai user_id (AMAN)
                    $query->whereIn('user_id', $userIds);

                    $query->whereIn('user_id', $userIds)
      ->whereIn('status', ['Submitted', 'Approved Manager']);
                }
            }
        } elseif ($user->hasRole('finance')) {
    $query->where('status', 'Approved Director');
        } elseif ($user->hasRole('director')) {
    $query->where('status', 'Approved Manager');
        }elseif ($user->hasRole('user')) {
    $query->where('user_id', $user->id);
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
            ->addColumn('name', function ($row) {
                return Company::on('hrx')
                    ->where('id', $row->company_id)
                    ->value('name') ?? '-';
            })

            ->filterColumn('name', function ($query, $keyword) {
                $companyIds = Company::on('hrx')
                    ->where('name', 'like', "%{$keyword}%")
                    ->pluck('id')
                    ->toArray();

                $query->whereIn('company_id', $companyIds);
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
                $user = auth()->user();
// cek apakah harus dikunci
// $isLocked = $row->status === 'Submitted' &&
//     (
//         $user->hasRole('user')
//     );
$isLocked = 
    ($row->status === 'Submitted'        && $user->hasRole('user'))    ||
    ($row->status === 'Approved Manager' && $user->hasRole('manager')) ||
    ($row->status === 'Approved Finance' && $user->hasRole('director')); 
                $idHashed = substr(hash('sha256', $row->id . config('app.key')), 0, 8);
                $id = $row->id;
                // $editBtn = '
                // <a href="' . route('editrequest', $idHashed) . '"
                //    class="inline-flex items-center justify-center p-2
                //           text-slate-500 hover:text-indigo-600
                //           hover:bg-indigo-50 rounded-full transition"
                //    title="Edit Request: ' . e(optional($row->requesttype)->request_type_name) . ' - ' . e($row->title) . '">
                //     <svg xmlns="http://www.w3.org/2000/svg"
                //          class="w-5 h-5"
                //          fill="none"
                //          viewBox="0 0 24 24"
                //          stroke="currentColor"
                //          stroke-width="1.8">
                //         <path stroke-linecap="round" stroke-linejoin="round"
                //               d="M16.862 3.487a2.1 2.1 0 013.001 2.949
                //                  L7.125 19.174 3 21l1.826-4.125
                //                  L16.862 3.487z" />
                //     </svg>
                // </a>';
                if ($isLocked) {
    // ❌ tombol disabled
   $editBtn = '
<span class="inline-flex items-center justify-center p-2
             text-gray-400  rounded-full cursor-not-allowed"
      title="status locked">
    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor"
         stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M16 11V7a4 4 0 10-8 0v4M5 11h14v10H5V11z" />
    </svg>
</span>';
} else {
    // ✅ tombol normal
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
}
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
$user = auth()->user();
if ($user->hasRole('user') && $request->user_id !== $user->id) {
    // abort(403, 'Kamu tidak punya akses untuk mengedit request ini.');
    return redirect()->route('request')
        ->with('error', 'you account doesnt have access to edit this request anjay.');
}
// 🔥 Admin bebas edit semua
if (!$user->hasRole('admin')) {

    $lockRules = [
        'Draft'             => ['finance','manager','director'], // selain ini boleh edit
        'Submitted'         => ['user','finance','director'],
        'Approved Manager'  => ['user', 'manager','finance'],
        'Rejected Manager'  => ['director', 'manager','finance'],
        'Approved Director' => ['user', 'manager','director'],
        'Rejected Director' => ['finance','user'],
        'Done'              => ['user', 'manager','director'],
    ];

    $lockedRoles = $lockRules[$request->status] ?? [];

    $isLocked = collect($lockedRoles)
        ->contains(fn($role) => $user->hasRole($role));

    if ($isLocked) {
        return redirect()->route('request')
            ->with('error', "Request with status '{$request->status}' can't be edited.");
    }
}
        $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
        $requesttypes = Requesttype::pluck('request_type_name', 'id');
        
         $user = auth()->user();

    // Ambil data company user dengan aman
    $userCompanyName = optional($user->employee->company)->name;
    $userCompanyId   = optional($user->employee)->company_id;

    // Guard (wajib)
    if (!$userCompanyId) {
        // abort(403, 'User tidak memiliki company');
    return redirect()->route('request')
        ->with('error', 'user doesnt have company .');

    }

$mainCompany = config('app.main_company_id');

$isMainCompany = $userCompanyId === $mainCompany;

if ($isMainCompany) {
    $companies = Company::on('hrx')->pluck('name', 'id');
} else {
    $companies = Company::on('hrx')
        ->where('id', $userCompanyId)
        ->pluck('name', 'id');
}
        $statuses = [];

        if ($user->hasRole('admin')) {
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
        } elseif ($user->hasRole('manager')) {
            $statuses = [
                'Approved Manager' => 'Approved Manager',
                'Rejected Manager' => 'Rejected Manager',
            ];
        } elseif ($user->hasRole('user')) {
            $statuses = [
                'Draft' => 'Draft',
                'Submitted' => 'Submitted',
            ];
        } elseif ($user->hasRole('finance')) {
            $statuses = [
                'Draft' => 'Draft',
                'Submitted' => 'Submitted',
            ];
        } elseif ($user->hasRole('director')) {
            $statuses = [
                'Approved Director' => 'Approved Director',
                'Rejected Director' => 'Rejected Director',
            ];
        } else {
            abort(403, 'Unauthorized');
        }

        $uoms = Requestitem::getUomOptions();

        if ($user->hasRole('manager')) {
    $employee = $user->employee;

    if ($employee && $employee->structure_id) {

        $structure = Structuresnew::with('allChildren')
            ->find($employee->structure_id);

        if ($structure) {

            $structureIds = $structure->getAllIds();

            // ambil employee bawahan + diri sendiri
            $employeeIds = Employee::whereIn('structure_id', $structureIds)
                ->pluck('id');

            // ambil user_id
            $userIds = User::whereIn('employee_id', $employeeIds)
                ->pluck('id')
                ->toArray();

            // 🔥 tambahkan diri sendiri (jaga-jaga kalau tidak masuk struktur)
            $userIds[] = $user->id;

            // ❌ kalau bukan miliknya / bukan child → forbidden
            if (!in_array($request->user_id, $userIds)) {
                return redirect()->route('request')
        ->with('error', 'you can edit your own request only or your anak buah.');
            }
        }
    }
}

        return view('pages.request.editrequest', compact(    'request',
    'companies',
    'vendors',
    'requesttypes',
    'statuses',
    'uoms',
    'userCompanyId',
    'userCompanyName'
));
    }
    // public function show($hash)
    // {
        
    //     $request = Formrequest::with('items','approval.approver1')->get()->first(function ($u) use ($hash) {
    //         return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
    //         });
            
    //         // dd($request->approval->approver1);
    //         $request?->approval?->approver1?->load('employee');
    //     abort_if(!$request, 404);
    //     $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
    //     $requesttypes = Requesttype::pluck('request_type_name', 'id');
    //     $companies = Company::pluck('name', 'id');

    //     $statuses = [
    //         'Draft' => 'Draft',
    //         'Submitted' => 'Submitted',
    //         'Approved Manager' => 'Approved Manager',
    //         'Rejected Manager' => 'Rejected Manager',
    //         'Approved Finance' => 'Approved Finance',
    //         'Rejected Finance' => 'Rejected Finance',
    //         'Rejected Director' => 'Rejected Director',
    //         'Approved Director' => 'Approved Director',
    //         'Done' => 'Done',
    //     ];
    //     $uoms = Requestitem::getUomOptions();
    //     return view('pages.request.showrequest', compact('companies', 'request', 'vendors', 'requesttypes', 'statuses', 'uoms'));
    // }
    public function show($hash)
{

$request = Formrequest::with('items', 'approval.approver1User')
    ->get()
    ->first(function ($u) use ($hash) {
        return substr(hash('sha256', $u->id . config('app.key')), 0, 8) === $hash;
    });

abort_if(!$request, 404);

// load employee
$request->load('approval.approver1User.employee');
            // dd($request->approval->approver1User->employee->employee_name);

    $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
    $requesttypes = Requesttype::pluck('request_type_name', 'id');
    $companies = Company::pluck('name', 'id');

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

    return view('pages.request.showrequest', compact(
        'companies',
        'request',
        'vendors',
        'requesttypes',
        'statuses',
        'uoms'
    ));
}
    // public function pdfview($id)
    // {
    //     set_time_limit(120);
    //     ini_set('memory_limit', '512M');
    //     $request = Formrequest::with([
    //         'vendor',
    //         'requesttype',
    //         'items',
    //         'company',
    //         'user.employee.company',
    //     ])->findOrFail($id);
    //     $employee  = $request->user?->employee;
    //     $companyId = $employee?->company?->id;
    //     $requestDate = $request->request_date
    //         ->timezone('Asia/Makassar')
    //         ->translatedFormat('d F Y');
    //     $Deadline = $request->deadline
    //         ->timezone('Asia/Makassar')
    //         ->translatedFormat('d F Y');
    //     $signatureBase64 = null;
    //     if ($employee && $employee->signature) {
    //         $path = public_path('storage/' . $employee->signature);
    //         if (file_exists($path)) {
    //             $image = file_get_contents($path);
    //             $mime  = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
    //             $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
    //         }
    //     }
    //     $logoBase64 = null;
    //     if ($companyId) {
    //         try {
    //             $response = Http::withoutVerifying()
    //                 ->get("https://hrx.asianbay.co.id/api/company/" . $companyId);
    //             // ->get(env('HRX_API_URL') . "/api/company/" . $companyId);

    //             if ($response->successful()) {
    //                 $logoUrl = $response->json('logo_url');
    //                 $image   = file_get_contents($logoUrl);
    //                 if ($image !== false) {
    //                     $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
    //                     $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
    //                 }
    //             }
    //         } catch (\Exception $e) {
    //             Log::error('Logo fetch error: ' . $e->getMessage());
    //         }
    //     }
    //     $managerName            = null;
    //     $positionName           = null;
    //     $managerSignatureBase64 = null;
    //     $showManagerSignature = in_array($request->status, ['Approved Manager', 'Approved Director']);
    //     if ($employee && $showManagerSignature) {
    //         try {
    //             $response = Http::withoutVerifying()
    //                 ->get("http://127.0.0.1:8001/api/manager/" . $employee->id);
    //             if ($response->successful()) {
    //                 $managerData  = $response->json('manager');
    //                 $managerName  = $managerData['employee_name'] ?? null;
    //                 $positionName = $managerData['position'] ?? null;
    //                 $signatureUrl = $managerData['signature'] ?? null;
    //                 if ($signatureUrl) {
    //                     $relativePath = ltrim(parse_url($signatureUrl, PHP_URL_PATH), '/');
    //                     $relativePath = str_replace('storage/', '', $relativePath);
    //                     $localPath    = public_path('storage/' . $relativePath);
    //                     if (file_exists($localPath)) {
    //                         $image = file_get_contents($localPath);
    //                         if ($image !== false) {
    //                             $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
    //                             $managerSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
    //                         }
    //                     }
    //                 }
    //             }
    //         } catch (\Exception $e) {
    //             Log::error('Manager fetch error: ' . $e->getMessage());
    //         }
    //     }
    //     $headfatName            = null;
    //     $positionheadfatName    = null;
    //     $headfatSignatureBase64 = null;
    //     $showheadfatSignature   = in_array($request->status, ['Approved Manager', 'Approved Director']);
    //     if ($showheadfatSignature) {
    //         $headfat = Employee::whereHas('position', function ($q) {
    //             $q->where('name', 'Head of FAT');
    //         })->with('position')->first();
    //         if ($headfat) {
    //             $headfatName         = $headfat->employee_name;
    //             $positionheadfatName = $headfat->position->name ?? null;
    //             if ($headfat->signature) {
    //                 $path = public_path('storage/' . $headfat->signature);
    //                 if (file_exists($path)) {
    //                     $image = file_get_contents($path);
    //                     $mime  = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
    //                     $headfatSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
    //                 }
    //             }
    //         }
    //     }
    //     $astfatName            = null;
    //     $positionastfatName    = null;
    //     $astfatSignatureBase64 = null;
    //     $showastfatSignature   = in_array($request->status, ['Approved Manager', 'Approved Director']);
    //     if ($showastfatSignature) {
    //         $astfat = Employee::whereHas('position', function ($q) {
    //             $q->where('name', 'Assistant FAT Manager');
    //         })->with('position')->first();

    //         if ($astfat) {
    //             $astfatName         = $astfat->employee_name;
    //             $positionastfatName = $astfat->position->name ?? null;

    //             if ($astfat->signature) {
    //                 $path = public_path('storage/' . $astfat->signature);
    //                 if (file_exists($path)) {
    //                     $image = file_get_contents($path);
    //                     $mime  = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
    //                     $astfatSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
    //                 }
    //             }
    //         }
    //     }
    //     $total     = $request->items->sum('total_price');
    //     $itemCount = $request->items->count();

    //     return Pdf::loadView('pages.request.pdf', [
    //         'request'                => $request,
    //         'logoBase64'             => $logoBase64,
    //         'signatureBase64'        => $signatureBase64,
    //         'managerSignatureBase64' => $managerSignatureBase64,
    //         'managerName'            => $managerName,
    //         'positionName'           => $positionName,
    //         'headfatName'           => $headfatName,
    //         'astfatName'           => $astfatName,
    //         'positionheadfatName'           => $positionheadfatName,
    //         'headfatSignatureBase64'           => $headfatSignatureBase64,
    //         'positionastfatName'           => $positionastfatName,
    //         'astfatSignatureBase64'           => $astfatSignatureBase64,
    //         'total'                  => $total,
    //         'Deadline'               => $Deadline,
    //         'requestDate'            => $requestDate,
    //         'itemCount'              => $itemCount,
    //     ])
    //         ->setPaper('A4')
    //         ->setOptions(['isRemoteEnabled' => true,
    //         'isHtml5ParserEnabled' => true])
    //         ->download('request-' . $request->document_number . '.pdf');
    // }
    // ini yang benar
//     public function pdfview($id)
// {
//     set_time_limit(120);
//     ini_set('memory_limit', '512M');
//     $request = Formrequest::with([
//         'vendor',
//         'requesttype',
//         'items',
//         'company',
//         'user.employee.company',
//     ])->findOrFail($id);
//     $employee  = $request->user?->employee;
//     $companyId = $employee?->company?->id;
//     $requestDate = $request->request_date
//         ->timezone('Asia/Makassar')
//         ->translatedFormat('d F Y');
//     $Deadline = $request->deadline
//         ->timezone('Asia/Makassar')
//         ->translatedFormat('d F Y');
//     $signatureBase64 = null;
//     if ($employee && $employee->signature) {
//         $path = public_path('storage/' . $employee->signature);
//         if (file_exists($path)) {
//             $image = file_get_contents($path);
//             $mime  = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
//             $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
//         }
//     }
//     $logoBase64 = null;
//     if ($companyId) {
//         try {
//             $response = Http::withoutVerifying()
//                 ->get("https://hrx.asianbay.co.id/api/company/" . $companyId);

//             if ($response->successful()) {
//                 $logoUrl = $response->json('logo_url');
//                 $image   = file_get_contents($logoUrl);
//                 if ($image !== false) {
//                     $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
//                     $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('Logo fetch error: ' . $e->getMessage());
//         }
//     }
//     $managerName            = null;
//     $positionName           = null;
//     $managerSignatureBase64 = null;
//     $showManagerSignature = in_array($request->status, ['Approved Manager', 'Approved Director']);
//     if ($employee && $showManagerSignature) {
//         try {
//             $response = Http::withoutVerifying()
//                 ->get("http://127.0.0.1:8001/api/manager/" . $employee->id);
//             if ($response->successful()) {
//                 $managerData  = $response->json('manager');
//                 $managerName  = $managerData['employee_name'] ?? null;
//                 $positionName = $managerData['position'] ?? null;
//                 $signatureUrl = $managerData['signature'] ?? null;
//                 if ($signatureUrl) {
//                     $relativePath = ltrim(parse_url($signatureUrl, PHP_URL_PATH), '/');
//                     $relativePath = str_replace('storage/', '', $relativePath);
//                     $localPath    = public_path('storage/' . $relativePath);
//                     if (file_exists($localPath)) {
//                         $image = file_get_contents($localPath);
//                         if ($image !== false) {
//                             $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
//                             $managerSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
//                         }
//                     }
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('Manager fetch error: ' . $e->getMessage());
//         }
//     }
   
//     $showSignature = in_array($request->status, ['Approved Manager', 'Approved Director']);

// $signaturePositions = [
//     'headfat' => 'Head of FAT',
//     'astfat'  => 'Assistant FAT Manager',
// ];

// // ✅ Pindahkan ini ke ATAS
// $signatories = [
//     'headfat' => ['name' => null, 'position' => null, 'signature' => null],
//     'astfat'  => ['name' => null, 'position' => null, 'signature' => null],
// ];

// $showSignature = in_array($request->status, ['Approved Manager', 'Approved Director']);

// if ($showSignature) {
//     foreach ($signaturePositions as $key => $positionName) {
//         $employee = Employee::whereHas('position', function ($q) use ($positionName) {
//             $q->where('name', $positionName);
//         })->with('position')->first();

//         $signatories[$key] = [
//             'name'      => $employee->employee_name ?? null,
//             'position'  => $employee->position->name ?? null,
//             'signature' => null,
//         ];

//         if ($employee?->signature) {
//             $path = public_path('storage/' . $employee->signature);
//             if (file_exists($path)) {
//                 $image  = file_get_contents($path);
//                 $finfo  = finfo_open(FILEINFO_MIME_TYPE);
//                 $mime   = finfo_buffer($finfo, $image);
//                 finfo_close($finfo);
//                 $signatories[$key]['signature'] = 'data:' . $mime . ';base64,' . base64_encode($image);
//             }
//         }
//     }
// }
//     $total     = $request->items->sum('total_price');
//     $itemCount = $request->items->count();

//     // ── Kumpulkan semua data view ke satu array ──
//     $viewData = [
//         'request'                => $request,
//         'logoBase64'             => $logoBase64,
//         'signatureBase64'        => $signatureBase64,
//         'managerSignatureBase64' => $managerSignatureBase64,
//         'managerName'            => $managerName,
//         'positionName'           => $positionName,
      
//          'signatories'            => $signatories,
//         'total'                  => $total,
//         'Deadline'               => $Deadline,
//         'requestDate'            => $requestDate,
//         'itemCount'              => $itemCount,
//         'totalPages'             => 1, // sementara, akan dihitung di bawah
//     ];

//     // ── Pass 1: render untuk menghitung total halaman ──
//     $firstRender = Pdf::loadView('pages.request.pdf', $viewData)
//         ->setPaper('A4')
//         ->setOptions([
//             'isRemoteEnabled'     => true,
//             'isHtml5ParserEnabled' => true,
//         ]);

//     // Hitung total halaman dari output PDF pass pertama
//     $pdfOutput  = $firstRender->output();
//     $totalPages = preg_match_all('/\/Type\s*\/Page\b/', $pdfOutput, $m) ? count($m[0]) : 1;

//     // ── Pass 2: render final dengan totalPages yang akurat ──
//     $viewData['totalPages'] = $totalPages;

//     return Pdf::loadView('pages.request.pdf', $viewData)
//         ->setPaper('A4')
//         ->setOptions([
//             'isRemoteEnabled'      => true,
//             'isHtml5ParserEnabled' => true,
//         ])
//         ->download('request-' . $request->document_number . '.pdf');
// }
public function pdfview($id)
{
    set_time_limit(120);
    ini_set('memory_limit', '512M');

    $request = Formrequest::with([
        'vendor',
        'requesttype',
        'items',
        'company',
        'user.employee.company',
        'user.employee.position',
        'approval.approver2User.employee',
        'approval.approver2User.employee.position',
    ])->findOrFail($id);

    $employee  = $request->user?->employee;
    $companyId = $request->company?->id;

    $requestDate = $request->request_date
        ->timezone('Asia/Makassar')
        ->translatedFormat('d F Y');
    $Deadline = $request->deadline
        ->timezone('Asia/Makassar')
        ->translatedFormat('d F Y');

    $toBase64 = function (string $localPath): ?string {
        if (!file_exists($localPath)) return null;
        $image = file_get_contents($localPath);
        if ($image === false) return null;
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_buffer($finfo, $image);
        finfo_close($finfo);
        return 'data:' . $mime . ';base64,' . base64_encode($image);
    };

    $signatureBase64 = $employee?->signature
        ? $toBase64(public_path('storage/' . $employee->signature))
        : null;

    $showManagerSignature = in_array($request->status, ['Approved Manager', 'Approved Director']);
    $showSignature        = $showManagerSignature;

    $logoBase64             = null;
    $managerName            = null;
    $positionName           = null;
    $managerSignatureBase64 = null;

    $promises = [];

    if ($companyId) {
        $promises['logo'] = Http::withoutVerifying()
            ->async()
            ->get("https://hrx.asianbay.co.id/api/company/{$companyId}");
    }

    $baseUrl = config('services.manager_api.url');

if ($employee && $showManagerSignature) {
    $promises['manager'] = Http::async()
        ->retry(3, 1000)
        ->timeout(5)
        ->get("{$baseUrl}/api/manager/{$employee->id}");
}

    // Tunggu semua sekaligus
    $responses = [];
    foreach ($promises as $key => $promise) {
        try {
            $responses[$key] = $promise->wait();
        } catch (\Exception $e) {
    Log::error(ucfirst($key) . ' fetch error: ' . $e->getMessage());

    $responses[$key] = null; // 🔥 WAJIB
}
    }

    $logoResponse = $responses['logo'] ?? null;

if ($logoResponse instanceof Response && $logoResponse->successful()) {
        try {
            $logoUrl = $responses['logo']->json('logo_url');
            if ($logoUrl) {
                $image = @file_get_contents($logoUrl);
                if ($image !== false) {
                    $finfo      = finfo_open(FILEINFO_MIME_TYPE);
                    $mime       = finfo_buffer($finfo, $image);
                    finfo_close($finfo);
                    $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
                }
            }
        } catch (\Exception $e) {
            Log::error('Logo parse error: ' . $e->getMessage());
        }
    }

   
    $managerResponse = $responses['manager'] ?? null;

if ($managerResponse instanceof Response && $managerResponse->successful()) {

    $managerData  = $managerResponse->json('manager');
    $managerName  = $managerData['employee_name'] ?? null;
    $positionName = $managerData['position'] ?? null;
    $signatureUrl = $managerData['signature'] ?? null;

    if ($signatureUrl) {
        $relativePath = ltrim(parse_url($signatureUrl, PHP_URL_PATH), '/');
        $relativePath = str_replace('storage/', '', $relativePath);

        $managerSignatureBase64 = $toBase64(public_path('storage/' . $relativePath));
    }

} else {
    Log::warning('Manager API tidak valid / gagal');
}

    // // ── 6. Signatories (query DB lokal, tidak perlu HTTP) ──
    // $signaturePositions = [
    //     'headfat' => 'Head of FAT',
    //     'astfat'  => 'Assistant FAT Manager',
    // ];

    // $signatories = array_fill_keys(array_keys($signaturePositions), [
    //     'name' => null, 'position' => null, 'signature' => null,
    // ]);

    // if ($showSignature) {
    //     // Ambil semua sekaligus, bukan 1-per-1
    //     $employees = Employee::whereHas('position', function ($q) use ($signaturePositions) {
    //         $q->whereIn('name', array_values($signaturePositions));
    //     })->with('position')->get()->keyBy(fn($e) => $e->position->name);

    //     foreach ($signaturePositions as $key => $posName) {
    //         $emp = $employees[$posName] ?? null;
    //         $signatories[$key] = [
    //             'name'      => $emp?->employee_name,
    //             'position'  => $emp?->position?->name,
    //             'signature' => $emp?->signature
    //                 ? $toBase64(public_path('storage/' . $emp->signature))
    //                 : null,
    //         ];
    //     }
    // }
    $approver2 = $request->approval?->approver2User?->employee;

$signatories = [
    'approver2' => [
        'name'      => $approver2?->employee_name,
        'position'  => $approver2?->position?->name,
        'signature' => $approver2?->signature
            ? $toBase64(public_path('storage/' . $approver2->signature))
            : null,
    ]
];

    // ── 7. Render PDF — SATU KALI, hapus pass 1 ──
    $viewData = [
        'request'                => $request,
        'logoBase64'             => $logoBase64,
        'signatureBase64'        => $signatureBase64,
        'managerSignatureBase64' => $managerSignatureBase64,
        'managerName'            => $managerName,
        'positionName'           => $positionName,
        'signatories'            => $signatories,
        'total'                  => $request->items->sum('total_price'),
        'Deadline'               => $Deadline,
        'requestDate'            => $requestDate,
        'itemCount'              => $request->items->count(),
      ];

    return Pdf::loadView('pages.request.pdf', $viewData)
        ->setPaper('A4')
        ->setOptions([
            'isRemoteEnabled'      => true,
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled'         => true,
        ])
        ->download('request-' . $request->document_number . '.pdf');
}

 // $headfatName            = null;
    // $positionheadfatName    = null;
    // $headfatSignatureBase64 = null;
    // $showheadfatSignature   = in_array($request->status, ['Approved Manager', 'Approved Director']);
    // if ($showheadfatSignature) {
    //     $headfat = Employee::whereHas('position', function ($q) {
    //         $q->where('name', 'Head of FAT');
    //     })->with('position')->first();
    //     if ($headfat) {
    //         $headfatName         = $headfat->employee_name;
    //         $positionheadfatName = $headfat->position->name ?? null;
    //         if ($headfat->signature) {
    //             $path = public_path('storage/' . $headfat->signature);
    //             if (file_exists($path)) {
    //                 $image = file_get_contents($path);
    //                 $mime  = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
    //                 $headfatSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
    //             }
    //         }
    //     }
    // }
    // $astfatName            = null;
    // $positionastfatName    = null;
    // $astfatSignatureBase64 = null;
    // $showastfatSignature   = in_array($request->status, ['Approved Manager', 'Approved Director']);
    // if ($showastfatSignature) {
    //     $astfat = Employee::whereHas('position', function ($q) {
    //         $q->where('name', 'Assistant FAT Manager');
    //     })->with('position')->first();

    //     if ($astfat) {
    //         $astfatName         = $astfat->employee_name;
    //         $positionastfatName = $astfat->position->name ?? null;

    //         if ($astfat->signature) {
    //             $path = public_path('storage/' . $astfat->signature);
    //             if (file_exists($path)) {
    //                 $image = file_get_contents($path);
    //                 $mime  = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
    //                 $astfatSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
    //             }
    //         }
    //     }
    // }
// $signatories = [];

// if ($showSignature) {
//     foreach ($signaturePositions as $key => $positionName) {
//         $employee = Employee::whereHas('position', function ($q) use ($positionName) {
//             $q->where('name', $positionName);
//         })->with('position')->first();

//         $signatories[$key] = [
//             'name'      => $employee->employee_name ?? null,
//             'position'  => $employee->position->name ?? null,
//             'signature' => null,
//         ];

//         if ($employee?->signature) {
//             $path = public_path('storage/' . $employee->signature);
//             if (file_exists($path)) {
//                 $image  = file_get_contents($path);
//                 $finfo  = finfo_open(FILEINFO_MIME_TYPE);
//                 $mime   = finfo_buffer($finfo, $image);
//                 finfo_close($finfo);
//                 $signatories[$key]['signature'] = 'data:' . $mime . ';base64,' . base64_encode($image);
//             }
//         }
//     }
// }
  // 'headfatName'            => $headfatName,
        // 'astfatName'             => $astfatName,
        // 'positionheadfatName'    => $positionheadfatName,
        // 'headfatSignatureBase64' => $headfatSignatureBase64,
        // 'positionastfatName'     => $positionastfatName,
        // 'astfatSignatureBase64'  => $astfatSignatureBase64,
// public function create()
// {
//     $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
//     $requesttypes = Requesttype::pluck('request_type_name', 'id');
//     $user = auth()->user();
//     $userCompanyName = optional($user->employee->company)->name;
//     $userCompanyId   = optional($user->employee)->company_id;

//     // Guard (wajib)
//     if (!$userCompanyId) {
//         abort(403, 'User tidak memiliki company');
//     }

// $mainCompany = config('app.main_company_id');

// $isMainCompany = $userCompanyId === $mainCompany;

// if ($isMainCompany) {
//     $companies = Company::on('hrx')->pluck('name', 'id');
// } else {
//     $companies = Company::on('hrx')
//         ->where('id', $userCompanyId)
//         ->pluck('name', 'id');
// }
//     $statuses = [
//         'Draft' => 'Draft',
//         'Submitted' => 'Submitted',
//         'Approved Manager' => 'Approved Manager',
//         'Rejected Manager' => 'Rejected Manager',
//         'Approved Finance' => 'Approved Finance',
//         'Rejected Finance' => 'Rejected Finance',
//         'Rejected Director' => 'Rejected Director',
//         'Approved Director' => 'Approved Director',
//         'Done' => 'Done',
//     ];

//     $uoms = Requestitem::getUomOptions();

//     return view('pages.request.createrequest', compact(
//         'companies',
//         'userCompanyId',
//         'uoms',
//         'vendors',
//         'isMainCompany',
//         'requesttypes',
//         'statuses'
//     ));
// }
public function create()
{
    $user = auth()->user();

    // Hanya role user & admin
    if (!$user->hasRole(['user', 'admin'])) {
        abort(403, 'Tidak memiliki akses');
    }

    $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
    $requesttypes = Requesttype::pluck('request_type_name', 'id');
    $userCompanyName = optional($user->employee->company)->name;
    $userCompanyId   = optional($user->employee)->company_id;

    // Guard (wajib)
    if (!$userCompanyId) {
        abort(403, 'User tidak memiliki company');
    }

    $mainCompany = config('app.main_company_id');
    $isMainCompany = $userCompanyId === $mainCompany;

    if ($isMainCompany) {
        $companies = Company::on('hrx')->pluck('name', 'id');
    } else {
        $companies = Company::on('hrx')
            ->where('id', $userCompanyId)
            ->pluck('name', 'id');
    }

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

    return view('pages.request.createrequest', compact(
        'companies',
        'userCompanyId',
        'uoms',
        'vendors',
        'isMainCompany',
        'requesttypes',
        'statuses'
    ));
}
public function store(Request $request)
{
    Log::info('STORE REQUEST START', [
        'payload' => $request->all(),
        'user_id' => Auth::id()
    ]);

    $validated = $request->validate([
        'request_type_id'       => ['required', 'exists:request_type,id'],
        'company_id'            => ['nullable', 'exists:hrx.company_tables,id'],
        'vendor_id'             => ['nullable', 'exists:vendor,id'],
        'transfer'              => ['nullable', 'string'],
        'request_date'          => ['required', 'date'],
        'deadline'              => ['required', 'date', 'after_or_equal:request_date'],
        'title'                 => ['required', 'string', 'max:255'],
        'notes'                 => ['nullable', 'string'],
        'status'                 => ['required|in:Draft,Submitted,Approved Manager,Rejected Manager,Approved Finance,Rejected Finance,Approved Director,Rejected Director,Done'],
        'addressed_to'          => ['nullable', 'string'],
        'destination'           => ['nullable', 'string', 'max:255'],
        'items'                 => ['required', 'array', 'min:1'],
        'items.*.item_name'     => ['required', 'string', 'max:255'],
        'items.*.specification' => ['nullable', 'string'],
        'items.*.qty'           => ['required'],
        'items.*.uom'           => ['required', Rule::in(Requestitem::getUomOptions())],
        'items.*.price'         => ['required'],
    ]);

    Log::info('VALIDATION PASSED', ['validated' => $validated]);

    // Helper: parse format angka Indonesia (e.g. "1.500,50" → 1500.50)
    $parsePrice = fn($v) => (float) str_replace(',', '.', str_replace('.', '', $v));
    $parseQty   = fn($v) => (float) str_replace(',', '.', $v);

    DB::beginTransaction();

    try {
        // Ambil nama company jika ada
        $companyName = null;
        if (!empty($validated['company_id'])) {
            $companyName = Company::on('hrx')
                ->where('id', $validated['company_id'])
                ->value('name');
        }

        // Hitung total amount dengan parsing yang konsisten
        $totalAmount = collect($validated['items'])->sum(
            fn($item) => $parseQty($item['qty']) * $parsePrice($item['price'])
        );

        Log::info('TOTAL AMOUNT', ['total' => $totalAmount]);

        $formrequest = Formrequest::create([
            'request_type_id' => $validated['request_type_id'],
            'vendor_id'       => $validated['vendor_id'] ?? null,
            'user_id'         => Auth::id(),
            'request_date'    => $validated['request_date'],
            'company_id'      => $validated['company_id'] ?? null,
            'addressed_to'    => $validated['addressed_to'] ?? null,
            'transfer'        => $companyName,
            'deadline'        => $validated['deadline'],
            'title'           => $validated['title'],
            'notes'           => $validated['notes'] ?? null,
            'total_amount'    => round($totalAmount, 2),
            'status'          => 'Draft',
        ]);
        Log::info('FORMREQUEST CREATED', ['id' => $formrequest->id]);
        foreach ($validated['items'] as $item) {
    $qty   = $parseQty($item['qty']);
    $price = $parsePrice($item['price']);

    Requestitem::create([
        'request_id'    => $formrequest->id,
        'item_name'     => $item['item_name'],
        'specification' => $item['specification'] ?? null,
        'qty'           => $qty,
        'uom'           => $item['uom'],
        'price'         => $price,
        'total_price'   => round($qty * $price, 2),
    ]);
}
        DB::commit();

        Log::info('STORE SUCCESS');

        return redirect()
            ->route('request')
            ->with('success', 'Request berhasil dibuat.');

    } catch (\Throwable $e) {
        DB::rollBack();

        Log::error('STORE ERROR', [
            'message' => $e->getMessage(),
            'trace'   => $e->getTraceAsString()
        ]);

        return back()
            ->withInput()
            ->with('error', 'Gagal membuat request: ' . $e->getMessage());
    }
}
//     public function update(Request $request, $hash)
//     {
//         Log::info('UPDATE REQUEST - START', [
//             'hash' => $hash,
//             'user_id' => auth()->id(),
//             'payload' => $request->all()
//         ]);
//         $validated = $request->validate([
//             'request_type_id'       => ['required', 'exists:request_type,id'],
//             'vendor_id'             => ['nullable', 'exists:vendor,id'],
//             'request_date'          => ['required', 'date'],
//             'deadline'              => ['required', 'date', 'after_or_equal:request_date'],
//             'title'                 => ['required', 'string', 'max:255'],
//             'notes'                 => ['nullable', 'string'],
//             'destination'           => ['nullable', 'string', 'max:255'],
//             'status' => 'required|in:Draft,Submitted,Approved Manager,Rejected Manager,Approved Finance,Rejected Finance,Approved Director,Rejected Director,Done',
//             'items'                 => ['required', 'array', 'min:1'],
//             'items.*.item_name'     => ['required', 'string', 'max:255'],
//             'items.*.specification' => ['nullable', 'string'],
//             'items.*.uom'           => ['required', Rule::in(Requestitem::getUomOptions())],
//             'items.*.qty'   => ['required', 'numeric', 'min:0', 'max:1000000000'],
// 'items.*.price' => ['required', 'numeric', 'min:0', 'max:100000000000'],
//             'items.*.total_price'   => ['nullable'],
//         ]);

//         DB::beginTransaction();

//         try {
//            $formrequest = Formrequest::with('items')->get()
//     ->first(fn($u) => substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash);

//             if (!$formrequest) {
//                 Log::warning('UPDATE REQUEST - NOT FOUND', ['hash' => $hash]);
//                 return back()->with('error', 'Data tidak ditemukan.');
//             }

//             Log::info('UPDATE REQUEST - BEFORE UPDATE', [
//                 'id' => $formrequest->id,
//                 'data' => $formrequest->toArray()
//             ]);

//             $totalAmount = 0;
//             foreach ($validated['items'] as $item) {
//                 // $totalAmount += $item['qty'] * $item['price'];
//                 $totalAmount += round($item['qty'] * $item['price'], 2);
//             }

//             $previousStatus = $formrequest->status; // simpan status sebelumnya

//             $formrequest->update([
//                 'request_type_id' => $validated['request_type_id'],
//                 'vendor_id'       => $validated['vendor_id'] ?? null,
//                 'request_date'    => $validated['request_date'],
//                 'deadline'        => $validated['deadline'],
//                 'title'           => $validated['title'],
//                 'notes'           => $validated['notes'] ?? null,
//                 'total_amount'    => round($totalAmount, 2),
//                 'status'          => $validated['status'],
//             ]);

//             Log::info('UPDATE REQUEST - AFTER HEADER UPDATE', [
//                 'id' => $formrequest->id,
//                 'data' => $formrequest->fresh()->toArray()
//             ]);
//             // Buat atau update Requestapproval jika status berubah ke Approved Director
//             if (
//                 $validated['status'] === 'Approved Director' &&
//                 $previousStatus !== 'Approved Director'
//             ) {
//                 $approval = Requestapproval::firstOrNew([
//                     'request_id' => $formrequest->id,
//                 ]);

//                 $approval->approval2    = auth()->id();
//                 $approval->approved_at2 = now();
//                 $approval->save();

//                 Log::info('UPDATE REQUEST - APPROVAL2 SAVED', [
//                     'request_id' => $formrequest->id,
//                     'approval2'  => auth()->id(),
//                 ]);
//             }
//             if (
//                 $validated['status'] === 'Approved Manager' &&
//                 $previousStatus !== 'Approved Manager'
//             ) {
//                 $approval = Requestapproval::firstOrNew([
//                     'request_id' => $formrequest->id,
//                 ]);

//                 $approval->approver1    = auth()->id();
//                 $approval->approver1_at = now();
//                 $approval->save();
//                 Log::info('UPDATE REQUEST - APPROVAL2 SAVED', [
//                     'request_id' => $formrequest->id,
//                     'approver1'  => auth()->id(),
//                     'approver2'  => auth()->id(),
//                 ]);
//             }
//             if (
//             $validated['status'] === 'Submitted' &&
//             $previousStatus !== 'Submitted'
//         ) {
//             try {
//                 // Ambil data employee user yang sedang login
//                 $employee = auth()->user()->employee; // sesuaikan relasi jika berbeda

//                 $managerResponse = Http::get("http://127.0.0.1:8001/api/manager/" . $employee->id);

//                 if ($managerResponse->successful()) {
//                     $managerData  = $managerResponse->json();
//                     $managerEmail = $managerData['manager']['company_email'] ?? null;

//                     if ($managerEmail) {
//                         Mail::to($managerEmail)->send(new RequestMail($formrequest));

//                         Log::info('UPDATE REQUEST - SUBMITTED MAIL SENT', [
//                             'request_id'    => $formrequest->id,
//                             'manager_email' => $managerEmail,
//                         ]);
//                     } else {
//                         Log::warning('UPDATE REQUEST - MANAGER EMAIL NOT FOUND', [
//                             'request_id'   => $formrequest->id,
//                             'manager_data' => $managerData,
//                         ]);
//                     }
//                 } else {
//                     Log::warning('UPDATE REQUEST - MANAGER API FAILED', [
//                         'request_id' => $formrequest->id,
//                         'status'     => $managerResponse->status(),
//                         'body'       => $managerResponse->body(),
//                     ]);
//                 }
//             } catch (\Throwable $mailException) {
//                 // Gagal kirim email tidak boleh membatalkan transaksi utama
//                 Log::error('UPDATE REQUEST - MAIL ERROR', [
//                     'request_id' => $formrequest->id,
//                     'message'    => $mailException->getMessage(),
//                 ]);
//             }
//         }

//             // Delete items lama
//             Requestitem::where('request_id', $formrequest->id)->delete();

//             // Insert ulang
//             foreach ($validated['items'] as $item) {
//                 $total = $item['qty'] * $item['price'];
//                 Requestitem::create([
//                     'request_id'    => $formrequest->id,
//                     'item_name'     => $item['item_name'],
//                     'specification' => $item['specification'] ?? null,
//                     'qty'           => $item['qty'],
//                     'uom'           => $item['uom'],
//                     'price'         => $item['price'],
//                     'total_price'   => $total,
//                 ]);
//             }
//             Log::info('UPDATE REQUEST - ITEMS REPLACED', [
//                 'request_id' => $formrequest->id,
//                 'total_items' => count($validated['items'])
//             ]);

//             DB::commit();

//             Log::info('UPDATE REQUEST - SUCCESS', [
//                 'request_id' => $formrequest->id
//             ]);

//             return redirect()
//                 ->route('request')
//                 ->with('success', 'Request berhasil diupdate.');
//         } catch (\Throwable $e) {
//             DB::rollBack();

//             Log::error('UPDATE REQUEST - ERROR', [
//                 'message' => $e->getMessage(),
//                 'file'    => $e->getFile(),
//                 'line'    => $e->getLine(),
//                 'trace'   => $e->getTraceAsString()
//             ]);

//             return back()
//                 ->withInput()
//                 ->with('error', 'Gagal update request: ' . $e->getMessage());
//         }
//     }
// public function update(Request $request, $hash)
// {
//     Log::info('UPDATE REQUEST START', [
//         'payload' => $request->all(),
//         'user_id' => Auth::id(),
//         'request_id' => $hash
//     ]);
//     $validated = $request->validate([
//         'request_type_id'       => ['required', 'exists:request_type,id'],
//         'company_id'            => ['nullable', 'exists:hrx.company_tables,id'],
//         'vendor_id'             => ['nullable', 'exists:vendor,id'],
//         'transfer'              => ['nullable', 'string'],
//         'request_date'          => ['required', 'date'],
//         'deadline'              => ['required', 'date', 'after_or_equal:request_date'],
//         'title'                 => ['required', 'string', 'max:255'],
//         'notes'                 => ['nullable', 'string'],
//         'addressed_to'          => ['nullable', 'string'],
//         'destination'           => ['nullable', 'string', 'max:255'],
//         'items'                 => ['required', 'array', 'min:1'],
//         'items.*.item_name'     => ['required', 'string', 'max:255'],
//         'items.*.specification' => ['nullable', 'string'],
//         'items.*.qty'           => ['required'],
//         'items.*.uom'           => ['required', Rule::in(Requestitem::getUomOptions())],
//         'items.*.price'         => ['required'],
//     ]);

//     // Helper parsing
//     $parsePrice = fn($v) => (float) str_replace(',', '.', str_replace('.', '', $v));
//     $parseQty   = fn($v) => (float) str_replace(',', '.', $v);

//     DB::beginTransaction();

//     try {
//          $formrequest = Formrequest::with('items')->get()->first(function ($u) use ($hash) {
//                 return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
//             });
//         $companyName = null;
//         if (!empty($validated['company_id'])) {
//             $companyName = Company::on('hrx')
//                 ->where('id', $validated['company_id'])
//                 ->value('name');
//         }
//         $totalAmount = collect($validated['items'])->sum(
//             fn($item) => $parseQty($item['qty']) * $parsePrice($item['price'])
//         );
//         Log::info('TOTAL AMOUNT UPDATE', ['total' => $totalAmount]);
//         $formrequest->update([
//             'request_type_id' => $validated['request_type_id'],
//             'vendor_id'       => $validated['vendor_id'] ?? null,
//             'request_date'    => $validated['request_date'],
//             'company_id'      => $validated['company_id'] ?? null,
//             'addressed_to'    => $validated['addressed_to'] ?? null,
//             'transfer'        => $companyName,
//             'deadline'        => $validated['deadline'],
//             'title'           => $validated['title'],
//             'notes'           => $validated['notes'] ?? null,
//             'total_amount'    => round($totalAmount, 2),
//         ]);
//         Requestitem::where('request_id', $formrequest->id)->delete();
//         foreach ($validated['items'] as $item) {
//             $qty   = $parseQty($item['qty']);
//             $price = $parsePrice($item['price']);
//             Requestitem::create([
//                 'request_id'    => $formrequest->id,
//                 'item_name'     => $item['item_name'],
//                 'specification' => $item['specification'] ?? null,
//                 'qty'           => $qty,
//                 'uom'           => $item['uom'],
//                 'price'         => $price,
//                 'total_price'   => round($qty * $price, 2),
//             ]);
//         }
//         DB::commit();
//         Log::info('UPDATE SUCCESS', ['id' => $formrequest->id]);
//         return redirect()
//             ->route('request')
//             ->with('success', 'Request berhasil diupdate.');
//     } catch (\Throwable $e) {
//         DB::rollBack();
//         Log::error('UPDATE ERROR', [
//             'message' => $e->getMessage(),
//             'trace'   => $e->getTraceAsString()
//         ]);
//         return back()
//             ->withInput()
//             ->with('error', 'Gagal update request: ' . $e->getMessage());
//     }
public function update(Request $request, $hash)
{
    Log::info('UPDATE REQUEST - START', [
        'hash' => $hash,
        'user_id' => auth()->id(),
        'payload' => $request->all()
    ]);

    $validated = $request->validate([
        'request_type_id'       => ['required', 'exists:request_type,id'],
        'vendor_id'             => ['nullable', 'exists:vendor,id'],
        'request_date'          => ['required', 'date'],
        'deadline'              => ['required', 'date', 'after_or_equal:request_date'],
        'title'                 => ['required', 'string', 'max:255'],
        // 'ca_number'                 => ['required', 'string', 'max:255'],
        'ca_number' => [
    Rule::requiredIf(
        auth()->user()->hasRole('finance') && $request->isMethod('put')
    ),
    'string',
    'max:255'
],
        'notes'                 => ['nullable', 'string'],
        'notes_fa'                 => ['nullable', 'string'],
        'notes_fir'                 => ['nullable', 'string'],
        'destination'           => ['nullable', 'string', 'max:255'],
        'status'                => ['required', Rule::in([
            'Draft','Submitted',
            'Approved Manager','Rejected Manager',
            'Approved Finance','Rejected Finance',
            'Approved Director','Rejected Director','Done'
        ])],
        'items'                 => ['required', 'array', 'min:1'],
        'items.*.item_name'     => ['required', 'string', 'max:255'],
        'items.*.specification' => ['nullable', 'string'],
        'items.*.uom'           => ['required', Rule::in(Requestitem::getUomOptions())],
        'items.*.qty'           => ['required'],
        'items.*.price'         => ['required'],
    ]);

    // ✅ parsing angka (WAJIB biar gak kelebihan 0 lagi)
    $parsePrice = fn($v) => (float) str_replace(',', '.', str_replace('.', '', $v));
    $parseQty   = fn($v) => (float) str_replace(',', '.', $v);

    DB::beginTransaction();

    try {
        // ✅ lebih efisien (tidak get semua data)
        $formrequest = Formrequest::all()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });

        if (!$formrequest) {
            Log::warning('UPDATE REQUEST - NOT FOUND', ['hash' => $hash]);
            return back()->with('error', 'Data tidak ditemukan.');
        }

        $previousStatus = $formrequest->status;

        // ✅ hitung total dengan parsing
        $totalAmount = collect($validated['items'])->sum(function ($item) use ($parseQty, $parsePrice) {
            return $parseQty($item['qty']) * $parsePrice($item['price']);
        });

        // ✅ update header
        $formrequest->update([
            'request_type_id' => $validated['request_type_id'],
            'vendor_id'       => $validated['vendor_id'] ?? null,
            'request_date'    => $validated['request_date'],
            'deadline'        => $validated['deadline'],
            'title'           => $validated['title'],
            'ca_number'           => $validated['ca_number']?? null,
            'notes'           => $validated['notes'] ?? null,
            'notes_fa'           => $validated['notes_fa'] ?? null,
            'notes_dir'           => $validated['notes_dir'] ?? null,
            'total_amount'    => round($totalAmount, 2),
            'status'          => $validated['status'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | APPROVAL LOGIC
        |--------------------------------------------------------------------------
        */
        $approval = Requestapproval::firstOrCreate([
    'request_id' => $formrequest->id,
]);

if ($validated['status'] === 'Approved Manager' && $previousStatus !== 'Approved Manager') {
    $approval->update([
        'approver1'    => auth()->id(),
        'approver1_at' => now(),
    ]);

    Log::info('APPROVAL MANAGER SAVED', ['approval_id' => $approval->id]);
}

if ($validated['status'] === 'Approved Director' && $previousStatus !== 'Approved Director') {
    $approval->update([
        'approver2'    => auth()->id(),
        'approver2_at' => now(),
    ]);

    Log::info('APPROVAL DIRECTOR SAVED', ['approval_id' => $approval->id]);
}
//         pakai ini yang benar
//         if ($validated['status'] === 'Approved Manager' && $previousStatus !== 'Approved Manager') {
//     $approval = Requestapproval::firstOrNew([
//         'request_id' => $formrequest->id,
//     ]);

//     // ⚠️ Sesuaikan nama kolom dengan migration kamu!
//     $approval->approver1    = auth()->id();   // cek: approval1 atau approver1?
//     $approval->approver1_at = now();          // cek: approved_at1 atau approver1_at?
//     $approval->save();
//     Log::info('APPROVAL MANAGER SAVED', ['approval_id' => $approval->id]);
// }
//         if ($validated['status'] === 'Approved Director' && $previousStatus !== 'Approved Director') {
//     $approval = Requestapproval::firstOrNew([
//         'request_id' => $formrequest->id,
//     ]);
//     // ⚠️ Sesuaikan nama kolom dengan migration kamu!
//     $approval->approver2    = auth()->id();   // cek: approval1 atau approver1?
//     $approval->approver2_at = now();          // cek: approved_at1 atau approver1_at?
//     $approval->save();

//     Log::info('APPROVAL director SAVED', ['approval_id' => $approval->id]);
// }
        // if ($validated['status'] === 'Approved Director' && $previousStatus !== 'Approved Director') {
        //     $approval = Requestapproval::firstOrNew([
        //         'request_id' => $formrequest->id,
        //     ]);

        //     $approval->approval2    = auth()->id();
        //     $approval->approved2_at = now();
        //     $approval->save();
        // }
        

        // if ($validated['status'] === 'Approved Manager' && $previousStatus !== 'Approved Manager') {
        //     $approval = Requestapproval::firstOrNew([
        //         'request_id' => $formrequest->id,
        //     ]);

        //     $approval->approver1    = auth()->id();
        //     $approval->approver1_at = now();
        //     $approval->save();
        // }
       

        /*
        |--------------------------------------------------------------------------
        | SEND EMAIL SAAT SUBMITTED
        |--------------------------------------------------------------------------
        */
        // if ($validated['status'] === 'Submitted' && $previousStatus !== 'Submitted') {
        //     try {
        //         $employee = auth()->user()->employee;

        //         if ($employee) {
        //             $managerResponse = Http::get("http://127.0.0.1:8001/api/manager/" . $employee->id);

        //             if ($managerResponse->successful()) {
        //                 $managerEmail = data_get($managerResponse->json(), 'manager.company_email');

        //                 if ($managerEmail) {
        //                     Mail::to($managerEmail)->send(new RequestMail($formrequest));
        //                 }
        //             }
        //         }
        //     } catch (\Throwable $mailException) {
        //         Log::error('MAIL ERROR', [
        //             'message' => $mailException->getMessage()
        //         ]);
        //     }
        // }
        if ($validated['status'] === 'Submitted' && $previousStatus !== 'Submitted') {
    try {
        $employee = auth()->user()->employee;

        if ($employee) {
            $baseUrl = config('services.manager_api.url');

            $managerResponse = Http::get("{$baseUrl}/api/manager/{$employee->id}");

            if ($managerResponse->successful()) {
                $managerEmail = data_get($managerResponse->json(), 'manager.company_email');

                if ($managerEmail) {
                    Mail::to($managerEmail)->send(new RequestMail($formrequest));
                }
            }
        }
    } catch (\Throwable $mailException) {
        Log::error('MAIL ERROR', [
            'message' => $mailException->getMessage()
        ]);
    }
}
        // if ($validated['status'] === 'Submitted' && $previousStatus !== 'Submitted') {
        //     try {
        //         $employee = auth()->user()->employee;

        //         if ($employee) {
        //             $managerResponse = Http::get("http://127.0.0.1:8001/api/manager/" . $employee->id);

        //             if ($managerResponse->successful()) {
        //                 $managerEmail = data_get($managerResponse->json(), 'manager.company_email');

        //                 if ($managerEmail) {
        //                     Mail::to($managerEmail)->send(new RequestMail($formrequest));
        //                 }
        //             }
        //         }
        //     } catch (\Throwable $mailException) {
        //         Log::error('MAIL ERROR', [
        //             'message' => $mailException->getMessage()
        //         ]);
        //     }
        // }
        if ($validated['status'] === 'Approved Manager' && $previousStatus !== 'Approved Manager') {
    try {
        // Ambil employee dengan posisi tertentu
        $employees = Employee::whereHas('position', function ($query) {
            $query->whereIn('id', [
                '01973a06-74e2-706d-97fe-097c12788c59',
                '01992267-3466-724e-93b3-46350f7e9094'
            ]);
        })->get();

        // Loop kirim email ke masing-masing employee
        foreach ($employees as $employee) {
            if ($employee->company_email) {
                Mail::to($employee->company_email)
                    ->send(new RequestMail($formrequest));
            }
        }

    } catch (\Throwable $mailException) {
        Log::error('MAIL ERROR', [
            'message' => $mailException->getMessage()
        ]);
    }
}

        /*
        |--------------------------------------------------------------------------
        | ITEMS (DELETE + INSERT ULANG)
        |--------------------------------------------------------------------------
        */
        Requestitem::where('request_id', $formrequest->id)->delete();

        foreach ($validated['items'] as $item) {
            $qty   = $parseQty($item['qty']);
            $price = $parsePrice($item['price']);

            Requestitem::create([
                'request_id'    => $formrequest->id,
                'item_name'     => $item['item_name'],
                'specification' => $item['specification'] ?? null,
                'qty'           => $qty,
                'uom'           => $item['uom'],
                'price'         => $price,
                'total_price'   => round($qty * $price, 2),
            ]);
        }

        DB::commit();

        Log::info('UPDATE SUCCESS', ['id' => $formrequest->id]);

        return redirect()
            ->route('request')
            ->with('success', 'Request berhasil diupdate.');

    } catch (\Throwable $e) {
        DB::rollBack();

        Log::error('UPDATE ERROR', [
            'message' => $e->getMessage(),
        ]);

        return back()
            ->withInput()
            ->with('error', 'Gagal update request: ' . $e->getMessage());
    }
}
    // ini yang benar
    // public function update(Request $request, $hash)
    // {
    //     Log::info('UPDATE REQUEST - START', [
    //         'hash' => $hash,
    //         'user_id' => auth()->id(),
    //         'payload' => $request->all()
    //     ]);
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
    //         'status' => 'required|in:Draft,Submitted,Approved Manager,Rejected Manager,Approved Finance,Rejected Finance,Approved Director,Rejected Director,Done',
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
    //         $formrequest = Formrequest::with('items')->get()->first(function ($u) use ($hash) {
    //             return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
    //         });

    //         if (!$formrequest) {
    //             Log::warning('UPDATE REQUEST - NOT FOUND', ['hash' => $hash]);
    //             return back()->with('error', 'Data tidak ditemukan.');
    //         }

    //         Log::info('UPDATE REQUEST - BEFORE UPDATE', [
    //             'id' => $formrequest->id,
    //             'data' => $formrequest->toArray()
    //         ]);

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
    //             'status'          => $validated['status'],
    //         ]);

    //         // log setelah update header
    //         Log::info('UPDATE REQUEST - AFTER HEADER UPDATE', [
    //             'id' => $formrequest->id,
    //             'data' => $formrequest->fresh()->toArray()
    //         ]);

    //         // delete items lama
    //         Requestitem::where('request_id', $formrequest->id)->delete();

    //         // insert ulang
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

    //         Log::info('UPDATE REQUEST - ITEMS REPLACED', [
    //             'request_id' => $formrequest->id,
    //             'total_items' => count($validated['items'])
    //         ]);

    //         DB::commit();

    //         Log::info('UPDATE REQUEST - SUCCESS', [
    //             'request_id' => $formrequest->id
    //         ]);

    //         return redirect()
    //             ->route('request')
    //             ->with('success', 'Request berhasil diupdate.');
    //     } catch (\Throwable $e) {
    //         DB::rollBack();

    //         Log::error('UPDATE REQUEST - ERROR', [
    //             'message' => $e->getMessage(),
    //             'file'    => $e->getFile(),
    //             'line'    => $e->getLine(),
    //             'trace'   => $e->getTraceAsString()
    //         ]);

    //         return back()
    //             ->withInput()
    //             ->with('error', 'Gagal update request: ' . $e->getMessage());
    //     }
    // }
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




}
