<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/finance/{id}', [ApiController::class, 'show']);
