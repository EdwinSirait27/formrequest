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
use Illuminate\Validation\Rule;
use App\Models\Vendor;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
class RequestControllerAdmin extends Controller
{
     public function formpage()
    {
        $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
        $requesttypes = Requesttype::pluck('request_type_name', 'id');
        $companies = Company::pluck('name', 'id');
        $statuses = [
            'Approved Manager' => 'Approved Manager',
            'Rejected Manager' => 'Rejected Manager',
            'Approved Finance' => 'Approved Finance',
            'Rejected Finance' => 'Rejected Finance',
            'Rejected Director' => 'Rejected Director',
            'Approved Director' => 'Approved Director',
            'Done' => 'Done',
        ];
        return view('pages.request.request', compact('vendors', 'requesttypes', 'statuses', 'companies'));
    }
    public function getRequestsadmin(Request $request)
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
                $idHashed = substr(hash('sha256', $row->id . config('app.key')), 0, 8);
                $id = $row->id;
                $editBtn = '
                <a href="' . route('admin.editrequest', $idHashed) . '"
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
                <a href="' . route('admin.showrequest', $idHashed) . '"
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
        <a href="' . route('admin.request.pdf', $id) . '"
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
        $companies = Company::on('hrx')->pluck('name', 'id');
        // $companyId = Auth::user()->employee->company_id;
        $companyId = $request->company_id;
        $userCompany = Company::on('hrx')
            ->where('id', $companyId)
            ->value('name');
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

        return view('pages.request.editrequest', compact('request', 'companies', 'vendors', 'requesttypes', 'statuses', 'uoms', 'companyId', 'userCompany'));
    }
    public function show($hash)
    {
        $request = Formrequest::with('items')->get()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
        abort_if(!$request, 404);
        $vendors = Vendor::where('status', 'Active')->pluck('vendor_name', 'id');
        $requesttypes = Requesttype::pluck('request_type_name', 'id');
        $companies = Company::pluck('name', 'id');

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
        return view('pages.request.showrequest', compact('companies', 'request', 'vendors', 'requesttypes', 'statuses', 'uoms'));
    }
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
        ])->findOrFail($id);
        $employee  = $request->user?->employee;
        $companyId = $employee?->company?->id;
        $requestDate = $request->request_date
            ->timezone('Asia/Makassar')
            ->translatedFormat('d F Y');
        $Deadline = $request->deadline
            ->timezone('Asia/Makassar')
            ->translatedFormat('d F Y');
        $signatureBase64 = null;
        if ($employee && $employee->signature) {
            $path = public_path('storage/' . $employee->signature);
            if (file_exists($path)) {
                $image = file_get_contents($path);
                $mime  = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
                $signatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
            }
        }
        $logoBase64 = null;
        if ($companyId) {
            try {
                $response = Http::withoutVerifying()
                    // ->get("https://hrx.asianbay.co.id/api/company/" . $companyId);
                    ->get(env('HRX_API_URL') . "/api/company/" . $companyId);

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
        $managerName            = null;
        $positionName           = null;
        $managerSignatureBase64 = null;
        $showManagerSignature = in_array($request->status, ['Approved Manager', 'Approved Director']);

        if ($employee && $showManagerSignature) {
            try {
                $response = Http::withoutVerifying()
                    ->get(env('HRX_API_URL') . "/api/manager/{$employee->id}");


                if ($response->successful()) {
                    $managerData  = $response->json('manager');
                    $managerName  = $managerData['employee_name'] ?? null;
                    $positionName = $managerData['position'] ?? null;
                    $signatureUrl = $managerData['signature'] ?? null;
                    if ($signatureUrl) {
                        $relativePath = ltrim(parse_url($signatureUrl, PHP_URL_PATH), '/');
                        $relativePath = str_replace('storage/', '', $relativePath);
                        $localPath    = public_path('storage/' . $relativePath);

                        if (file_exists($localPath)) {
                            $image = file_get_contents($localPath);
                            if ($image !== false) {
                                $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
                                $managerSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Manager fetch error: ' . $e->getMessage());
            }
        }
        // ✅ Head of FAT
        $headfatName            = null;
        $positionheadfatName    = null;
        $headfatSignatureBase64 = null;
        $showheadfatSignature   = in_array($request->status, ['Approved Manager', 'Approved Director']);

        if ($showheadfatSignature) {
            $headfat = Employee::whereHas('position', function ($q) {
                $q->where('name', 'Head of FAT');
            })->with('position')->first();

            if ($headfat) {
                $headfatName         = $headfat->employee_name;
                $positionheadfatName = $headfat->position->name ?? null;

                if ($headfat->signature) {
                    $path = public_path('storage/' . $headfat->signature);
                    if (file_exists($path)) {
                        $image = file_get_contents($path);
                        $mime  = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
                        $headfatSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
                    }
                }
            }
        }

        // ✅ Assistant FAT Manager
        $astfatName            = null;
        $positionastfatName    = null;
        $astfatSignatureBase64 = null;
        $showastfatSignature   = in_array($request->status, ['Approved Manager', 'Approved Director']);

        if ($showastfatSignature) {
            $astfat = Employee::whereHas('position', function ($q) {
                $q->where('name', 'Assistant FAT Manager');
            })->with('position')->first();

            if ($astfat) {
                $astfatName         = $astfat->employee_name;
                $positionastfatName = $astfat->position->name ?? null;

                if ($astfat->signature) {
                    $path = public_path('storage/' . $astfat->signature);
                    if (file_exists($path)) {
                        $image = file_get_contents($path);
                        $mime  = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $image);
                        $astfatSignatureBase64 = 'data:' . $mime . ';base64,' . base64_encode($image);
                    }
                }
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
            'headfatName'           => $headfatName,
            'astfatName'           => $astfatName,
            'positionheadfatName'           => $positionheadfatName,
            'headfatSignatureBase64'           => $headfatSignatureBase64,
            'positionastfatName'           => $positionastfatName,
            'astfatSignatureBase64'           => $astfatSignatureBase64,

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
        $companies = Company::on('hrx')->pluck('name', 'id');
        $companyId = Auth::user()->employee->company_id;
        $userCompany = Company::on('hrx')
            ->where('id', $companyId)
            ->value('name');
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
        return view('pages.request.createrequest', compact('userCompany', 'companies', 'companyId', 'uoms', 'vendors', 'requesttypes', 'statuses'));
    }
    public function store(Request $request)
    {
        Log::info('STORE REQUEST START', [
            'payload' => $request->all(),
            'user_id' => Auth::id()
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
            'request_type_id' => ['required', 'exists:request_type,id'],
            'company_id'      => ['nullable', 'exists:hrx.company_tables,id'],
            'vendor_id'       => ['nullable', 'exists:vendor,id'],
            'transfer'        => ['nullable', 'string'],
            'request_date'    => ['required', 'date'],
            'deadline'        => ['required', 'date', 'after_or_equal:request_date'],
            'title'           => ['required', 'string', 'max:255'],
            'notes'           => ['nullable', 'string'],
            'addressed_to'    => ['nullable'],
            'destination'     => ['nullable', 'string', 'max:255'],
            'items'           => ['required', 'array', 'min:1'],
            'items.*.item_name' => ['required', 'string', 'max:255'],
            'items.*.specification' => ['nullable', 'string'],
            'items.*.qty'     => ['required', 'numeric', 'min:0'],
            'items.*.uom'     => ['required', Rule::in(Requestitem::getUomOptions())],
            'items.*.price'   => ['required', 'numeric', 'min:0'],
        ]);
        Log::info('VALIDATION PASSED', [
            'validated' => $validated
        ]);
        DB::beginTransaction();
        try {
            $companyName = null;
            if (!empty($validated['company_id'])) {
                $companyName = \App\Models\Company::on('hrx')
                    ->where('id', $validated['company_id'])
                    ->value('name');
            }
            $totalAmount = collect($validated['items'])->sum(function ($item) {
                return $item['qty'] * $item['price'];
            });
            Log::info('TOTAL AMOUNT', [
                'total' => $totalAmount
            ]);
            $formrequest = Formrequest::create([
                'request_type_id' => $validated['request_type_id'],
                'vendor_id'       => $validated['vendor_id'] ?? null,
                'user_id'         => Auth::id(),
                'request_date'    => $validated['request_date'],
                'company_id'      => $validated['company_id'],
                'addressed_to'      => $validated['addressed_to'],
                'transfer'        => $companyName,
                'deadline'        => $validated['deadline'],
                'title'           => $validated['title'],
                'notes'           => $validated['notes'] ?? null,
                'total_amount'    => round($totalAmount, 2),
                'status'          => 'Draft',
            ]);
            Log::info('FORMREQUEST CREATED', [
                'id' => $formrequest->id
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
            Log::info('ITEMS CREATED');
            DB::commit();
            Log::info('STORE SUCCESS');
            return redirect()
                ->route('admin.request')
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
        // $formrequest = Formrequest::findOrFail($id);
        $formrequest = Formrequest::with('items')->get()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });

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
            'company_id'            => ['nullable', 'exists:hrx.company_tables,id'],
            'vendor_id'             => ['nullable', 'exists:vendor,id'],
            'transfer'              => ['nullable', 'string'],
            'request_date'          => ['required', 'date'],
            'deadline'              => ['required', 'date', 'after_or_equal:request_date'],
            'title'                 => ['required', 'string', 'max:255'],
            'notes'                 => ['nullable', 'string'],
            'addressed_to'          => ['nullable'],
            'destination'           => ['nullable', 'string', 'max:255'],
            'items'                 => ['required', 'array', 'min:1'],
            'items.*.item_name'     => ['required', 'string', 'max:255'],
            'items.*.specification' => ['nullable', 'string'],
            'items.*.qty'           => ['required', 'numeric', 'min:0'],
            'items.*.uom'           => ['required', Rule::in(Requestitem::getUomOptions())],
            'items.*.price'         => ['required', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();
        try {
            $companyName = null;
            if (!empty($validated['company_id'])) {
                $companyName = \App\Models\Company::on('hrx')
                    ->where('id', $validated['company_id'])
                    ->value('name');
            }

            $totalAmount = collect($validated['items'])->sum(function ($item) {
                return $item['qty'] * $item['price'];
            });

            $formrequest->update([
                'request_type_id' => $validated['request_type_id'],
                'vendor_id'       => $validated['vendor_id'] ?? null,
                'request_date'    => $validated['request_date'],
                'company_id'      => $validated['company_id'],
                'addressed_to'    => $validated['addressed_to'],
                'transfer'        => $companyName,
                'deadline'        => $validated['deadline'],
                'title'           => $validated['title'],
                'notes'           => $validated['notes'] ?? null,
                'total_amount'    => round($totalAmount, 2),
            ]);
            // Hapus items lama lalu insert ulang
            $formrequest->items()->delete();
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
                ->route('admin.request')
                ->with('success', 'Request berhasil diupdate.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('UPDATE ERROR', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString()
            ]);
            return back()
                ->withInput()
                ->with('error', 'Gagal mengupdate request: ' . $e->getMessage());
        }
    }
}
