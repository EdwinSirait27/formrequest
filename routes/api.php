<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/finance/{id}', [ApiController::class, 'show']);
Route::get('/manager/{employeeId}', [ApiController::class, 'getManagerByEmployee']);
