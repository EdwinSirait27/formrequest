<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware('throttle:15,1')->group(function () {
    Route::get('/', [AuthController::class, 'loginPage'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboardPage'])->name('dashboard');
     Route::post('/formrequest', [DashboardController::class, 'store'])
        ->name('formrequest.post');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/savesign', [AuthController::class, 'save'])->name('save.signature');

    Route::put('/profile/update-role',[ProfileController::class,'updateRole'])
    ->name('profile.updateRole');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout.post');
        // users
     Route::get('/users', [UserController::class, 'users'])->name('users');
    Route::match(['GET', 'POST'], '/users/users', [UserController::class, 'getUsers'])->name('users.users');
    Route::get('/editusers/{hash}', [UserController::class, 'edit'])->name('editusers');
    Route::put('/updateusers/{hash}/update', [UserController::class, 'update'])->name('updateusers');
    Route::post('/users/bulk-update-role', [UserController::class, 'bulkUpdateRole'])
        ->name('users.bulkUpdateRole');
        // Vendor
     Route::get('/vendor', [VendorController::class, 'index'])->name('vendor');
     Route::get('/createvendor', [VendorController::class, 'create'])->name('createvendor');
    Route::get('/vendors/data', [VendorController::class, 'getVendors'])
    ->name('vendorsdata');
    Route::get('/editvendor/{hash}', [VendorController::class, 'edit'])->name('editvendor');
    Route::get('/showvendor/{hash}', [VendorController::class, 'show'])->name('showvendor');
    Route::put('/updatevendor/{hash}', [VendorController::class, 'update'])->name('updatevendor');
    Route::post('/storevendor', [VendorController::class, 'store'])->name('storevendor');
    
       // Request Type
     Route::get('/requesttype', [RequestTypeController::class, 'index'])->name('requesttype');
     Route::get('/createrequesttype', [RequestTypeController::class, 'create'])->name('createrequesttype');
    Route::match(['GET', 'POST'], '/vendors/vendors', [RequestTypeController::class, 'getRequesttypes'])->name('requesttypes.requesttypes');
    Route::get('/editrequesttype/{hash}', [RequestTypeController::class, 'edit'])->name('editrequesttype');
    Route::get('/showrequesttype/{hash}', [RequestTypeController::class, 'show'])->name('showrequesttype');
    Route::put('/updaterequesttype/{hash}', [RequestTypeController::class, 'update'])->name('updaterequesttype');
    Route::post('/storerequesttype', [RequestTypeController::class, 'store'])->name('storerequesttype');
    //request
    Route::get('/request', [RequestController::class, 'formpage'])->name('request');
     Route::get('/createrequest', [RequestController::class, 'create'])->name('createrequest');
    Route::get('/requests/data', [RequestController::class, 'getRequests'])
    ->name('requestsdata');
    Route::get('/editrequest/{hash}', [RequestController::class, 'edit'])->name('editrequest');
    Route::get('/showrequest/{hash}', [RequestController::class, 'show'])->name('showrequest');
    // Route::get('/pdf/{hash}', [RequestController::class, 'pdfview'])->name('pdfrequest');
    // Route::get('/pdf/{hash}', [RequestController::class, 'pdfview'])
    // ->name('request.pdf');
    Route::get('/pdf/{id}', [RequestController::class, 'pdfview'])->name('request.pdf');
    Route::put('/updaterequest/{hash}', [RequestController::class, 'update'])->name('updaterequest');
    Route::post('/storerequest', [RequestController::class, 'store'])->name('storerequest'); 
});
