<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CutiController;
use \App\Http\Controllers\Api\MaintenanceController;
use App\Http\Controllers\Api\PresensiController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\CallplanController;
use App\Http\Controllers\Api\KunjunganController;
use App\Http\Controllers\NotificationController;
use GPBMetadata\Google\Api\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/send-notification', [NotificationController::class, 'sendNotification']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/yf/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/yf/logout', [AuthController::class, 'logout']);

Route::get('/yf/maintenance', [MaintenanceController::class, 'index']);
// Route::get('/yf/presensi', [PresensiController::class, 'loadDataAbsen']);
Route::middleware('auth:sanctum')->get('/yf/notifikasi', [AuthController::class, 'notifikasi']);
Route::middleware('auth:sanctum')->get('/yf/presensi/seminggu', [PresensiController::class, 'loadDataSeminggu']);
Route::middleware('auth:sanctum')->get('/yf/presensi/loadsemua', [PresensiController::class, 'loadDataAbsen']);
Route::middleware('auth:sanctum')->put('/yf/edit-data-presensi/{id}', [PresensiController::class, 'updateRiwayat']);
Route::middleware('auth:sanctum')->post('/yf/presensi/selfie', [PresensiController::class, 'presensi']);

Route::middleware('auth:sanctum')->get('yf/karyawan/data', [KaryawanController::class, 'getEmployeeData']);
Route::middleware('auth:sanctum')->post('yf/karyawan/update-password-user', [KaryawanController::class, 'updatePassworduser']);
Route::middleware('auth:sanctum')->post('yf/karyawan/update-profile-user', [KaryawanController::class, 'updateProfile']);

Route::middleware('auth:sanctum')->get('yf/cuti/data-cuti', [CutiController::class, 'datacuti']);
Route::middleware('auth:sanctum')->post('yf/cuti/tambah-data-cuti', [CutiController::class, 'tambahcuti']);
Route::middleware('auth:sanctum')->put('yf/cuti/edit-data-cuti/{id}', [CutiController::class, 'editCuti']);
Route::middleware('auth:sanctum')->delete('yf/cuti/hapus-data-cuti', [CutiController::class, 'hapusCuti']);

Route::middleware('auth:sanctum')->get('yf/callplan/data-callplan', [CallplanController::class, 'loadDataCallplan']);
Route::middleware('auth:sanctum')->post('yf/callplan/tambah-data-callplan', [CallplanController::class, 'buatcallpan']);
Route::middleware('auth:sanctum')->put('yf/callplan/edit-data-callplan/{id}', [CallplanController::class, 'editCallplan']);
Route::middleware('auth:sanctum')->delete('yf/callplan/hapus-data-callplan', [CallplanController::class, 'hapusCallplan']);

Route::middleware('auth:sanctum')->get('yf/kunjungan/jadwal-data-kunjungan', [KunjunganController::class, 'jadwalDataKunjungan']);
Route::middleware('auth:sanctum')->get('yf/kunjungan/riwayat-kunjungan', [KunjunganController::class, 'KunjunganRiwayat']);
Route::middleware('auth:sanctum')->put('yf/kunjungan/presensi-kunjungan',[KunjunganController::class,'presensiKunjungan']);

Route::post('yf/update-fcm-token', [App\Http\Controllers\Api\AuthController::class, 'updateFcmToken'])->middleware('auth:sanctum');
Route::get('storage/absent/{filename}', function ($filename) {
    $path = storage_path('app/public/absent/' . $filename);
    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
});
Route::get('storage/photos/{filename}', function ($filename) {
    $path = storage_path('app/public/absent/' . $filename);
    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
});