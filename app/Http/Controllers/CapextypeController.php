<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Capextype;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
class CapextypeController extends Controller
{
 public function index()
    {
        return view('pages.capextype.capextype');
    }
    public function getCapextypes(Request $request)
    {
        $query = Capextype::with('user.employee')->select([
            'id',
            'code',
            'user_id',
            ]);
        return DataTables::eloquent($query)
            ->addIndexColumn()
             ->addColumn('employee_name', function ($row) {
                return optional($row->user->employee ?? null)->employee_name ?? '-';
            })
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('user.employee', fn($q) => $q->where('employee_name', 'like', "%{$keyword}%"));
            })
            ->addColumn('action', function ($capextype) {
                $idHashed = substr(hash('sha256', $capextype->id . env('APP_KEY')), 0, 8);
                {
                    $editBtn = '
            <a href="' . route('editcapextype', $idHashed) . '"
               class="inline-flex items-center justify-center p-2
                      text-slate-500 hover:text-indigo-600
                      hover:bg-indigo-50 rounded-full transition"
               title="Edit Ticket: ' . e($capextype->code) . '">
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
        <a href="' . route('showcapextype', $idHashed) . '"
           class="inline-flex items-center justify-center p-2
                  text-slate-500 hover:text-emerald-600
                  hover:bg-emerald-50 rounded-full transition"
           title="Show Ticket: ' . e($capextype->code) . '">
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
        $capextype = Capextype::with('user.employee')->all()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
   $users = User::whereHas('employee', function ($q) {
        $q->where('status', 'Active');
    })
    ->join('employees_tables', 'employees_tables.id', '=', 'users.employee_id')
    ->pluck('employees_tables.employee_name', 'users.id');
        abort_if(!$capextype, 404);
        return view('pages.capextype.editcapextype', compact('capextype','users'));
    }
    public function show($hash)
    {
        $capextype = Capextype::with('user.employee')->all()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
      $users = User::whereHas('employee', function ($q) {
        $q->where('status', 'Active');
    })
    ->join('employees_tables', 'employees_tables.id', '=', 'users.employee_id')
    ->pluck('employees_tables.employee_name', 'users.id');
        abort_if(!$capextype, 404);
        return view('pages.capextype.showcapextype', compact('capextype','users'));
    }
    public function create()
    {
   $users = User::whereHas('employee', function ($q) {
        $q->where('status', 'Active');
    })
    ->join('employees_tables', 'employees_tables.id', '=', 'users.employee_id')
    ->pluck('employees_tables.employee_name', 'users.id');
        return view('pages.capextype.createcapextype', compact('users'));
    }
    public function update(Request $request, $hash)
    {
        $capextype = Capextype::with('user.employee')->all()->first(function ($v) use ($hash) {
            return substr(hash('sha256', $v->id . config('app.key')), 0, 8) === $hash;
        });

        abort_if(!$capextype, 404);

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:capex_type,code,' . $capextype->id,
            'user_id' => 'required|nullable',
        ]);

        $capextype->update($validated);

        return redirect()
            ->route('capextype')
            ->with('success', 'Capex Type Updated Successfully');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:request_type,code',
            'user_id' => 'required|string',
        ]);
        Capextype::create($validated);
        return redirect()
            ->route('capextype')
            ->with('success', 'Capex Type Created Successfully');
    }
}
