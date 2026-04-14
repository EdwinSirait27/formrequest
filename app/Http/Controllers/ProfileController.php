<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tickets;

class ProfileController extends Controller
{
    public function profile()
    {
        
        $user = Auth::user();
        $roles = $user->getRoleNames();
        return view('pages.profile',compact('roles','user'));
    }
     public function updateActiveRole(Request $request)
{
    $request->validate([
        'role' => 'required|string',
    ]);
    $user = auth()->user();

    // validasi dari all_roles_bdtix, bukan Spatie
    $allRoles = $user->all_roles_formrequest ?? [];
    if (!in_array($request->role, $allRoles)) {
        return redirect()->back()->withErrors(['role' => 'Invalid role selected']);
    }

    // simpan active role
    $user->update(['active_role_formrequest' => $request->role]);

    // sync Spatie ke role yang dipilih
    $user->syncRoles([$request->role]);

    return redirect()->back()->with('success', 'Active role updated successfully!');
}
}
