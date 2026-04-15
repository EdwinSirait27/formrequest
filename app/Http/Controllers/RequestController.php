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
use App\Models\Capextype;
use App\Models\User;
use App\Models\ItemVendorQuotation;
use App\Models\Documenttype;
use App\Models\Requestlink;
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
            'company',
            'vendor',
            'capextype',
            'documenttype',
            'requesttype',
            'user.employee'
        ])->select([
            'id',
            'request_type_id',
            'capex_type_id',
            'vendor_id',
            'transfer',
            'company_id',
            'destination',
            'document_number',
            'document_type_id',
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
        if ($request->filled('type')) {
    $query->whereHas('requesttype', function ($q) use ($request) {
        $q->where('code', strtoupper($request->type));
    });
}
        $user = auth()->user();
        if ($user->hasRole('admin')) {
        } 
       
        elseif ($user->hasRole('manager')) {
    $employee = $user->employee;

    if ($employee && $employee->structure_id) {
        $structure = Structuresnew::with('allChildren')
            ->find($employee->structure_id);

        if ($structure) {
            $structureIds = $structure->getAllIds();

            $employeeIds = Employee::whereIn('structure_id', $structureIds)
                ->pluck('id');

            $userIds = User::whereIn('employee_id', $employeeIds)
                ->pluck('id')
                ->push($user->id); // ✅ include diri sendiri

            $query->where(function ($q) use ($userIds, $user) {

                // ✅ NON CAPEX
                $q->where(function ($q1) use ($userIds) {
                    $q1->whereIn('user_id', $userIds)
                        ->whereIn('status', ['Submitted', 'Approved Manager'])
                        ->whereHas('requesttype', function ($rt) {
                            $rt->where('code', '!=', 'CAPEX');
                        });
                })

                // ✅ CAPEX - Submitted (semua boleh lihat)
                ->orWhere(function ($q2) use ($userIds) {
                    $q2->whereIn('user_id', $userIds)
                        ->where('status', 'Submitted')
                        ->whereHas('requesttype', function ($rt) {
                            $rt->where('code', 'CAPEX');
                        });
                })

                // ✅ CAPEX - Approved Manager (hanya milik dia)
                ->orWhere(function ($q3) use ($user) {
                    $q3->where('status', 'Approved Manager')
                        ->whereHas('requesttype', function ($rt) {
                            $rt->where('code', 'CAPEX'); 
                        })
                        ->whereHas('capextype', function ($ct) use ($user) {
                            $ct->where('user_id', $user->id);
                        });
                });

            });
        }
    }
}
        elseif ($user->hasRole('finance')) {
            $query->where('status', 'Approved Director');
        } elseif ($user->hasRole('director')) {
            $query->whereIn('status', [
                'Approved Manager',
                'Approved Director',
                'Rejected Director'
            ]);
        } elseif ($user->hasRole('user')) {
            $query->where('user_id', $user->id);
        }
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('vendor_name', function ($row) {
                return optional($row->vendor)->vendor_name ?? 'Empty';
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
            ->addColumn('code', function ($row) {
                return optional($row->capextype)->code ?? 'Empty';
            })
            ->filterColumn('code', function ($query, $keyword) {
                $query->whereHas('capextype', fn($q) => $q->where('code', 'like', "%{$keyword}%"));
            })
            ->addColumn('employee_name', function ($row) {
                return optional($row->user->employee ?? null)->employee_name ?? '-';
            })
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('user.employee', fn($q) => $q->where('employee_name', 'like', "%{$keyword}%"));
            })
            ->addColumn('action', function ($row) {
                $user = auth()->user();
                $isLocked =
                    ($row->status === 'Submitted'        && $user->hasRole('user'))    ||
                    ($row->status === 'Approved Manager' && $user->hasRole('manager')) ||
                    ($row->status === 'Approved Director' && $user->hasRole('director'));
                $idHashed = substr(hash('sha256', $row->id . config('app.key')), 0, 8);
                $id = $row->id;
                if ($isLocked) {
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
                $status = $row->status ?? null;

                if ($status === 'Approved Director') {
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
                } else {
                    $pdfBtn = '
        <span
           class="inline-flex items-center justify-center p-2
                  text-slate-400 cursor-not-allowed"
           title="PDF terkunci (harus Approved Director)">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16 11V7a4 4 0 10-8 0v4M5 11h14v8a2 2 0 01-2 2H7a2 2 0 01-2-2v-8z" />
            </svg>
        </span>';
                }
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
        
        $request = Formrequest::with('items', 'items.vendors','capextype')->get()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
        abort_if(!$request, 404);
        $user = auth()->user();
        if ($user->hasRole('user') && $request->user_id !== $user->id) {
            return redirect()->route('request')
                ->with('error', 'you account doesnt have access to edit this request.');
        }
        if (!$user->hasRole('admin')) {
            $lockRules = [
                'Draft'             => ['finance', 'manager', 'director'], // selain ini boleh edit
                'Submitted'         => ['user', 'finance', 'director'],
                'Approved Manager'  => ['user', 'manager', 'finance'],
                'Rejected Manager'  => ['director', 'manager', 'finance'],
                'Approved Director' => ['user', 'manager', 'director'],
                'Rejected Director' => ['finance', 'user'],
                'Done'              => ['user', 'manager', 'director'],
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
        $requesttypes = Requesttype::select('id', 'request_type_name', 'code')->get();
        $capextypes = Capextype::with('user.employee')
            ->select('id', 'user_id', 'code')
            ->get();
        $documenttypes = Documenttype::select('id', 'document_type_name')->get();
        $paymenttypeprs = Formrequest::getPROptions();

        $user = auth()->user();
        $userCompanyName = optional($user->employee->company)->name;
        $userCompanyId   = optional($user->employee)->company_id;
        if (!$userCompanyId) {
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
        } 
        elseif ($user->hasRole('manager')) {

    $statuses = [];

    $capextype = $request->capextype ?? null;

    // ❌ Kalau tidak ada capex → pakai Manager
    if (!$capextype) {
        $statuses = [
            'Approved Manager' => 'Approved Manager',
            'Rejected Manager' => 'Rejected Manager',
        ];
    }

    // ✔ Kalau ada capex & dia owner
    if (
        $capextype &&
        $capextype->user_id === $user->id
    ) {
        if ($capextype->code === 'IT') {
            $statuses = [
                'Approved IT' => 'Approved IT',
                'Rejected IT' => 'Rejected IT',
            ];
        }

        if ($capextype->code === 'BD') {
            $statuses = [
                'Approved BD' => 'Approved BD',
                'Rejected BD' => 'Rejected BD',
            ];
        }
    }
}
        // elseif ($user->hasRole('manager')) {
        //     $statuses = [
        //         'Approved Manager' => 'Approved Manager',
        //         'Rejected Manager' => 'Rejected Manager',
        //     ];
        //     $capextype = $request->capextype ?? null;
        //     if (
        //         $capextype &&
        //         $capextype->user_id === $user->id
        //     ) {
        //         if ($capextype->code === 'IT') {
        //             $statuses['Approved IT'] = 'Approved IT';
        //             $statuses['Rejected IT'] = 'Rejected IT';
        //         }

        //         if ($capextype->code === 'BD') {
        //             $statuses['Approved BD'] = 'Approved BD';
        //             $statuses['Rejected BD'] = 'Rejected BD';
        //         }
        //     }

        // }
        //                     dd([
//     'login_user_id' => $user->id,
//     'capex_user_id' => $capextype?->user_id,
//     'capex_code'    => $capextype?->code,
// ]);
//         dd([
//     'capex_type_id' => $request->capex_type_id,
//     'capex_exists' => \App\Models\Capextype::find($request->capex_type_id),
// ]); 
        elseif ($user->hasRole('user')) {
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
        $assets = Formrequest::getAssetOptions();
        if ($user->hasRole('manager')) {
            $employee = $user->employee;
            if ($employee && $employee->structure_id) {
                $structure = Structuresnew::with('allChildren')
                    ->find($employee->structure_id);
                if ($structure) {
                    $structureIds = $structure->getAllIds();
                    $employeeIds = Employee::whereIn('structure_id', $structureIds)
                        ->pluck('id');
                    $userIds = User::whereIn('employee_id', $employeeIds)
                        ->pluck('id')
                        ->toArray();
                    $userIds[] = $user->id;
                    if (!in_array($request->user_id, $userIds)) {
                        return redirect()->route('request')
                            ->with('error', 'you can edit your own request only or your anak buah.');
                    }
                }
            }
        }
        $isDirector = $user->hasRole('director');

        return view('pages.request.editrequest', compact(
            'request',
            'companies',
            'vendors',
            'capextypes',
            'requesttypes',
            'statuses',
            'uoms',
            'documenttypes',
            'paymenttypeprs',
            'assets',
            'isDirector',
            'userCompanyId',
            'userCompanyName'
        ));
    }
    public function show($hash)
    // {

    //     $request = Formrequest::with('items', 'approval.approver1User')
    //         ->get()
    //         ->first(function ($u) use ($hash) {
    //             return substr(hash('sha256', $u->id . config('app.key')), 0, 8) === $hash;
    //         });
    //     abort_if(!$request, 404);
    //     $request->load('approval.approver1User.employee');
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
    //     return view('pages.request.showrequest', compact(
    //         'companies',
    //         'request',
    //         'vendors',
    //         'requesttypes',
    //         'statuses',
    //         'uoms'
    //     ));
    // }
    // private function resolveManager(Employee $employee): ?Employee
    // {
    //     $employee->loadMissing('structuresnew.parent');
    //     if (!$employee->structuresnew) return null;
    //     $current          = $employee->structuresnew->parent;
    //     $managerStructure = null;
    //     while ($current) {
    //         if ($current->is_manager) {
    //             $managerStructure = $current;
    //             break;
    //         }
    //         $current->load('parent');
    //         $current = $current->parent;
    //     }
    //     if (!$managerStructure) return null;
    //     return Employee::with([
    //         'structuresnew.submissionposition.positionRelation',
    //     ])->where('structure_id', $managerStructure->id)->first();
    // }
    {
        $request = Formrequest::with('items', 'items.vendors', 'approval.approver1User.employee', 'approval.approver2User.employee')->get()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
        abort_if(!$request, 404);
        $user = auth()->user();
        if ($user->hasRole('user') && $request->user_id !== $user->id) {
            return redirect()->route('request')
                ->with('error', 'you account doesnt have access to show this request.');
        }
        if (!$user->hasRole('admin')) {
            $lockRules = [
                'Draft'             => ['finance', 'manager', 'director'], // selain ini boleh edit
                'Submitted'         => ['user', 'finance', 'director'],
                // 'Approved Manager'  => ['user', 'manager', 'finance'],
                'Rejected Manager'  => ['director', 'manager', 'finance'],
                // 'Approved Director' => ['user', 'manager', 'director'],
                'Rejected Director' => ['finance', 'user'],
                // 'Done'              => ['user', 'manager', 'director'],
            ];
            $lockedRoles = $lockRules[$request->status] ?? [];
            $isLocked = collect($lockedRoles)
                ->contains(fn($role) => $user->hasRole($role));
            if ($isLocked) {
                return redirect()->route('request')
                    ->with('error', "Request with status '{$request->status}' can't be showed.");
            }
        }
        $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
        $requesttypes = Requesttype::select('id', 'request_type_name', 'code')->get();
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
                'Approved Manager' => 'Approved Manager',
                'Approved Director' => 'Approved Director',
                'Rejected Director' => 'Rejected Director',
            ];
        } else {
            abort(403, 'Unauthorized');
        }

        $uoms = Requestitem::getUomOptions();
        $assets = Formrequest::getAssetOptions();

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
        $isDirector = $user->hasRole('director');
        return view('pages.request.showrequest', compact(
            'request',
            'companies',
            'vendors',
            'requesttypes',
            'statuses',
            'uoms',
            'assets',
            'isDirector',
            'userCompanyId',
            'userCompanyName'
        ));
    }
    private function resolveManager(\App\Models\Employee $employee): ?\App\Models\Employee
    {
        // Ambil struktur milik employee ini
        $structure = $employee->structuresnew;

        if (!$structure) {
            return null;
        }

        // Ambil parent structure (atasan langsung)
        $parentStructure = $structure->parent;

        if (!$parentStructure) {
            return null;
        }

        // Gunakan employees() bukan employee() karena hasOne bukan hasMany
        $managerEmployee = $parentStructure->employees()
            ->with('structuresnew.submissionposition.positionRelation')
            ->first();

        return $managerEmployee; // ?\App\Models\Employee ✅
    }
    public function pdfview($id)
    {
        set_time_limit(120);
        ini_set('memory_limit', '512M');

        $request = Formrequest::with([
            'vendor',
            'requesttype',
            'capextype',
            'documenttype',
            'capextype.user.employee',
            'items',
            'links',
            'items.vendors',
            'company:id',
            'user.employee',
            'items.vendors.vendor',
            'user.employee.company',
            'user.employee.position:id,name',
            'user.employee.department:id,department_name',
            'approval.approver2User.employee',
            'approval.approver2User.employee.position:id,name',
        ])->findOrFail($id);

        $capexVendors = $request->items->mapWithKeys(function ($item) {
            return [
                $item->id => $item->vendors->values()->map(fn($v) => [
                    'vendor_name' => $v->vendor?->vendor_name ?? 'Empty',
                    'price'       => $v->price ?? 0,
                    'is_selected' => (bool) $v->is_selected,
                ])
            ];
        });

        $employee    = $request->user?->employee;
        $companymail = $employee->company_email;
        $requestDate = $request->request_date
            ->timezone('Asia/Makassar')
            ->translatedFormat('d F Y');
        $Deadline = $request->deadline
            ->timezone('Asia/Makassar')
            ->translatedFormat('d F Y');

        // ── toBase64 helper ──────────────────────────────────────────
        $cache    = [];
        $toBase64 = static function (string $localPath) use (&$cache): ?string {
            if (isset($cache[$localPath])) return $cache[$localPath];
            if (!is_file($localPath))      return $cache[$localPath] = null;
            $image = @file_get_contents($localPath);
            if ($image === false)          return $cache[$localPath] = null;
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_buffer($finfo, $image);
            finfo_close($finfo);
            return $cache[$localPath] = 'data:' . $mime . ';base64,' . base64_encode($image);
        };
        $showManagerSignature = in_array($request->status, ['Approved Manager', 'Approved Director']);

        // ── Logo ─────────────────────────────────────────────────────
        $logoBase64   = null;
        $companyId    = $request->company?->id;
        $internalBase = rtrim(config('services.hrx.internal_url', env('HRX_INTERNAL_URL', 'http://127.0.0.1:8001')), '/');

        if ($companyId) {
            try {
                $apiResponse = Http::withoutVerifying()->timeout(8)->get("{$internalBase}/api/company/{$companyId}");

                if ($apiResponse->successful()) {
                    $logoUrl = $apiResponse->json('logo_url');

                    if ($logoUrl) {
                        $logoUrlInternal = preg_replace(
                            '#^https?://hrx\.asianbay\.co\.id#',
                            $internalBase,
                            $logoUrl
                        );

                        $imgResponse = Http::withoutVerifying()->timeout(5)->get($logoUrlInternal);

                        if ($imgResponse->successful()) {
                            $body       = $imgResponse->body();
                            $finfo      = finfo_open(FILEINFO_MIME_TYPE);
                            $mime       = finfo_buffer($finfo, $body);
                            finfo_close($finfo);
                            $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($body);
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Logo fetch error: ' . $e->getMessage());
            }
        }

        // ── Signatures ───────────────────────────────────────────────
        $managerName            = null;
        $positionName           = null;
        $managerSignatureBase64 = null;

        if ($employee && $showManagerSignature) {
            $manager = $this->resolveManager($employee);

            if ($manager) {
                $managerName  = $manager->employee_name;
                $positionName = optional(
                    optional($manager->structuresnew?->submissionposition)
                        ->positionRelation
                )->name ?? null;

                if ($manager->signature) {
                    $managerSignatureBase64 = $toBase64(
                        public_path('storage/' . $manager->signature)
                    );
                }
            }
        }

        $signatureBase64 = $employee?->signature
            ? $toBase64(public_path('storage/' . $employee->signature))
            : null;

        $approver2   = $request->approval?->approver2User?->employee;
        $signatories = [
            'approver2' => [
                'name'      => $approver2?->employee_name,
                'position'  => $approver2?->position?->name,
                'signature' => $approver2?->signature
                    ? $toBase64(public_path('storage/' . $approver2->signature))
                    : null,
            ],
        ];
        // ── Render PDF ───────────────────────────────────────────────
        $viewData = [
            'request'                => $request,
            'companymail'                => $companymail,
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
            'showSignature'          => $showManagerSignature,
            'capexVendors'           => $capexVendors,
        ];

        return Pdf::loadView('pages.request.pdf', $viewData)
            ->setPaper('A4')
            ->setOptions([
                'isRemoteEnabled'      => false,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled'         => false,
                'defaultFont'          => 'sans-serif',
            ])
            ->download('request-' . $request->document_number . '.pdf');
    }
    // public function create()
    // {
    //     $user = auth()->user();
    //     if (!$user->hasRole(['user', 'admin'])) {
    //         abort(403, 'Tidak memiliki akses');
    //     }
    //     $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
    //     $requesttypes = Requesttype::select('id', 'request_type_name', 'code')->get();
    //     $capextypes = Capextype::with('user.employee')
    //         ->select('id', 'user_id', 'code')
    //         ->get();
    //     $userCompanyName = optional($user->employee->company)->name;
    //     $userCompanyId   = optional($user->employee)->company_id;
    //     if (!$userCompanyId) {
    //         abort(403, 'User tidak memiliki company');
    //     }
    //     $mainCompany = config('app.main_company_id');
    //     $isMainCompany = $userCompanyId === $mainCompany;
    //     if ($isMainCompany) {
    //         $companies = Company::on('hrx')->pluck('name', 'id');
    //     } else {
    //         $companies = Company::on('hrx')
    //             ->where('id', $userCompanyId)
    //             ->pluck('name', 'id');
    //     }
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
    //     $assets = Formrequest::getAssetOptions();
    //     return view('pages.request.createrequest', compact(
    //         'companies',
    //         'userCompanyId',
    //         'uoms',
    //         'assets',
    //         'vendors',
    //         'capextypes',
    //         'isMainCompany',
    //         'requesttypes',
    //         'statuses'
    //     ));
    // }
    public function create()
    {
        $user = auth()->user();
        if (!$user->hasRole(['user', 'admin', 'manager', 'finance', 'director'])) {
            abort(403, 'Tidak memiliki akses');
        }
        $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');

        // Ambil departemen user
        $userDepartment = optional($user->employee->department)->department_name;

        // Departemen yang diizinkan melihat CAPEX
        $capexAllowedDepartments = ['Information Technology', 'Business Development'];

        $requesttypes = Requesttype::select('id', 'request_type_name', 'code')
            ->get()
            ->filter(function ($type) use ($userDepartment, $capexAllowedDepartments) {
                if (strtoupper($type->code) === 'CAPEX') {
                    return in_array($userDepartment, $capexAllowedDepartments);
                }
                return true;
            })
            ->values();
$request = Requesttype::select('id','code')->get();
        $capextypes = Capextype::with('user.employee')
            ->select('id', 'user_id', 'code')
            ->get();
        $documenttypes = Documenttype::select('id', 'document_type_name')->get();
        $userCompanyName = optional($user->employee->company)->name;
        $userCompanyId   = optional($user->employee)->company_id;
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
        $assets = Formrequest::getAssetOptions();
        $paymenttypeprs = Formrequest::getPROptions();
        return view('pages.request.createrequest', compact(
            'companies',
            'userCompanyId',
            'uoms',
            'assets',
            'vendors',
            'capextypes',
            'request',
            'isMainCompany',
            'requesttypes',
            'documenttypes',
            'paymenttypeprs',
            'statuses'
        ));
    }
    //     public function store(Request $request)
    //     {
    //         Log::info('STORE REQUEST START', [
    //             'payload' => $request->all(),
    //             'user_id' => Auth::id()
    //         ]);
    //         $typesNeedMultiVendorCapex = [
    //             '019d3986-699d-7328-a43c-8e730fc4a691',
    //         ];
    //         $typesNeedMultiVendorPR = [
    //             '019d3986-b0e4-706c-a809-08564111507b',
    //         ];

    //         $isMultiVendorCapex = in_array($request->request_type_id, $typesNeedMultiVendorCapex);
    // $isMultiVendorPR    = in_array($request->request_type_id, $typesNeedMultiVendorPR);
    // $isMultivendor = $isMultiVendorCapex || $isMultiVendorPR;
    //         $validated = $request->validate([
    //             'request_type_id'       => ['required', 'exists:request_type,id'],
    //             'company_id'            => ['nullable', 'exists:hrx.company_tables,id'],
    //             'vendor_id' => [
    //                 'nullable',
    //                 'exists:vendor,id',
    //             ],
    //             'assets'                => ['nullable', Rule::in(Formrequest::getAssetOptions())],
    //             'transfer'              => ['nullable', 'string'],
    //             'request_date'          => ['required', 'date'],
    //             'deadline'              => ['required', 'date', 'after_or_equal:request_date'],
    //             'title'                 => ['required', 'string', 'max:255'],
    //             'notes'                 => ['nullable', 'string'],
    //             'status'                => ['nullable', 'string'],
    //           'capex_type_id' => [
    //     $isMultivendor ? 'required' : 'nullable',
    // ],
    //           'document_type_id' => [
    //     $isMultiVendorPR ? 'required' : 'nullable',
    // ],
    //           'payment_type_payreq' => [
    //     $isMultiVendorPR ? 'required' : 'nullable',
    // ],
    //             'addressed_to'          => ['nullable', 'string'],
    //             'destination'           => ['nullable', 'string', 'max:255'],
    //             'items'                 => ['required', 'array', 'min:1'],
    //             'items.*.item_name'     => ['required', 'string', 'max:255'],
    //             'items.*.specification' => ['nullable', 'string'],
    //             'items.*.qty'           => ['required'],
    //             'items.*.uom'           => ['nullable', Rule::in(Requestitem::getUomOptions())],
    //             'items.*.price' => [
    //                     $isMultivendor ? 'required' : 'nullable',
    //             ],
    //             'items.*.vendors'               => [$isMultivendor ? 'required' : 'nullable', 'array'],
    //             'items.*.vendors.*.vendor_id'   => ['nullable', 'exists:vendor,id'],
    //             'items.*.vendors.*.price'       => ['nullable'],
    //             'items.*.vendors.*.notes'       => ['nullable', 'string'],
    //             'links.*.link'           => ['nullable', 'max:255'],
    //         ]);
    //         Log::info('VALIDATION PASSED', ['validated' => $validated]);
    //         $parsePrice = fn($v) => (float) str_replace(',', '.', str_replace('.', '', $v));
    //         $parseQty   = fn($v) => (float) str_replace(',', '.', $v);
    //         DB::beginTransaction();
    //         try {
    //             $companyName = null;
    //             if (!empty($validated['company_id'])) {
    //                 $companyName = Company::on('hrx')
    //                     ->where('id', $validated['company_id'])
    //                     ->value('name');
    //             }
    //             if ($isMultivendor) {
    //                 if (empty($formrequest->manager_it_approved_at)) {
    //                     $totalAmount = 0;
    //                 } else {
    //                     $totalAmount = collect($validated['items'])->sum(function ($item) use ($parseQty, $parsePrice) {
    //                         $qty = $parseQty($item['qty'] ?? 0);
    //                         $firstPrice = $parsePrice($item['vendors'][0]['price'] ?? 0);
    //                         return $qty * $firstPrice;
    //                     });
    //                 }
    //             } else {
    //                 $totalAmount = collect($validated['items'])->sum(
    //                     fn($item) => $parseQty($item['qty']) * $parsePrice($item['price'])
    //                 );
    //             }
    //             Log::info('TOTAL AMOUNT', ['total' => $totalAmount]);
    //             $formrequest = Formrequest::create([
    //                 'request_type_id' => $validated['request_type_id'],
    //                 'vendor_id'       => $validated['vendor_id'] ?? null,
    //                 'capex_type_id'       => $validated['capex_type_id'] ?? null,
    //                 'assets'          => $validated['assets'] ?? null,
    //                 'user_id'         => Auth::id(),
    //                 'request_date'    => $validated['request_date'],
    //                 'company_id'      => $validated['company_id'] ?? null,
    //                 'addressed_to'    => $validated['addressed_to'] ?? null,
    //                 'document_type_id'    => $validated['document_type_id'] ?? null,
    //                 'transfer'        => $companyName,
    //                 'deadline'        => $validated['deadline'],
    //                 'title'           => $validated['title'],
    //                 'notes'           => $validated['notes'] ?? null,
    //                 'total_amount'    => round($totalAmount, 2),
    //                 'status'          => 'Draft',
    //             ]);
    //             Log::info('FORMREQUEST CREATED', ['id' => $formrequest->id]);
    //             foreach ($validated['items'] as $item) {
    //                 $qty = $parseQty($item['qty'] ?? 0);
    //                 if ($isMultivendor) {
    //                     $requestItem = Requestitem::create([
    //                         'request_id'    => $formrequest->id,
    //                         'item_name'     => $item['item_name'],
    //                         'specification' => $item['specification'] ?? null,
    //                         'qty'           => $qty,
    //                         'uom'           => $item['uom'] ?? null,
    //                         'price'         => null,
    //                         'total_price'   => null,
    //                     ]);
    //                     if (!empty($item['vendors'])) {
    //                         foreach ($item['vendors'] as $vendorData) {
    //                             if (empty($vendorData['vendor_id'])) continue;
    //                             $vendorPrice = $parsePrice($vendorData['price'] ?? 0);
    //                             ItemVendorQuotation::create([
    //                                 'request_item_id' => $requestItem->id,
    //                                 'vendor_id'       => $vendorData['vendor_id'],
    //                                 'price'           => $vendorPrice,
    //                                 'notes'           => $vendorData['notes'] ?? null,
    //                                 'is_selected'     => false,
    //                             ]);
    //                             Log::info('VENDOR QUOTATION CREATED', [
    //                                 'request_item_id' => $requestItem->id,
    //                                 'vendor_id'       => $vendorData['vendor_id'],
    //                                 'price'           => $vendorPrice,
    //                             ]);
    //                         }
    //                     }
    //                 } else {
    //                     $price = $parsePrice($item['price'] ?? 0);
    //                     Requestitem::create([
    //                         'request_id'    => $formrequest->id,
    //                         'item_name'     => $item['item_name'],
    //                         'specification' => $item['specification'] ?? null,
    //                         'qty'           => $qty,
    //                         'uom'           => $item['uom'] ?? null,
    //                         'price'         => $price,
    //                         'total_price'   => round($qty * $price, 2),
    //                     ]);
    //                 }
    //             }
    //             if (!empty($validated['links'])) {
    //                 foreach ($validated['links'] as $link) {
    //                     if (empty($link['link'])) continue;
    //                     $formrequest->links()->create([
    //                         'link' => $link['link'],
    //                     ]);
    //                 }
    //             }
    //             DB::commit();
    //             Log::info('STORE SUCCESS');
    //             return redirect()
    //                 ->route('request')
    //                 ->with('success', 'Request created successfully.');
    //         } catch (\Throwable $e) {
    //             DB::rollBack();
    //             Log::error('STORE ERROR', [
    //                 'message' => $e->getMessage(),
    //                 'trace'   => $e->getTraceAsString()
    //             ]);
    //             return redirect()
    //             ->route('request')
    //                 ->withInput()
    //                 ->with('error', 'Failed to created request: ' . $e->getMessage());
    //         }
    //     }
    public function store(Request $request)
    {
        Log::info('STORE REQUEST START', [
            'payload' => $request->all(),
            'user_id' => Auth::id()
        ]);

        $typesNeedMultiVendorCapex = [
            '019d3986-699d-7328-a43c-8e730fc4a691',
        ];

        $typesNeedMultiVendorPR = [
            '019d3986-b0e4-706c-a809-08564111507b',
        ];

        $isMultiVendorCapex = in_array($request->request_type_id, $typesNeedMultiVendorCapex);
        $isMultiVendorPR    = in_array($request->request_type_id, $typesNeedMultiVendorPR);
        $isMultivendor      = $isMultiVendorCapex || $isMultiVendorPR;

        $validated = $request->validate([
            'request_type_id' => ['required', 'exists:request_type,id'],
            'company_id'      => ['nullable', 'exists:hrx.company_tables,id'],
            'vendor_id'       => ['nullable', 'exists:vendor,id'],
            'assets'          => ['nullable', Rule::in(Formrequest::getAssetOptions())],
            'transfer'        => ['nullable', 'string'],
            'request_date'    => ['required', 'date'],
            'deadline'        => ['required', 'date', 'after_or_equal:request_date'],
            'title'           => ['required', 'string', 'max:255'],
            'notes'           => ['nullable', 'string'],

            'capex_type_id' => [$isMultiVendorCapex ? 'required' : 'nullable'],
            'document_type_id' => [$isMultiVendorPR ? 'required' : 'nullable'],
            'payment_type_payreq' => [$isMultiVendorPR ? 'required' : 'nullable'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.item_name' => ['required', 'string'],
            'items.*.specification' => ['nullable', 'string'],
            'items.*.qty' => ['required'],
            'items.*.uom' => ['nullable', Rule::in(Requestitem::getUomOptions())],

            // ✅ FIX: ini kebalik sebelumnya

            'items.*.vendors' => [$isMultivendor ? 'required' : 'nullable', 'array'],
            'items.*.vendors.*.vendor_id' => ['nullable', 'exists:vendor,id'],
            'items.*.price' => [$isMultivendor ? 'nullable' : 'required'],
            'items.*.vendors.*.price' => [$isMultivendor ? 'required' : 'nullable'],

            // ✅ FIX: wajib kalau multivendor

            'items.*.vendors.*.notes' => ['nullable', 'string'],
            'links.*.link' => ['nullable', 'max:255'],
        ]);

        Log::info('VALIDATION PASSED', ['validated' => $validated]);

        $parsePrice = fn($v) => (float) str_replace(',', '.', str_replace('.', '', $v));
        $parseQty   = fn($v) => (float) str_replace(',', '.', $v);

        DB::beginTransaction();

        try {
            // ambil nama company
            $companyName = null;
            if (!empty($validated['company_id'])) {
                $companyName = Company::on('hrx')
                    ->where('id', $validated['company_id'])
                    ->value('name');
            }

            // ✅ FIX: jangan pakai $formrequest sebelum create
            // if ($isMultivendor) {
            //     $totalAmount = collect($validated['items'])->sum(function ($item) use ($parseQty, $parsePrice) {
            //         $qty = $parseQty($item['qty'] ?? 0);
            //         $firstPrice = $parsePrice($item['vendors'][0]['price'] ?? 0);
            //         return $qty * $firstPrice;
            //     });
            // } else {
            //     $totalAmount = collect($validated['items'])->sum(
            //         fn($item) => $parseQty($item['qty']) * $parsePrice($item['price'] ?? 0)
            //     );
            // }
            if ($isMultivendor) {
                $totalAmount = null; // atau 0
            } else {
                $totalAmount = collect($validated['items'])->sum(
                    fn($item) => $parseQty($item['qty']) * $parsePrice($item['price'] ?? 0)
                );
            }

            $formrequest = Formrequest::create([
                'request_type_id' => $validated['request_type_id'],
                'vendor_id'       => $validated['vendor_id'] ?? null,
                'capex_type_id'   => $validated['capex_type_id'] ?? null,
                'assets'          => $validated['assets'] ?? null,
                'user_id'         => Auth::id(),
                'request_date'    => $validated['request_date'],
                'company_id'      => $validated['company_id'] ?? null,
                'addressed_to'    => $validated['addressed_to'] ?? null,
                'document_type_id' => $validated['document_type_id'] ?? null,
                'payment_type_payreq' => $validated['payment_type_payreq'] ?? null,
                'transfer'        => $companyName,
                'deadline'        => $validated['deadline'],
                'title'           => $validated['title'],
                'notes'           => $validated['notes'] ?? null,
                'total_amount'    => round($totalAmount, 2),
                'status'          => 'Draft',
            ]);

            foreach ($validated['items'] as $item) {
                $qty = $parseQty($item['qty'] ?? 0);

                if ($isMultivendor) {

                    $requestItem = Requestitem::create([
                        'request_id'    => $formrequest->id,
                        'item_name'     => $item['item_name'],
                        'specification' => $item['specification'] ?? null,
                        'qty'           => $qty,
                        'uom'           => $item['uom'] ?? null,
                        'price'         => null,
                        'total_price'   => null,
                    ]);

                    foreach ($item['vendors'] ?? [] as $vendorData) {

                        if (empty($vendorData['vendor_id'])) continue;

                        $vendorPrice = $parsePrice($vendorData['price'] ?? 0);

                        ItemVendorQuotation::create([
                            'request_item_id' => $requestItem->id,
                            'vendor_id'       => $vendorData['vendor_id'],
                            'price'           => $vendorPrice,
                            'notes'           => $vendorData['notes'] ?? null,
                            'is_selected'     => false,
                        ]);
                    }
                } else {

                    $price = $parsePrice($item['price'] ?? 0);

                    Requestitem::create([
                        'request_id'    => $formrequest->id,
                        'item_name'     => $item['item_name'],
                        'specification' => $item['specification'] ?? null,
                        'qty'           => $qty,
                        'uom'           => $item['uom'] ?? null,
                        'price'         => $price,
                        'total_price'   => round($qty * $price, 2),
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('request')
                ->with('success', 'Request created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('STORE ERROR', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('request')
                ->withInput()
                ->with('error', 'Failed: ' . $e->getMessage());
        }
    }
    public function update(Request $request, $hash)
    {
        $formrequest = null;
        foreach (Formrequest::select('id')->cursor() as $u) {
            if (substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash) {
                $formrequest = Formrequest::find($u->id);
                break;
            }
        }
        if (!$formrequest) {
            return back()->with('error', 'Data tidak ditemukan.');
        }
        $parsePrice = function ($v) {
            if (is_null($v) || $v === '') return 0.0;
            $v = trim(preg_replace('/[^\d,.]/', '', $v));
            // Format Indonesia: "4.000.000,00" → titik ribuan, koma desimal
            if (preg_match('/^\d{1,3}(\.\d{3})+(,\d{1,4})?$/', $v)) {
                $v = str_replace('.', '', $v);
                $v = str_replace(',', '.', $v);
            }
            // Format koma ribuan: "4,000,000.00" → koma ribuan, titik desimal
            elseif (preg_match('/^\d{1,3}(,\d{3})+(\.\d{1,4})?$/', $v)) {
                $v = str_replace(',', '', $v);
            }
            // Format plain: "4000000.00" atau "4000000,00" → langsung cast
            elseif (preg_match('/^\d+(,\d{1,4})?$/', $v)) {
                $v = str_replace(',', '.', $v);
            }
            // Sudah plain dengan titik desimal: "4000000.00"
            // Tidak perlu diubah, langsung cast
            return (float) $v;
        };
        $parseQty   = fn($v) => (float) str_replace(',', '.', $v ?? '0');
        // ✅ Block khusus role director
        if (auth()->user()->hasRole('director')) {
            $validated = $request->validate([
                'notes_dir'                   => ['nullable', 'string'],
                'status'                      => ['required', Rule::in([
                    'Approved Director',
                    'Rejected BD',
                    'Rejected IT',
                ])],
                'items'                       => ['nullable', 'array'],
                'items.*.selected_vendor'     => ['nullable', 'integer'],
                'items.*.vendors'             => ['nullable', 'array'],
                'items.*.vendors.*.vendor_id' => ['nullable', 'exists:vendor,id'],
                'items.*.vendors.*.price'     => ['nullable'],
            ]);
            DB::beginTransaction();
            try {
                $previousStatus = $formrequest->status;
                $formrequest->update([
                    'notes_dir' => $validated['notes_dir'] ?? $formrequest->notes_dir,
                    'status'    => $validated['status'],
                ]);
                // Approval logic
                if ($validated['status'] === 'Approved Director' && $previousStatus !== 'Approved Director') {
                    $approval = Requestapproval::firstOrCreate(['request_id' => $formrequest->id]);
                    $approval->update(['approver2' => auth()->id(), 'approver2_at' => now()]);
                }

                foreach ($validated['items'] ?? [] as $index => $item) {
                    // DEBUG SEMENTARA
                    Log::info("ITEM[$index] RAW", [
                        'selected_vendor' => $item['selected_vendor'] ?? null,
                        'vendors'         => $item['vendors'] ?? [],
                    ]);

                    $selectedVendorIndex = isset($item['selected_vendor']) ? (int) $item['selected_vendor'] : null;
                    $requestItem = $formrequest->items->get($index);
                    if (!$requestItem) continue;
                    if (!empty($item['vendors'])) {
                        foreach ($item['vendors'] as $vIdx => $vendorData) {
                            ItemVendorQuotation::where('request_item_id', $requestItem->id)
                                ->where('vendor_id', $vendorData['vendor_id'])
                                ->update([
                                    'is_selected' => ($selectedVendorIndex !== null && $vIdx == $selectedVendorIndex),
                                ]);
                        }
                    }
                    if ($selectedVendorIndex !== null && isset($item['vendors'][$selectedVendorIndex])) {
                        $rawPrice      = $item['vendors'][$selectedVendorIndex]['price'] ?? '0';
                        $selectedPrice = $parsePrice($rawPrice);
                        $qty           = $requestItem->qty;
                        // DEBUG
                        Log::info("ITEM[$index] CALC", [
                            'raw_price'     => $rawPrice,
                            'parsed_price'  => $selectedPrice,
                            'qty'           => $qty,
                            'total'         => round($qty * $selectedPrice, 2),
                        ]);
                        $requestItem->update([
                            'selected_vendor' => $selectedVendorIndex,
                            'price'           => $selectedPrice,
                            'total_price'     => round($qty * $selectedPrice, 2),
                        ]);
                    }
                }
                // Hitung ulang total_amount formrequest
                $formrequest->update([
                    'total_amount' => round($formrequest->items()->sum('total_price'), 2),
                ]);
                DB::commit();
                $this->dispatchEmails($validated['status'], $previousStatus, $formrequest);
                return redirect()->route('request')->with('success', 'Request updated successfully.');
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error('UPDATE ERROR DIRECTOR', ['message' => $e->getMessage()]);
                return back()->withInput()->with('error', 'Failed to update request: ' . $e->getMessage());
            }
        }
        $requestType = RequestType::find($request->input('request_type_id'));
        $isCAPEX = $requestType?->code === 'CAPEX';
        $isPR = $requestType?->code === 'PR';
        $isMultiVendor = $isCAPEX || $isPR;
        $validated = $request->validate([
            'request_type_id'       => ['nullable', 'exists:request_type,id'],
            'vendor_id'             => ['nullable', 'exists:vendor,id'],
            'request_date'          => ['required', 'date'],
            'deadline'              => ['required', 'date', 'after_or_equal:request_date'],
            'title'                 => ['required', 'string', 'max:255'],
            'assets' => $isCAPEX
                ? ['required', Rule::in(Formrequest::getAssetOptions())]
                : ['nullable', Rule::in(Formrequest::getAssetOptions())],
            'document_type_id' => [
                $isPR ? 'required' : 'nullable',
            ],
            'capex_type_id' => [
                $isCAPEX ? 'required' : 'nullable',
            ],
            'payment_type_payreq' => $isPR
                ? ['required', Rule::in(Formrequest::getPROptions())]
                : ['nullable', Rule::in(Formrequest::getPROptions())],
            'ca_number' => [
                Rule::requiredIf(
                    auth()->user()->hasRole('finance') && $request->isMethod('put')
                ),
                'string',
                'max:255'
            ],
            'notes'                 => ['nullable', 'string'],
            'notes_fa'              => ['nullable', 'string'],
            'notes_fir'             => ['nullable', 'string'],
            'destination'           => ['nullable', 'string', 'max:255'],
            'status'                => ['required', Rule::in([
                'Draft',
                'Submitted',
                'Approved Manager',
                'Rejected Manager',
                'Approved Finance',
                'Approved IT',
                'Approved BD',
                'Rejected Finance',
                'Rejected IT',
                'Rejected BD',
                'Approved Director',
                'Rejected Director',
                'Done'
            ])],
            'items'                     => ['required', 'array', 'min:1'],
            'items.*.item_name'         => ['required', 'string', 'max:255'],
            'items.*.specification'     => ['nullable', 'string'],
            'items.*.uom'               => ['required', Rule::in(Requestitem::getUomOptions())],
            'items.*.qty'               => ['required'],
            'items.*.price' => $isMultiVendor ? ['nullable'] : ['required'],
            // 'items.*.vendors'           => $isMultiVendor ? ['nullable', 'array'] : [],
            // 'items.*.vendors.*.vendor_id' => $isMultiVendor ? ['nullable', 'exists:vendor,id'] : [],
            // 'items.*.vendors.*.price'   => $isMultiVendor ? ['nullable'] : [],
            // 'items.*.selected_vendor' => $isMultiVendor ? ['nullable', 'integer'] : [],
            'items.*.vendors' => $isMultiVendor ? ['nullable', 'array'] : ['prohibited'],
'items.*.vendors.*.vendor_id' => $isMultiVendor ? ['nullable', 'exists:vendor,id'] : ['prohibited'],
'items.*.vendors.*.price' => $isMultiVendor ? ['nullable'] : ['prohibited'],
'items.*.selected_vendor' => $isMultiVendor ? ['nullable', 'integer'] : ['prohibited'],
            'links.*.link'           => ['nullable', 'max:255'],
        ]);
        $parsePrice = fn($v) => (float) str_replace(',', '.', str_replace('.', '', $v ?? '0'));
        $parseQty   = fn($v) => (float) str_replace(',', '.', $v ?? '0');
        // ✅ Fix 1: Cari record efisien
        $formrequest = null;
        foreach (Formrequest::select('id')->cursor() as $u) {
            if (substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash) {
                $formrequest = Formrequest::find($u->id);
                break;
            }
        }
        if (!$formrequest) {
            return back()->with('error', 'Data tidak ditemukan.');
        }
        $previousStatus = $formrequest->status;
        $totalAmount = collect($validated['items'])->sum(function ($item) use ($parseQty, $parsePrice, $isMultiVendor) {
            if ($isMultiVendor) {
                $vendors = $item['vendors'] ?? [];
                $selectedVendorIndex = isset($item['selected_vendor']) ? (int) $item['selected_vendor'] : null;
                $selectedPrice = ($selectedVendorIndex !== null && isset($vendors[$selectedVendorIndex]))
                    ? $vendors[$selectedVendorIndex]['price'] ?? '0'
                    : '0';
                return $parseQty($item['qty']) * $parsePrice($selectedPrice);
            }
            return $parseQty($item['qty']) * $parsePrice($item['price']);
        });
        DB::beginTransaction();
        try {
            $formrequest->update([
                'vendor_id'    => $validated['vendor_id'] ?? null,
                'request_date' => $validated['request_date'],
                'deadline'     => $validated['deadline'],
                'title'        => $validated['title'],
                'ca_number'    => $validated['ca_number'] ?? null,
                'notes'        => $validated['notes'] ?? null,
                'notes_fa'     => $validated['notes_fa'] ?? null,
                'notes_dir'    => $validated['notes_dir'] ?? null,
                'assets' => $isCAPEX
                    ? $validated['assets']
                    : ($validated['assets'] ?? $formrequest->assets),
                'document_type_id' => $isPR
                    ? $validated['document_type_id']
                    : ($validated['document_type_id'] ?? $formrequest->document_type_id),
                'payment_type_payreq' => $isPR
                    ? $validated['payment_type_payreq']
                    : ($validated['payment_type_payreq'] ?? $formrequest->payment_type_payreq),
                'capex_type_id' => $isCAPEX
                    ? $validated['capex_type_id']
                    : ($validated['capex_type_id'] ?? $formrequest->capex_type_id),
                'total_amount' => round($totalAmount, 2),
                'status'       => $validated['status'],
            ]);
            // Approval logic
            // $approval = Requestapproval::firstOrCreate(['request_id' => $formrequest->id]);
            // if ($validated['status'] === 'Approved Manager' && $previousStatus !== 'Approved Manager') {
            //     $approval->update(['approver1' => auth()->id(), 'approver1_at' => now()]);
            // }
            $approval = Requestapproval::firstOrCreate(['request_id' => $formrequest->id]);

if ($validated['status'] === 'Approved Manager' && $previousStatus !== 'Approved Manager') {

    if (!empty($formrequest->capex_type_id)) {
        // 🔥 CASE: CAPEX (langsung double approve)
        $approval->update([
            'approver1'         => auth()->id(),
            'approver1_at'      => now(),
            'capex_approver'    => auth()->id(),
            'capex_approver_at' => now(),
        ]);
    } else {
        // 🔥 CASE: NON CAPEX (normal)
        $approval->update([
            'approver1'    => auth()->id(),
            'approver1_at' => now(),
        ]);
    }
}
            if ($validated['status'] === 'Approved Director' && $previousStatus !== 'Approved Director') {
                $approval->update(['approver2' => auth()->id(), 'approver2_at' => now()]);
            }
            // Items & links
            $existingItemIds = Requestitem::where('request_id', $formrequest->id)->pluck('id');
            ItemVendorQuotation::whereIn('request_item_id', $existingItemIds)->delete();
            Requestitem::where('request_id', $formrequest->id)->delete();
            Requestlink::where('request_id', $formrequest->id)->delete();
            foreach ($validated['items'] as $item) {
                $qty   = $parseQty($item['qty']);
                $price = $isMultiVendor ? 0 : $parsePrice($item['price']);
                $newItem = Requestitem::create([
                    'request_id'    => $formrequest->id,
                    'item_name'     => $item['item_name'],
                    'specification' => $item['specification'] ?? null,
                    'qty'           => $qty,
                    'uom'           => $item['uom'],
                    'price'         => $price,
                    'total_price'   => $isMultiVendor ? 0 : round($qty * $price, 2),
                ]);
                // if ($isCAPEX || $isPAYREQ && !empty($item['vendors'])) {
                if (($isMultiVendor) && !empty($item['vendors'])) {
                    $selectedVendorIndex = isset($item['selected_vendor']) ? (int) $item['selected_vendor'] : null;
                    foreach ($item['vendors'] as $vIdx => $vendorData) {
                        if (empty($vendorData['vendor_id'])) continue;
                        ItemVendorQuotation::create([
                            'request_item_id' => $newItem->id,
                            'vendor_id'       => $vendorData['vendor_id'],
                            'price'           => $parsePrice($vendorData['price'] ?? '0'),
                            'is_selected'     => ($selectedVendorIndex !== null && $vIdx == $selectedVendorIndex),
                        ]);
                    }
                    if ($selectedVendorIndex !== null && isset($item['vendors'][$selectedVendorIndex])) {
                        $selectedPrice    = $parsePrice($item['vendors'][$selectedVendorIndex]['price'] ?? '0');
                        $selectedVendorId = $item['vendors'][$selectedVendorIndex]['vendor_id'] ?? null;
                        $newItem->update([
                            'price'       => $selectedPrice,
                            'total_price' => round($qty * $selectedPrice, 2),
                        ]);
                        if ($selectedVendorId) {
                            $formrequest->update(['vendor_id' => $selectedVendorId]);
                        }
                    }
                }
            }
            if (!empty($validated['links'])) {
                foreach ($validated['links'] as $link) {
                    if (empty($link['link'])) continue;
                    $formrequest->links()->create(['link' => $link['link']]);
                }
            }
            DB::commit();
            // ✅ Fix 3: Kirim email SETELAH commit, gunakan queue (non-blocking)
            $this->dispatchEmails($validated['status'], $previousStatus, $formrequest);
            return redirect()->route('request')->with('success', 'Request updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('UPDATE ERROR', ['message' => $e->getMessage()]);
            return back()->withInput()->with('error', 'failed to update request: ' . $e->getMessage());
        }
    }
    // ✅ Pisahkan email logic ke method sendiri, pakai queue
    private function dispatchEmails(string $status, string $previousStatus, $formrequest): void
    {
        try {
            if ($status === 'Submitted' && $previousStatus !== 'Submitted') {
                $employee = auth()->user()->employee;
                if ($employee) {
                    $baseUrl = config('services.manager_api_local.url');
                    $managerResponse = Http::timeout(5)->get("{$baseUrl}/api/manager/{$employee->id}");
                    if ($managerResponse->successful()) {
                        $managerEmail = data_get($managerResponse->json(), 'manager.company_email');
                        if ($managerEmail) {
                            Mail::to($managerEmail)->queue(new RequestMail($formrequest));
                        }
                    }
                }
            }
            // if ($status === 'Approved Manager' && $previousStatus !== 'Approved Manager') {
            if (
    in_array($status, ['Approved Manager', 'Approved IT', 'Approved BD']) &&
    $previousStatus !== $status
) {
                $employees = Employee::whereHas('position', function ($query) {
                    $query->whereIn('id', [
                        '01973a06-74e2-706d-97fe-097c12788c59',
                        '01992267-3466-724e-93b3-46350f7e9094',
                        '01973e38-9ae7-7343-9058-1094c2a8606b',
                    ]);
                })->get();
                foreach ($employees as $employee) {
                    if ($employee->company_email) {
                        Mail::to($employee->company_email)->queue(new RequestMail($formrequest));
                    }
                }
            }
        } catch (\Throwable $mailException) {
            Log::error('MAIL ERROR', ['message' => $mailException->getMessage()]);
        }
    }
}
