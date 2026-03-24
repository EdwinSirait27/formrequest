<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }
    public function login(Request $request)
{
    Log::info('Login request received', [
        'username' => $request->username,
        'ip' => $request->ip()
    ]);
    try {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        Log::info('Validation passed', [
            'username' => $request->username
        ]);
        $user = User::with('employee')
            ->where('username', $request->username)
            ->first();
        Log::info('User query executed', [
            'user_found' => $user ? true : false
        ]);
        if (!$user) {
            Log::warning('Login failed - user not found', [
                'username' => $request->username
            ]);
            return back()->with('error', 'Wrong username or password');
        }
        Log::info('User found', [
            'user_id' => $user->id,
            'username' => $user->username
        ]);
        if (
            !$user->employee ||
            !in_array($user->employee->status, ['Active', 'Pending', 'Mutation'])
        ) {
            Log::warning('Login blocked - employee inactive', [
                'user_id' => $user->id,
                'employee_status' => $user->employee->status ?? null
            ]);
            return back()->with('error', 'Account is inactive');
        }
        Log::info('Employee status valid', [
            'employee_status' => $user->employee->status
        ]);
        if (! $user->hasAnyRole(['human', 'admin', 'executor'])) {
            Log::warning('Login blocked - role not allowed', [
                'user_id' => $user->id,
                'roles' => $user->getRoleNames()
            ]);
            return back()->with('error', 'Account has no access role. Please contact Edwin Sirait.');
        }
        Log::info('Role validation passed', [
            'roles' => $user->getRoleNames()
        ]);
        if (!Auth::attempt($request->only('username', 'password'))) {
            Log::warning('Login failed - password mismatch', [
                'username' => $request->username
            ]);
            return back()->with('error', 'Wrong username or password');
        }
        Log::info('Auth attempt success', [
            'user_id' => $user->id
        ]);
        $request->session()->regenerate();
        Log::info('Session regenerated', [
            'user_id' => $user->id
        ]);
        return redirect()
            ->intended(route('dashboard'))
            ->with('success', 'Login successful');
    } catch (\Exception $e) {
        Log::error('Login exception', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
        return back()->with('error', 'Something went wrong during login.');
    }
}
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
   public function save(Request $request)
{
    $request->validate([
        'signature' => 'required'
    ]);
    $data = $request->signature;
    $image = str_replace('data:image/png;base64,', '', $data);
    $image = str_replace(' ', '+', $image);
    $fileName = 'signatures/' . uniqid() . '.png';
    $employee = auth()->user()->employee;
    if ($employee->signature) {
        Storage::disk('public')->delete($employee->signature);
    }
    Storage::disk('public')->put($fileName, base64_decode($image));
    $employee->signature = $fileName;
    $employee->save();
    return back()->with('success', 'Signature updated!');
}
}
