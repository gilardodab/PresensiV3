<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CallplanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\CutyController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\NotificationController;
use App\Models\Callplan;
use App\Models\Employee;
use App\Models\Kunjungan;

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

Route::post('/send-notification', [NotificationController::class, 'sendNotification']);

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

    Route::get('/callplan', [CallplanController::class, 'userindex'])->name('callplan.index');
    Route::post('/callplan/load', [CallplanController::class,'loadDataCallplan'])->name('callplan.load');
    Route::post('/callplan/update',[CallplanController::class,'update'])->name('callplan.update');
    Route::post('/callplan/store',[CallplanController::class,'store'])->name('callplan.store');
    Route::post('/callplan/destroy',[CallplanController::class,'destroy'])->name('callplan.destroy');

    Route::get('/kunjungan', [KunjunganController::class, 'userindex'])->name('kunjungan.index');
    Route::post('/kunjungan/load', [KunjunganController::class,'loadDataKunjungan'])->name('kunjungan.load');
    Route::post('/kunjungan/loadriwayat', [KunjunganController::class,'loadDataKunjunganRiwayat'])->name('kunjungan.loadriwayat');
    Route::post('/kunjungan/update',[KunjunganController::class,'update'])->name('kunjungan.update');
    Route::get('/kunjungan/selfie/{kunjungan_id}', [KunjunganController::class, 'selfiekunjungan'])->name('kunjungan.indexkunjungan');
    Route::post('/kunjungan/store',[KunjunganController::class,'storeKunjungan'])->name('kunjungan.store');
    Route::post('/kunjungan/storeUnplan',[KunjunganController::class,'storeUnplan'])->name('kunjungan.storeUnplan');
    Route::get('unplan', [KunjunganController::class, 'unplan']);
    Route::post('profile/update', [EmployeeController::class, 'update'])->name('profile.update');
    Route::post('profile/updatepass', [EmployeeController::class, 'updatepass'])->name('profile.updatepass');
    Route::post('profile/updatephoto', [EmployeeController::class, 'updatePhoto'])->name('profile.updatephoto');

});



Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
// Route::post('register', [AuthController::class, 'registeradmin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('logoutadmin', [AuthController::class, 'logoutadmin'])->name('logoutadmin');


Route::get('loginadmin', [AuthController::class, 'showLoginFormadmin'])->name('loginadmin');

//middlewire auth:user with prefix group adminyofa 
Route::middleware(['auth:user'])->prefix('adminyofa/')->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::get('register', [AuthController::class, 'create'])->name('register.create');  // Show registration form
    Route::post('register', [AuthController::class, 'store'])->name('register.store');  // Handle registration form submission

    // Route::get('karyawan',[EmployeeController::class, 'index'])->name('karyawan');
    Route::get('karyawan', [EmployeeController::class, 'index'])->name('karyawan.index');  // Display list of employees
    Route::get('karyawan/create', [EmployeeController::class, 'create'])->name('karyawan.create');  // Form to add a new employee
    Route::post('karyawan', [EmployeeController::class, 'store'])->name('karyawan.store');
    // Store a new employee
    Route::get('karyawan/{id}/edit', [EmployeeController::class, 'edit'])->name('karyawan.edit');  // Form to edit an employee
    Route::put('karyawan/{id}/update-profile', [EmployeeController::class, 'updateKaryawan'])->name('karyawan.update');
    Route::put('karyawan/{id}/update-password', [EmployeeController::class, 'updatePassword'])->name('karyawan.update.password');    
    Route::delete('karyawan/{id}', [EmployeeController::class, 'destroy'])->name('karyawan.destroy');  // Delete employee

    Route::get('/kantor', [BuildingController::class, 'index'])->name('adminyofa.kantor.index');
    Route::get('/kantor/create', [BuildingController::class, 'create'])->name('kantor.create');
    Route::post('/kantor', [BuildingController::class, 'store'])->name('kantor.store');
    // Route untuk mengedit data
    Route::get('/kantor/{building}/edit', [BuildingController::class, 'edit'])->name('kantor.edit');
    // Route untuk mengupdate data
    Route::put('/kantor/{building}', [BuildingController::class, 'update'])->name('kantor.update');
    // Route untuk menghapus data
    Route::delete('/kantor/{building}', [BuildingController::class, 'destroy'])->name('kantor.destroy');

    Route::get('/cutyadmin', [CutyController::class, 'index'])->name('cutyadmin');
    Route::post('/cuty/update-status/', [CutyController::class, 'updateStatus'])->name('cuti.updateStatus');
    Route::get('/cuty/print/{id}', [CutyController::class, 'print'])->name('cuti.print');
    
    // Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin'])->name('prosesloginadmin');
    //Presence
    Route::get('/absensi', [PresenceController::class, 'index'])->name('adminyofa.absensi.index');
    Route::get('/loaddataabsen', [PresenceController::class, 'loadDataAbsen'])->name('absensi.load');
    

    //kunjungan
    Route::get('/kunjunganadmin', [KunjunganController::class, 'index'])->name('adminyofa.kunjungan.index');
    Route::get('/loaddatakunjunganadmin', [KunjunganController::class, 'loadDataKunjunganAdmin'])->name('kunjungan.loadadmin');

    //callplan
    

    // Route::get('/absensi', [PresenceController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [PresenceController::class, 'create'])->name('absensi.create');
    Route::get('/absensi/edit/{id}', [PresenceController::class, 'edit'])->name('absensi.edit');
    Route::get('/absensi/{id}', [PresenceController::class, 'show'])->name('absensi.show');
    Route::post('/absensi/store', [PresenceController::class, 'store'])->name('absensi.store');
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
    Route::get('/user/create', [AuthController::class, 'create'])->name('user.create');
    Route::post('/user', [AuthController::class, 'store'])->name('user.store');
    Route::get('/user/edit', [AuthController::class, 'edit'])->name('user.edit');
    Route::put('/user/update', [AuthController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [AuthController::class, 'destroy'])->name('user.destroy');


    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [SettingController::class, 'updateSetting'])->name('settings.update');
    Route::post('/settings/profile', [SettingController::class, 'updateProfile'])->name('settings.profile');    
    Route::get('/settings/umum', [SettingController::class, 'loadSettingUmum'])->name('settings.umum');
    Route::get('/settings/profile', [SettingController::class, 'loadSettingProfile'])->name('settings.profile');
    Route::post('/settings/storage', [SettingController::class, 'StorageLink'])->name('create.storage.link');

    Route::get('/jabatan', [PositionController::class, 'index'])->name('adminyofa.jabatan.index');
    Route::get('/jabatan/create', [PositionController::class, 'create'])->name('jabatan.create');
    Route::post('/jabatan/store', [PositionController::class, 'store'])->name('jabatan.store');
    Route::put('/jabatan/{position_id}', [PositionController::class, 'update'])->name('jabatan.update');
    Route::delete('/jabatan/{position_id}', [PositionController::class, 'destroy'])->name('jabatan.destroy');
    //route group adminyofa
    Route ::group(['prefix' => 'adminyofa'], function () {

    });
});



// Route::get('dashboard', function () {
//     return view('adminyofa.dashboard');
// });
