<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\CutyController;
use App\Http\Controllers\SettingController;
use App\Models\Employee;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::middleware(['guest:employee'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
});
// Route::get('/admin/dashboard', function () {
//     return view('admin.dashboard');
// })->name('dashboardadmin');


Route::middleware(['guest:user'])->group(function () {

    // Route::get('/adminyofa', function () {
    //     return view('auth.loginadmin');
    // })->name('loginadmin');
    Route::get('/adminyofa', function () {
        return view('adminyofa.dashboard');
    })->name('dashboardadmin');
    //old
    // Route::get('adminyofa', function () {
    //     return view('auth.loginadmin');
    // })->name('loginadmin');
    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin'])->name('prosesloginadmin');
});

Route::middleware(['auth:employee'])->group(function () {
// Route::get('/home', function () {
//     return view('home');
// });

Route::get('/home', [HomeController::class, 'index'])->name ('home');
// routes/web.php
Route::post('/load-home-counter', [HomeController::class, 'loadHomeCounter'])->name('load.home.counter');
Route::get('absent', [PresenceController::class, 'userindex']);
Route::post('/presences', [PresenceController::class, 'storeAbsence'])->name('presences.store');
Route::get('cuty', [CutyController::class, 'userindex']);
Route::get('history', [PresenceController::class, 'userindexhistory']);
Route::get('profile', [EmployeeController::class, 'userprofile'])->name('userprofile');

Route::post('/history/load', [PresenceController::class, 'loadData'])->name('history.load');
Route::post('/history/update', [PresenceController::class, 'updateHistory'])->name('history.update');

Route::post('/cuty/load', [CutyController::class, 'loadDataCuty'])->name('cuty.load');
Route::post('/cuty/update', [CutyController::class, 'update'])->name('cuty.update');
Route::post('/cuty/store', [CutyController::class, 'store'])->name('cuty.store');

Route::post('profile/update', [EmployeeController::class, 'update'])->name('profile.update');
Route::post('profile/updatephoto', [EmployeeController::class, 'updatePhoto'])->name('profile.updatephoto');

});



Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
// Route::post('register', [AuthController::class, 'registeradmin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('logoutadmin', [AuthController::class, 'logoutadmin'])->name('logoutadmin');


Route::get('loginadmin', [AuthController::class, 'showLoginFormadmin'])->name('loginadmin');

Route::middleware(['auth:user'])->group(function () {
    Route::get('/adminyofa', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::get('register', [AuthController::class, 'create'])->name('register.create');  // Show registration form
    Route::post('register', [AuthController::class, 'store'])->name('register.store');  // Handle registration form submission

    Route::get('karyawan',[EmployeeController::class, 'index'])->name('karyawan');
    Route::get('karyawan', [EmployeeController::class, 'index'])->name('karyawan.index');  // Display list of employees
    Route::get('karyawan/create', [EmployeeController::class, 'create'])->name('karyawan.create');  // Form to add a new employee
    Route::post('karyawan', [EmployeeController::class, 'store'])->name('karyawan.store');
    // Store a new employee
    Route::get('karyawan/{id}/edit', [EmployeeController::class, 'edit'])->name('karyawan.edit');  // Form to edit an employee
    Route::put('karyawan/{id}', [EmployeeController::class, 'updateKaryawan'])->name('karyawan.update');
    Route::put('karyawan/{id}/update-password', [EmployeeController::class, 'updatePassword'])->name('karyawan.update.password');    
    Route::delete('karyawan/{id}', [EmployeeController::class, 'destroy'])->name('karyawan.destroy');  // Delete employee

    Route::get('/kantor', [BuildingController::class, 'index'])->name('adminyofa.kantor.index');
    Route::get('/kantor/create', [BuildingController::class, 'create'])->name('kantor.create');
    Route::get('/kantor/{building}', [BuildingController::class, 'show'])->name('kantor.show');
    Route::post('/kantor', [BuildingController::class, 'store'])->name('kantor.store');
    // Route untuk mengedit data
    Route::get('/kantor/{building}/edit', [BuildingController::class, 'edit'])->name('kantor.edit');
    // Route untuk mengupdate data
    Route::put('/kantor/{building}', [BuildingController::class, 'update'])->name('kantor.update');
    // Route untuk menghapus data
    Route::delete('/kantor/{building}', [BuildingController::class, 'destroy'])->name('kantor.destroy');

    Route::get('cutyadmin', [CutyController::class, 'index'])->name('cutyadmin');
    Route::post('/cuty/update-status', [CutyController::class, 'updateStatus'])->name('cuti.updateStatus');
    Route::get('/cuty/print/{id}', [CutyController::class, 'print'])->name('cuti.print');
    
    // Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin'])->name('prosesloginadmin');
    //Presence
    Route::get('/map', [PresenceController::class, 'showMap'])->name('map.show');
    Route::get('/absensi', [PresenceController::class, 'index']);
    // Route::get('/absensi', [PresenceController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [PresenceController::class, 'create'])->name('absensi.create');
    Route::get('/absensi/edit/{id}', [PresenceController::class, 'edit'])->name('absensi.edit');
    Route::get('/absensi/{id}', [PresenceController::class, 'show'])->name('absensi.show');
    Route::post('/absensi', [PresenceController::class, 'store'])->name('absensi.store');
    Route::put('/absensi/{id}', [PresenceController::class, 'update'])->name('absensi.update');
    Route::delete('/absensi/{presence_id}', [PresenceController::class, 'destroy'])->name('absensi.destroy');

    Route::get('/shift', [ShiftController::class, 'index'])->name('adminyofa.shift.index');
    Route::get('/shift/create', [ShiftController::class, 'create'])->name('shift.create');
    Route::get('/shift/edit/{shift_id}', [ShiftController::class, 'edit'])->name('shift.edit');
    Route::get('/shift/{id}', [ShiftController::class, 'show'])->name('shift.show');
    Route::post('/shift/store', [ShiftController::class, 'store'])->name('shift.store');
    Route::put('/shift/{shift_id}', [ShiftController::class, 'update'])->name('shift.update');
    Route::delete('/shift/{shift_id}', [ShiftController::class, 'destroy'])->name('shift.destroy');

    Route::get('user',[AuthController::class, 'useradmin'])->name('adminyofa.user.index');


    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [SettingController::class, 'updateSetting'])->name('settings.update');
    Route::post('/settings/profile', [SettingController::class, 'updateProfile'])->name('settings.profile');    
    Route::get('/settings/umum', [SettingController::class, 'loadSettingUmum'])->name('settings.umum');
    Route::get('/settings/profile', [SettingController::class, 'loadSettingProfile'])->name('settings.profile');

    //route group adminyofa
    Route ::group(['prefix' => 'adminyofa'], function () {
        Route::get('/jabatan', [PositionController::class, 'index'])->name('adminyofa.jabatan.index');
        Route::get('/jabatan/create', [PositionController::class, 'create'])->name('jabatan.create');
        Route::get('/jabatan/edit/{id}', [PositionController::class, 'edit'])->name('jabatan.edit');
        Route::get('/jabatan/{id}', [PositionController::class, 'show'])->name('jabatan.show');
        Route::post('/jabatan/store', [PositionController::class, 'store'])->name('jabatan.store');
        Route::put('/jabatan/{id}', [PositionController::class, 'update'])->name('jabatan.update');
        Route::delete('/jabatan/{position_id}', [PositionController::class, 'destroy'])->name('jabatan.destroy');
    });
});



// Route::get('dashboard', function () {
//     return view('adminyofa.dashboard');
// });
