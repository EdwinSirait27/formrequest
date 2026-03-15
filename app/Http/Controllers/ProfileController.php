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
        return view('pages.profile',compact('user'));
    }
}
