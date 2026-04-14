<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use Yajra\DataTables\Facades\DataTables; // ✅ benar
use Illuminate\Support\Facades\Log;
use Spatie\Permission\PermissionRegistrar;


class RoleController extends Controller
{
    public function index()
    {
        return view('pages.roles.roles');
    }
    // public function getRoles()
    // {
    //     $query = Role::with('permissions')
    //         ->select(['id', 'name']);
    //          return DataTables::eloquent($query)
    //         ->addIndexColumn()
    //         ->addColumn('action', function ($role) {
    //             $idHashed = substr(hash('sha256', $role->id . env('APP_KEY')), 0, 8);
    //             {
    //                 $editBtn = '
    //         <a href="' . route('editroles', $idHashed) . '"
    //            class="inline-flex items-center justify-center p-2
    //                   text-slate-500 hover:text-indigo-600
    //                   hover:bg-indigo-50 rounded-full transition"
    //            title="Edit Ticket: ' . e($role->name) . '">
    //             <svg xmlns="http://www.w3.org/2000/svg"
    //                  class="w-5 h-5"
    //                  fill="none"
    //                  viewBox="0 0 24 24"
    //                  stroke="currentColor"
    //                  stroke-width="1.8">
    //                 <path stroke-linecap="round" stroke-linejoin="round"
    //                       d="M16.862 3.487a2.1 2.1 0 013.001 2.949
    //                          L7.125 19.174 3 21l1.826-4.125
    //                          L16.862 3.487z" />
    //             </svg>
    //         </a>';
    //             }
               
    //             return $editBtn;
    //         })
    //         ->rawColumns(['action'])
    //         ->make(true);
    // }
    public function getRoles()
{
    $query = Role::with('permissions')
        ->select(['id', 'name']);

    return DataTables::eloquent($query)
        ->addIndexColumn()

        ->addColumn('permissions', function ($role) {
            return $role->permissions->pluck('name')->implode(', ');
        })

        ->addColumn('action', function ($role) {
            $idHashed = substr(hash('sha256', $role->id . env('APP_KEY')), 0, 8);

            $editBtn = '
            <a href="' . route('editroles', $idHashed) . '"
               class="inline-flex items-center justify-center p-2
                      text-slate-500 hover:text-indigo-600
                      hover:bg-indigo-50 rounded-full transition"
               title="Edit Role: ' . e($role->name) . '">
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

            return $editBtn;
        })

        ->rawColumns(['action'])
        ->make(true);
}
 

     public function edit($hash)
    {
        $role = Role::with('permissions')->get()->first(function ($u) use ($hash) {
            return substr(hash('sha256', $u->id . env('APP_KEY')), 0, 8) === $hash;
        });
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
    
        abort_if(!$role, 404);
        return view('pages.roles.editroles', compact('role','permissions','rolePermissions'));
    }
 
public function update(Request $request, $hash)
{
     $role = Role::all()->first(function ($v) use ($hash) {
            return substr(hash('sha256', $v->id . config('app.key')), 0, 8) === $hash;
        });
    if (!$role) {
        return redirect()->route('roles')->with('error', 'Role not found.');
    }
    try {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array'],
            'permissions.*' => [
                'required',
                'exists:permissions,id',
                'distinct'
            ]
        ], [
            'permissions.*.exists' => 'Permission yang dipilih tidak ditemukan.',
            'permissions.*.distinct' => 'Permission duplikat tidak diperbolehkan.'
        ]);
        $role->update(['name' => $validatedData['name']]);
        $permissions = Permission::whereIn('id', $validatedData['permissions'])->get();
       
        $before = $role->permissions->pluck('id')->toArray();
        Log::info('Permission sebelum update:', $before);

        $role->syncPermissions($permissions);

        $after = $role->permissions()->pluck('id')->toArray();
        Log::info('Permission sesudah update:', $after);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('roles')->with('success', 'Role berhasil diupdate.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::warning('Validasi gagal', ['errors' => $e->errors()]);
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        Log::error('Gagal update role', [
            'error_message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate role.')->withInput();
    }
}
}
