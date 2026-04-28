<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestTypeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CapextypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VendorController;
Route::middleware('throttle:15,1', 'guest')->group(function () {
    Route::get('/', [AuthController::class, 'loginPage'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});
Route::middleware(['auth','role:admin|finance|manager|director|user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboardPage'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/savesign', [AuthController::class, 'save'])->name('save.signature');
    Route::put('/profile/update-role', [ProfileController::class, 'updateRole'])
        ->name('profile.updateRole');
         Route::post('/updateroles', [ProfileController::class, 'updateActiveRole'])
        ->name('profile.update-active-role');
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
     Route::get('/capextype', [CapexTypeController::class, 'index'])->name('capextype');
    Route::get('/createcapextype', [CapexTypeController::class, 'create'])->name('createcapextype');
    Route::match(['GET', 'POST'], '/capextypes/capextypes', [CapexTypeController::class, 'getCapextypes'])->name('capextypes.capextypes');
    Route::get('/editcapextype/{hash}', [CapexTypeController::class, 'edit'])->name('editcapextype');
    Route::get('/showcapextype/{hash}', [CapexTypeController::class, 'show'])->name('showcapextype');
    Route::put('/updatecapextype/{hash}', [CapexTypeController::class, 'update'])->name('updatecapextype');
    Route::post('/storecapextype', [CapexTypeController::class, 'store'])->name('storecapextype');
    // roles
     Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/editroles/{hash}', [RoleController::class, 'edit'])->name('editroles');
    Route::put('/updateroles/{hash}', [RoleController::class, 'update'])->name('updateroles');
    Route::match(['GET', 'POST'], '/roles/roles', [RoleController::class, 'getRoles'])->name('roles.roles');

});
// Route::middleware('throttle:15,1', 'guest')->group(function () {
//     Route::get('/', [AuthController::class, 'loginPage'])->name('login')->middleware('guest');
//     Route::post('/login', [AuthController::class, 'login'])->name('login.post');
// });
// Route::middleware('throttle:15,1', 'auth', 'role:admin|user|finance|director|manager')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
//     Route::post('/savesign', [AuthController::class, 'save'])->name('save.signature');
//     Route::put('/profile/update-role', [ProfileController::class, 'updateRole'])
//         ->name('profile.updateRole');
//     Route::post('/logout', [AuthController::class, 'logout'])
//         ->name('logout.post');
//     Route::group(['middleware' => ['permission:dashboard|dashboard user|dashboard finance|dashboard manager|dashboard director']], function () {
//         Route::get('/dashboard', [DashboardController::class, 'dashboardPage'])->name('dashboard');
//     });
//     Route::group(['middleware' => ['permission:view request|view request user|view request finance|permission:view request manager|view request director']], function () {
//         Route::get('/request', [RequestController::class, 'formpage'])->name('request');
//     });

  
//     Route::group(['middleware' => ['permission:view vendor']], function () {
//         Route::get('/vendor', [VendorController::class, 'index'])->name('vendor');
//     });
//     Route::group(['middleware' => ['permission:view requesttype']], function () {
//         Route::get('/requesttype', [RequestTypeController::class, 'index'])->name('requesttype');
//     });
//     Route::group(['middleware' => ['permission:view capextype']], function () {
//         Route::get('/capextype', [CapexTypeController::class, 'index'])->name('capextype');
//     });
//     Route::group(['middleware' => ['permission:userspermissions']], function () {
//       Route::get('/users', [UserController::class, 'users'])->name('users');
//     Route::match(['GET', 'POST'], '/users/users', [UserController::class, 'getUsers'])->name('users.users');
//     Route::get('/editusers/{hash}', [UserController::class, 'edit'])->name('editusers');
//     Route::put('/updateusers/{hash}/update', [UserController::class, 'update'])->name('updateusers');
//     Route::post('/users/bulk-update-role', [UserController::class, 'bulkUpdateRole'])->name('users.bulkUpdateRole');
//      Route::get('/roles', [RoleController::class, 'index'])->name('roles');
//     Route::get('/editroles/{hash}', [RoleController::class, 'edit'])->name('editroles');
//     Route::put('/updateroles/{hash}', [RoleController::class, 'update'])->name('updateroles');
//     Route::match(['GET', 'POST'], '/roles/roles', [RoleController::class, 'getRoles'])->name('roles.roles');
//     });
// });

 