<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
      public function users()
    {
        return view('pages.users.users');
    }
    public function getUsers(Request $request)
    {
        $query = User::select([
            'users.id',
            'users.username',
            'users.employee_id',
            'employees_tables.status',
            'employees_tables.employee_name',
            'company_tables.name as company_name',
            'departments_tables.department_name',
            'stores_tables.name as store_name',
            'position_tables.name as position_name',
        ])
            ->leftJoin('employees_tables', 'employees_tables.id', '=', 'users.employee_id')
            ->leftJoin('company_tables', 'company_tables.id', '=', 'employees_tables.company_id')
            ->leftJoin('departments_tables', 'departments_tables.id', '=', 'employees_tables.department_id')
            ->leftJoin('stores_tables', 'stores_tables.id', '=', 'employees_tables.store_id')
            ->leftJoin('position_tables', 'position_tables.id', '=', 'employees_tables.position_id')
            ->whereIn('employees_tables.status', ['Active', 'Pending', 'Mutation']);
        return DataTables::eloquent($query)
            ->addColumn('roles', function ($user) {
                $roles = $user->getRoleNames();
                if ($roles->isEmpty()) {
                    return '<span class="badge bg-secondary">No Role</span>';
                }

                return $roles->map(
                    fn($role) =>
                    '<span class="badge bg-primary me-1">' . $role . '</span>'
                )->implode('');
            })
            ->addColumn('action', function ($user) {
                $idHashed = substr(hash('sha256', $user->id . env('APP_KEY')), 0, 8);

                return '
        <a href="' . route('editusers', $idHashed) . '"
           class="inline-flex items-center justify-center p-2 
                  text-slate-500 hover:text-indigo-600 
                  hover:bg-indigo-50 rounded-full transition"
           title="Edit Roles: ' . e($user->employee->employee_name) . '">

            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-5 h-5" 
                 fill="none" 
                 viewBox="0 0 24 24" 
                 stroke="currentColor" 
                 stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16.862 3.487a2.1 2.1 0 013.001 2.949L7.125 19.174 
                         3 21l1.826-4.125L16.862 3.487z" />
            </svg>

        </a>
    ';
            })
           ->addColumn('checkbox', function ($user) {
    return '
        <input type="checkbox"
               class="user-checkbox"
               name="user_ids[]"
               value="' . e($user->id) . '">
    ';
})


            ->rawColumns(['roles', 'action', 'checkbox'])
            ->make(true);
    }
    public function bulkUpdateRole(Request $request)
{
    $request->validate([
        'user_ids'   => 'required|array',
        'user_ids.*' => 'uuid'
    ]);

    try {
        User::whereIn('id', $request->user_ids)
            ->get()
            ->each(fn ($user) => $user->syncRoles('user'));

        return redirect()
            ->route('users')
            ->with('success', 'Role Updated Successfully');
    } catch (\Exception $e) {
        Log::error('Bulk update error', ['message' => $e->getMessage()]);

        return redirect()
            ->route('users')
            ->with('error', 'Role error update');
    }
}


    public function edit($hash)
    {
        $user = User::all()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
        abort_if(!$user, 404);
        $roles = Role::where('guard_name', 'web')->get();
        $userRoles = $user->getRoleNames()->toArray();
        return view('pages.users.editusers', compact('user', 'roles', 'userRoles'));
    }
    public function update(Request $request, $hash)
    {
        $user = User::all()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
        abort_if(!$user, 404);
        $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);
        // Sync role (hapus lama + insert baru)
        $user->syncRoles($request->roles ?? []);
        return redirect()
            ->route('users')
            ->with('success', 'Role Updated Successfully');
    }
}
