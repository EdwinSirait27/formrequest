<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
Route::middleware('throttle:15,1')->group(function () {
    Route::get('/', [AuthController::class, 'loginPage'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware(['auth','role:admin|finance|manager|director|user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboardPage'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/savesign', [AuthController::class, 'save'])->name('save.signature');
    Route::put('/profile/update-role', [ProfileController::class, 'updateRole'])
        ->name('profile.updateRole');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout.post');
    Route::get('/request', [RequestController::class, 'formpage'])->name('request');
    Route::get('/createrequest', [RequestController::class, 'create'])->name('createrequest');
    Route::get('/requests/data', [RequestController::class, 'getRequests'])
        ->name('requestsdata');
    Route::get('/editrequest/{hash}', [RequestController::class, 'edit'])->name('editrequest');
    Route::get('/showrequest/{hash}', [RequestController::class, 'show'])->name('showrequest');
    Route::get('/pdf/{id}', [RequestController::class, 'pdfview'])->name('request.pdf');
    Route::put('/updaterequest/{hash}', [RequestController::class, 'update'])->name('updaterequest');
    Route::post('/storerequest', [RequestController::class, 'store'])->name('storerequest');
});
Route::middleware(['auth', 'role:admin|finance'])->group(function () {
    Route::get('/vendor', [VendorController::class, 'index'])->name('vendor');
    Route::get('/createvendor', [VendorController::class, 'create'])->name('createvendor');
    Route::get('/vendors/data', [VendorController::class, 'getVendors'])
        ->name('vendorsdata');
    Route::get('/editvendor/{hash}', [VendorController::class, 'edit'])->name('editvendor');
    Route::get('/showvendor/{hash}', [VendorController::class, 'show'])->name('showvendor');
    Route::put('/updatevendor/{hash}', [VendorController::class, 'update'])->name('updatevendor');
    Route::post('/storevendor', [VendorController::class, 'store'])->name('storevendor');

    // Request Type
    
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // users
    Route::get('/users', [UserController::class, 'users'])->name('users');
    Route::match(['GET', 'POST'], '/users/users', [UserController::class, 'getUsers'])->name('users.users');
    Route::get('/editusers/{hash}', [UserController::class, 'edit'])->name('editusers');
    Route::put('/updateusers/{hash}/update', [UserController::class, 'update'])->name('updateusers');
    Route::post('/users/bulk-update-role', [UserController::class, 'bulkUpdateRole'])
        ->name('users.bulkUpdateRole');
        Route::get('/requesttype', [RequestTypeController::class, 'index'])->name('requesttype');
    Route::get('/createrequesttype', [RequestTypeController::class, 'create'])->name('createrequesttype');
    Route::match(['GET', 'POST'], '/vendors/vendors', [RequestTypeController::class, 'getRequesttypes'])->name('requesttypes.requesttypes');
    Route::get('/editrequesttype/{hash}', [RequestTypeController::class, 'edit'])->name('editrequesttype');
    Route::get('/showrequesttype/{hash}', [RequestTypeController::class, 'show'])->name('showrequesttype');
    Route::put('/updaterequesttype/{hash}', [RequestTypeController::class, 'update'])->name('updaterequesttype');
    Route::post('/storerequesttype', [RequestTypeController::class, 'store'])->name('storerequesttype');
    // Vendor

    //request

});
// Route::middleware(['auth', 'role:admin'])
//     ->prefix('admin')
//     ->name('admin.')
//     ->group(function () {
//     Route::get('/request', [RequestControllerAdmin::class, 'formpage'])->name('admin.request');
//     Route::get('/createrequest', [RequestControllerAdmin::class, 'create'])->name('admin.createrequest');
//     Route::get('/requests/data', [RequestControllerAdmin::class, 'admin.getRequestsadmin'])
//     ->name('admin.requestsdata');
//     Route::get('/editrequest/{hash}', [RequestControllerAdmin::class, 'edit'])->name('admin.editrequest');
//     Route::get('/showrequest/{hash}', [RequestControllerAdmin::class, 'show'])->name('admin.showrequest');
//     Route::get('/pdf/{id}', [RequestControllerAdmin::class, 'pdfview'])->name('admin.request.pdf');
//     Route::put('/updaterequest/{hash}', [RequestControllerAdmin::class, 'update'])->name('admin.updaterequest');
//     Route::post('/storerequest', [RequestControllerAdmin::class, 'store'])->name('admin.storerequest');
//     });
// Route::middleware(['auth', 'role:manager'])
//     ->prefix('manager')
//     ->name('manager.')
//     ->group(function () {
//     Route::get('/request', [RequestControllerManager::class, 'formpage'])->name('request');
//     Route::get('/createrequest', [RequestControllerManager::class, 'create'])->name('createrequest');
//     Route::get('/requests/data', [RequestControllerManager::class, 'getRequests'])
//     ->name('requestsdata');
//     Route::get('/editrequest/{hash}', [RequestControllerManager::class, 'edit'])->name('editrequest');
//     Route::get('/showrequest/{hash}', [RequestControllerManager::class, 'show'])->name('showrequest');
//     Route::get('/pdf/{id}', [RequestControllerManager::class, 'pdfview'])->name('request.pdf');
//     Route::put('/updaterequest/{hash}', [RequestControllerManager::class, 'update'])->name('updaterequest');
//     Route::post('/storerequest', [RequestControllerManager::class, 'store'])->name('storerequest');
//     });