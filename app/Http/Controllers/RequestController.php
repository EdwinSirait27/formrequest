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
        } elseif ($user->hasRole('manager')) {
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
        } 
        // elseif ($user->hasRole('director')) {
        //     $query->where('status', ['Approved Manager', 'Approved Director', 'Rejected Director']);
        elseif ($user->hasRole('director')) {
    $query->whereIn('status', [
        'Approved Manager',
        'Approved Director',
        'Rejected Director'
    ]);

        } elseif ($user->hasRole('user')) {
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

                $isLocked =
                    ($row->status === 'Submitted'        && $user->hasRole('user'))    ||
                    ($row->status === 'Approved Manager' && $user->hasRole('manager')) ||
                    ($row->status === 'Approved Finance' && $user->hasRole('director'));
                $idHashed = substr(hash('sha256', $row->id . config('app.key')), 0, 8);
                $id = $row->id;

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
                //         $pdfBtn = '
                // <a href="' . route('request.pdf', $id) . '"
                //    class="inline-flex items-center justify-center p-2
                //           text-slate-500 hover:text-red-600
                //           hover:bg-red-50 rounded-full transition"
                //    title="Download PDF: ' . e(optional($row->requesttype)->request_type_name) . ' - ' . e($row->title) . '"
                //    target="_blank">
                //     <svg xmlns="http://www.w3.org/2000/svg"
                //          class="w-5 h-5"
                //          fill="none"
                //          viewBox="0 0 24 24"
                //          stroke="currentColor"
                //          stroke-width="1.8">
                //         <path stroke-linecap="round" stroke-linejoin="round"
                //               d="M12 16v-8m0 8l-3-3m3 3l3-3M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2" />
                //     </svg>
                // </a>';
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
        return view('pages.request.editrequest', compact(
            'request',
            'companies',
            'vendors',
            'requesttypes',
            'statuses',
            'uoms',
            'userCompanyId',
            'userCompanyName'
        ));
    }
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
    private function resolveManager(Employee $employee): ?Employee
    {
        $employee->loadMissing('structuresnew.parent');

        if (!$employee->structuresnew) return null;

        $current          = $employee->structuresnew->parent;
        $managerStructure = null;

        while ($current) {
            if ($current->is_manager) {
                $managerStructure = $current;
                break;
            }
            $current->load('parent');
            $current = $current->parent;
        }

        if (!$managerStructure) return null;

        return Employee::with([
            'structuresnew.submissionposition.positionRelation',
        ])->where('structure_id', $managerStructure->id)->first();
    }

    public function pdfview($id)
    {
        set_time_limit(120);
        ini_set('memory_limit', '512M');

        $request = Formrequest::with([
            'vendor',
            'requesttype',
            'items',
            'company:id',
            'user.employee',
            'user.employee.company',
            'user.employee.position:id,name',
            'user.employee.department:id,department_name',
            'approval.approver2User.employee',
            'approval.approver2User.employee.position:id,name',
        ])->findOrFail($id);

        $employee  = $request->user?->employee;
        $companyId = $request->company?->id;

        $requestDate = $request->request_date
            ->timezone('Asia/Makassar')
            ->translatedFormat('d F Y');

        $Deadline = $request->deadline
            ->timezone('Asia/Makassar')
            ->translatedFormat('d F Y');

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

        // HTTP — hanya untuk logo
        $responses = Http::pool(function ($pool) use ($companyId) {
            if (!$companyId) return [];

            return [
                $pool->as('logo')
                    ->withoutVerifying()
                    ->timeout(8)
                    ->get("https://hrx.asianbay.co.id/api/company/{$companyId}"),
            ];
        });

        $logoBase64   = null;
        $logoResponse = $responses['logo'] ?? null;

        if ($logoResponse instanceof \Illuminate\Http\Client\Response && $logoResponse->successful()) {
            $logoUrl = $logoResponse->json('logo_url');

            if ($logoUrl) {
                try {
                    $imgResponse = Http::withoutVerifying()->timeout(5)->get($logoUrl);

                    if ($imgResponse->successful()) {
                        $body       = $imgResponse->body();
                        $finfo      = finfo_open(FILEINFO_MIME_TYPE);
                        $mime       = finfo_buffer($finfo, $body);
                        finfo_close($finfo);
                        $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($body);
                    }
                } catch (\Exception $e) {
                    Log::error('Logo fetch error: ' . $e->getMessage());
                }
            }
        }

        // Manager — dari DB langsung, tanpa HTTP
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

                    if (!$managerSignatureBase64) {
                        Log::warning('Manager signature tidak ditemukan di disk', [
                            'path' => public_path('storage/' . $manager->signature),
                        ]);
                    }
                }
            }
        }

        // Signature employee
        $signatureBase64 = $employee?->signature
            ? $toBase64(public_path('storage/' . $employee->signature))
            : null;

        // Approver2
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
            'showSignature'          => $showManagerSignature,
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
                'Draft',
                'Submitted',
                'Approved Manager',
                'Rejected Manager',
                'Approved Finance',
                'Rejected Finance',
                'Approved Director',
                'Rejected Director',
                'Done'
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
                'ca_number'           => $validated['ca_number'] ?? null,
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
//         'user.employee.position',
//         'approval.approver2User.employee',
//         'approval.approver2User.employee.position',
//     ])->findOrFail($id);

//     $employee  = $request->user?->employee;
//     $companyId = $request->company?->id;

//     $requestDate = $request->request_date
//         ->timezone('Asia/Makassar')
//         ->translatedFormat('d F Y');
//     $Deadline = $request->deadline
//         ->timezone('Asia/Makassar')
//         ->translatedFormat('d F Y');

//     $toBase64 = function (string $localPath): ?string {
//         if (!file_exists($localPath)) return null;
//         $image = file_get_contents($localPath);
//         if ($image === false) return null;
//         $finfo = finfo_open(FILEINFO_MIME_TYPE);
//         $mime  = finfo_buffer($finfo, $image);
//         finfo_close($finfo);
//         return 'data:' . $mime . ';base64,' . base64_encode($image);
//     };

//     $signatureBase64 = $employee?->signature
//         ? $toBase64(public_path('storage/' . $employee->signature))
//         : null;

//     $showManagerSignature = in_array($request->status, ['Approved Manager', 'Approved Director']);
//     $showSignature        = $showManagerSignature;

//     $logoBase64             = null;
//     $managerName            = null;
//     $positionName           = null;
//     $managerSignatureBase64 = null;

//     $promises = [];

//     if ($companyId) {
//         $promises['logo'] = Http::withoutVerifying()
//             ->async()
//             ->get("https://hrx.asianbay.co.id/api/company/{$companyId}");
//     }

//     $baseUrl = config('services.manager_api.url');

// if ($employee && $showManagerSignature) {
//     $promises['manager'] = Http::async()
//         ->retry(3, 1000)
//         ->timeout(5)
//         ->get("{$baseUrl}/api/manager/{$employee->id}");
// }

//     // Tunggu semua sekaligus
//     $responses = [];
//     foreach ($promises as $key => $promise) {
//         try {
//             $responses[$key] = $promise->wait();
//         } catch (\Exception $e) {
//     Log::error(ucfirst($key) . ' fetch error: ' . $e->getMessage());

//     $responses[$key] = null; // 🔥 WAJIB
// }
//     }

//     $logoResponse = $responses['logo'] ?? null;

// if ($logoResponse instanceof Response && $logoResponse->successful()) {
//         try {
//             $logoUrl = $responses['logo']->json('logo_url');
//             if ($logoUrl) {
//                 $image = @file_get_contents($logoUrl);
//                 if ($image !== false) {
//                     $finfo      = finfo_open(FILEINFO_MIME_TYPE);
//                     $mime       = finfo_buffer($finfo, $image);
//                     finfo_close($finfo);
//                     $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
//                 }
//             }
//         } catch (\Exception $e) {
//             Log::error('Logo parse error: ' . $e->getMessage());
//         }
//     }

   
//     $managerResponse = $responses['manager'] ?? null;

// if ($managerResponse instanceof Response && $managerResponse->successful()) {

//     $managerData  = $managerResponse->json('manager');
//     $managerName  = $managerData['employee_name'] ?? null;
//     $positionName = $managerData['position'] ?? null;
//     $signatureUrl = $managerData['signature'] ?? null;

//     if ($signatureUrl) {
//         $relativePath = ltrim(parse_url($signatureUrl, PHP_URL_PATH), '/');
//         $relativePath = str_replace('storage/', '', $relativePath);

//         $managerSignatureBase64 = $toBase64(public_path('storage/' . $relativePath));
//     }

// } else {
//     Log::warning('Manager API tidak valid / gagal');
// }

   
//     $approver2 = $request->approval?->approver2User?->employee;

// $signatories = [
//     'approver2' => [
//         'name'      => $approver2?->employee_name,
//         'position'  => $approver2?->position?->name,
//         'signature' => $approver2?->signature
//             ? $toBase64(public_path('storage/' . $approver2->signature))
//             : null,
//     ]
// ];

//     // ── 7. Render PDF — SATU KALI, hapus pass 1 ──
//     $viewData = [
//         'request'                => $request,
//         'logoBase64'             => $logoBase64,
//         'signatureBase64'        => $signatureBase64,
//         'managerSignatureBase64' => $managerSignatureBase64,
//         'managerName'            => $managerName,
//         'positionName'           => $positionName,
//         'signatories'            => $signatories,
//         'total'                  => $request->items->sum('total_price'),
//         'Deadline'               => $Deadline,
//         'requestDate'            => $requestDate,
//         'itemCount'              => $request->items->count(),
//       ];

//     return Pdf::loadView('pages.request.pdf', $viewData)
//         ->setPaper('A4')
//         ->setOptions([
//             'isRemoteEnabled'      => true,
//             'isHtml5ParserEnabled' => true,
//             'isPhpEnabled'         => true,
//         ])
//         ->download('request-' . $request->document_number . '.pdf');
// }
// public function pdfview($id)
// {
//     set_time_limit(120);
//     ini_set('memory_limit', '512M');

//     // ── 1. Query — hanya relasi yang benar-benar dipakai di view ──────────────
//     $request = Formrequest::with([
//         'vendor',
//         'requesttype',
//         'items',
//         'company:id',                                   // hanya id saja, cukup
//         'user.employee',                      // hindari load position jika tidak dipakai
//         'user.employee.company',
//         'user.employee.position:id,name',
//         'user.employee.department:id,department_name',
//         'approval.approver2User.employee',
//         'approval.approver2User.employee.position:id,name',
//     ])->findOrFail($id);

//     $employee  = $request->user?->employee;
//     $companyId = $request->company?->id;

//     $requestDate = $request->request_date
//         ->timezone('Asia/Makassar')
//         ->translatedFormat('d F Y');
//     $Deadline = $request->deadline
//         ->timezone('Asia/Makassar')
//         ->translatedFormat('d F Y');

//     // ── 2. toBase64 dengan memoize — file yang sama tidak dibaca dua kali ─────
//     $cache = [];
//     $toBase64 = static function (string $localPath) use (&$cache): ?string {
//         if (isset($cache[$localPath])) return $cache[$localPath];
//         if (!is_file($localPath)) return $cache[$localPath] = null;

//         $image = @file_get_contents($localPath);
//         if ($image === false) return $cache[$localPath] = null;

//         $finfo  = finfo_open(FILEINFO_MIME_TYPE);
//         $mime   = finfo_buffer($finfo, $image);
//         finfo_close($finfo);

//         return $cache[$localPath] = 'data:' . $mime . ';base64,' . base64_encode($image);
//     };

//     $showManagerSignature = in_array($request->status, ['Approved Manager', 'Approved Director']);

//     // ── 3. HTTP parallel via Http::pool() — satu round-trip, bukan dua ───────
//     $baseUrl     = config('services.manager_api.url');
//     $logoBase64  = null;
//     $managerData = null;

//     $responses = Http::pool(function ($pool) use ($companyId, $employee, $showManagerSignature, $baseUrl) {
//         $calls = [];

//         if ($companyId) {
//             $calls['logo'] = $pool->as('logo')
//                 ->withoutVerifying()
//                 ->timeout(8)
//                 ->get("https://hrx.asianbay.co.id/api/company/{$companyId}");
//         }

//         if ($employee && $showManagerSignature) {
//             $calls['manager'] = $pool->as('manager')
//                 ->retry(2, 500)          // 2 retry cukup, interval lebih pendek
//                 ->timeout(5)
//                 ->get("{$baseUrl}/api/manager/{$employee->id}");
//         }

//         return $calls;
//     });

//     // ── 4. Proses respons logo — pakai Http::get() dalam pool ─────────────────
//     $logoResponse = $responses['logo'] ?? null;

//     if ($logoResponse instanceof \Illuminate\Http\Client\Response && $logoResponse->successful()) {
//         $logoUrl = $logoResponse->json('logo_url');

//         if ($logoUrl) {
//             // Ambil binary logo via Http (bukan file_get_contents) agar bisa timeout
//             try {
//                 $imgResponse = Http::withoutVerifying()->timeout(5)->get($logoUrl);
//                 if ($imgResponse->successful()) {
//                     $body       = $imgResponse->body();
//                     $finfo      = finfo_open(FILEINFO_MIME_TYPE);
//                     $mime       = finfo_buffer($finfo, $body);
//                     finfo_close($finfo);
//                     $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($body);
//                 }
//             } catch (\Exception $e) {
//                 Log::error('Logo fetch error: ' . $e->getMessage());
//             }
//         }
//     }

//     // ── 5. Proses respons manager ─────────────────────────────────────────────
//     $managerName            = null;
//     $positionName           = null;
//     $managerSignatureBase64 = null;

//     // $managerResponse = $responses['manager'] ?? null;
// // ── DEBUG SEMENTARA — hapus setelah ketemu masalahnya ──
// $managerResponse = $responses['manager'] ?? null;

// if ($managerResponse instanceof \Illuminate\Http\Client\Response && $managerResponse->successful()) {
//     $managerData  = $managerResponse->json('manager');
//     $managerName  = $managerData['employee_name'] ?? null;
//     $positionName = $managerData['position'] ?? null;
//     $signatureUrl = $managerData['signature'] ?? null;

//     if ($signatureUrl) {
//         try {
//             $imgResponse = Http::withoutVerifying()->timeout(5)->get($signatureUrl);

//             if ($imgResponse->successful()) {
//                 $body   = $imgResponse->body();
//                 $finfo  = finfo_open(FILEINFO_MIME_TYPE);
//                 $mime   = finfo_buffer($finfo, $body);
//                 finfo_close($finfo);
//                 $managerSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($body);
//             } else {
//                 Log::warning('Manager signature HTTP gagal', [
//                     'url'    => $signatureUrl,
//                     'status' => $imgResponse->status(),
//                 ]);
//             }
//         } catch (\Exception $e) {
//             Log::error('Manager signature fetch error: ' . $e->getMessage());
//         }
//     }
// } else {
//     Log::warning('Manager API tidak valid / gagal');
// }

//     // ── 6. Signature employee (memoized, tidak dibaca ulang) ──────────────────
//     $signatureBase64 = $employee?->signature
//         ? $toBase64(public_path('storage/' . $employee->signature))
//         : null;

//     $showSignature = $showManagerSignature;

//     // ── 7. Approver2 ──────────────────────────────────────────────────────────
//     $approver2 = $request->approval?->approver2User?->employee;

//     $signatories = [
//         'approver2' => [
//             'name'      => $approver2?->employee_name,
//             'position'  => $approver2?->position?->name,
//             'signature' => $approver2?->signature
//                 ? $toBase64(public_path('storage/' . $approver2->signature))
//                 : null,
//         ],
//     ];

//     // ── 8. Render PDF — opsi minimal, isPhpEnabled dimatikan ─────────────────
//     $viewData = [
//         'request'                => $request,
//         'logoBase64'             => $logoBase64,
//         'signatureBase64'        => $signatureBase64,
//         'managerSignatureBase64' => $managerSignatureBase64,
//         'managerName'            => $managerName,
//         'positionName'           => $positionName,
//         'signatories'            => $signatories,
//         'total'                  => $request->items->sum('total_price'),
//         'Deadline'               => $Deadline,
//         'requestDate'            => $requestDate,
//         'itemCount'              => $request->items->count(),
//         'showSignature'          => $showSignature,      // tambahkan ini agar view tidak perlu hitung ulang
//     ];

//     return Pdf::loadView('pages.request.pdf', $viewData)
//         ->setPaper('A4')
//         ->setOptions([
//             'isRemoteEnabled'      => false,    // matikan — semua gambar sudah base64
//             'isHtml5ParserEnabled' => true,
//             'isPhpEnabled'         => false,    // tidak perlu PHP di blade PDF
//             'defaultFont'          => 'sans-serif',
//         ])
//         ->download('request-' . $request->document_number . '.pdf');
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
 
// public function pdfview($id)
// {
//     set_time_limit(120);
//     ini_set('memory_limit', '512M');

//     $request = Formrequest::with([
//         'vendor',
//         'requesttype',
//         'items',
//         'company:id',
//         'user.employee',
//         'user.employee.company',
//         'user.employee.position:id,name',
//         'user.employee.department:id,department_name',
//         'approval.approver2User.employee',
//         'approval.approver2User.employee.position:id,name',
//     ])->findOrFail($id);

//     $employee  = $request->user?->employee;
//     $companyId = $request->company?->id;

//     $requestDate = $request->request_date
//         ->timezone('Asia/Makassar')
//         ->translatedFormat('d F Y');

//     $Deadline = $request->deadline
//         ->timezone('Asia/Makassar')
//         ->translatedFormat('d F Y');

//     // toBase64 dengan memoize — file yang sama tidak dibaca dua kali
//     $cache    = [];
//     $toBase64 = static function (string $localPath) use (&$cache): ?string {
//         if (isset($cache[$localPath])) return $cache[$localPath];
//         if (!is_file($localPath))      return $cache[$localPath] = null;

//         $image = @file_get_contents($localPath);
//         if ($image === false)          return $cache[$localPath] = null;

//         $finfo = finfo_open(FILEINFO_MIME_TYPE);
//         $mime  = finfo_buffer($finfo, $image);
//         finfo_close($finfo);

//         return $cache[$localPath] = 'data:' . $mime . ';base64,' . base64_encode($image);
//     };

//     $showManagerSignature = in_array($request->status, ['Approved Manager', 'Approved Director']);

//     // HTTP parallel — logo & manager dalam satu round-trip
//     $baseUrl = config('services.manager_api.url');

//     $responses = Http::pool(function ($pool) use ($companyId, $employee, $showManagerSignature, $baseUrl) {
//         $calls = [];

//         if ($companyId) {
//             $calls['logo'] = $pool->as('logo')
//                 ->withoutVerifying()
//                 ->timeout(8)
//                 ->get("https://hrx.asianbay.co.id/api/company/{$companyId}");
//         }

//         if ($employee && $showManagerSignature) {
//             $calls['manager'] = $pool->as('manager')
//                 ->retry(2, 500)
//                 ->timeout(5)
//                 ->get("{$baseUrl}/api/manager/{$employee->id}");
//         }

//         return $calls;
//     });

//     // Proses logo
//     $logoBase64   = null;
//     $logoResponse = $responses['logo'] ?? null;

//     if ($logoResponse instanceof \Illuminate\Http\Client\Response && $logoResponse->successful()) {
//         $logoUrl = $logoResponse->json('logo_url');

//         if ($logoUrl) {
//             try {
//                 $imgResponse = Http::withoutVerifying()->timeout(5)->get($logoUrl);

//                 if ($imgResponse->successful()) {
//                     $body       = $imgResponse->body();
//                     $finfo      = finfo_open(FILEINFO_MIME_TYPE);
//                     $mime       = finfo_buffer($finfo, $body);
//                     finfo_close($finfo);
//                     $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($body);
//                 }
//             } catch (\Exception $e) {
//                 Log::error('Logo fetch error: ' . $e->getMessage());
//             }
//         }
//     }

//     // ── 5. Manager — langsung dari DB, tanpa HTTP ─────────────────────────────
// $managerName            = null;
// $positionName           = null;
// $managerSignatureBase64 = null;

// if ($employee && $showManagerSignature) {
//     $manager = $this->resolveManager($employee);

//     if ($manager) {
//         $managerName  = $manager->employee_name;
//         $positionName = optional(
//                             optional($manager->structuresnew?->submissionposition)
//                             ->positionRelation
//                         )->name ?? null;

//         if ($manager->signature) {
//             $managerSignatureBase64 = $toBase64(
//                 public_path('storage/' . $manager->signature)
//             );

//             if (!$managerSignatureBase64) {
//                 Log::warning('Manager signature tidak ditemukan di disk', [
//                     'signature' => $manager->signature,
//                     'path'      => public_path('storage/' . $manager->signature),
//                 ]);
//             }
//         }
//     }
// }

//     // Signature employee (local disk, memoized)
//     $signatureBase64 = $employee?->signature
//         ? $toBase64(public_path('storage/' . $employee->signature))
//         : null;

//     // Approver2
//     $approver2   = $request->approval?->approver2User?->employee;
//     $signatories = [
//         'approver2' => [
//             'name'      => $approver2?->employee_name,
//             'position'  => $approver2?->position?->name,
//             'signature' => $approver2?->signature
//                 ? $toBase64(public_path('storage/' . $approver2->signature))
//                 : null,
//         ],
//     ];

//     $viewData = [
//         'request'                => $request,
//         'logoBase64'             => $logoBase64,
//         'signatureBase64'        => $signatureBase64,
//         'managerSignatureBase64' => $managerSignatureBase64,
//         'managerName'            => $managerName,
//         'positionName'           => $positionName,
//         'signatories'            => $signatories,
//         'total'                  => $request->items->sum('total_price'),
//         'Deadline'               => $Deadline,
//         'requestDate'            => $requestDate,
//         'itemCount'              => $request->items->count(),
//         'showSignature'          => $showManagerSignature,
//     ];

//     return Pdf::loadView('pages.request.pdf', $viewData)
//         ->setPaper('A4')
//         ->setOptions([
//             'isRemoteEnabled'      => false,
//             'isHtml5ParserEnabled' => true,
//             'isPhpEnabled'         => false,
//             'defaultFont'          => 'sans-serif',
//         ])
//         ->download('request-' . $request->document_number . '.pdf');
// }