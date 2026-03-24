<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ApiController extends Controller
{
     public function show($id)
{
    $financestaff = User::with(['employee.position', 'roles'])->findOrFail($id);

    return response()->json([
        'id' => $financestaff->id,
        'employee_name' => $financestaff->employee->employee_name,
        'position' => $financestaff->employee->position->name,
        'roles' => $financestaff->roles
                        ->where('name', 'finance')
                        ->pluck('name')
                        ->first(),
        'signature_url' => $financestaff->employee->signature
                               ? url('storage/' . $financestaff->employee->signature)
                               : null,
    ]);
}
}
