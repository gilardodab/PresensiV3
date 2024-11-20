<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PresensiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/yf/presensi",
     *     tags={"Presensi"},
     *     summary="Load employee presence data",
     *     description="Memuat data absensi karyawan berdasarkan ID, bulan, dan tahun",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID karyawan"
     *     ),
     *     @OA\Parameter(
     *         name="month",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", example="01"),
     *         description="Bulan dalam format 2 digit (default: bulan saat ini)"
     *     ),
     *     @OA\Parameter(
     *         name="year",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", example="2023"),
     *         description="Tahun dalam format 4 digit (default: tahun saat ini)"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil memuat data absensi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="employees_id", type="integer", example=123),
     *                     @OA\Property(property="presence_date", type="string", format="date", example="2023-11-01"),
     *                     @OA\Property(property="presence_status", type="string", example="Present"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-11-01T12:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-11-01T12:00:00Z")
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Data absensi berhasil dimuat")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data absensi tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Data absensi tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function loadDataAbsen(Request $request)
    {
        $employee = Auth::user();
        $month = $request->input('month') ?: date('m');
        $year = $request->input('year') ?: date('Y');

        $presences = Presence::with('presentStatus')->where('employees_id', $employee->id)
            ->whereMonth('presence_date', $month)
            ->whereYear('presence_date', $year)
            ->orderBy('presence_date', 'desc')
            ->get();

        // Jika data absensi kosong, berikan respon error
        if ($presences->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data absensi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $presences,
            'message' => 'Data absensi berhasil dimuat'
        ]);
    }

    public function loadDataSeminggu(Request $request)
    {
        $employee = Auth::user();
    
        // Jika pengguna tidak ditemukan (tidak terautentikasi), kembalikan error
        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated'
            ], 401);
        }
        // Tanggal seminggu yang lalu
        $oneWeekAgo = Carbon::now()->subDays(7);
    
        // Mengambil data presensi untuk karyawan yang login dalam 7 hari terakhir
        $presences = Presence::where('employees_id', $employee->id)
        ->where('presence_date', '>=', $oneWeekAgo)
        ->orderBy('presence_date', 'desc')
        ->get();
                            
    
        if ($presences->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No presence data found for this user in the last week',
                'data' => []
            ], 404);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Presence data for the last week retrieved successfully',
            'data' => $presences
        ], 200);
    }

    public function loadData(Request $request)
    {
        $employee = Auth::user();
    
        // Jika pengguna tidak ditemukan (tidak terautentikasi), kembalikan error
        if (!$employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated'
            ], 401);
        }

        // Mengambil data presensi untuk karyawan yang login dalam 7 hari terakhir
        $presences = Presence::where('employees_id', $employee->id)
        ->get();
                            
    
        if ($presences->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No presence data found for this user in the last week',
                'data' => []
            ], 404);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Presence data for the last week retrieved successfully',
            'data' => $presences
        ], 200);
    }

    public function presensi(Request $request)
    {
        // Validasi input
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'picture' => 'required|string' // Mengharapkan gambar dalam format Base64
        ]);
    
        $user = Auth::user();
        $employee = Employee::with('shift', 'building')->where('id', $user->id)->first();
        $presence = Presence::where('employees_id', $employee->id)
                            ->where('presence_date', now()->toDateString())
                            ->first();
    
        // Proses decoding gambar dari Base64
        $base64Image = $request->input('picture');
        $imageData = base64_decode($base64Image);
    
        // Tentukan nama file dan path penyimpanan untuk gambar
        $file = $request->file('picture'); // Asumsikan bahwa `picture` adalah file
        $type = $file->getClientOriginalExtension(); // Menggunakan getClientOriginalExtension untuk mendapatkan ekstensi file
        $filename = now()->toDateString() . '-in-' . time() . '-' . $employee->id . '.' . $type;
        $filePath = storage_path('app/public/absent/' . $filename);
    
        if ($presence) { 
            if ($presence->time_out == '00:00:00') {
                // Proses presensi keluar (pulang)
                $filename = now()->toDateString() . '-out-' . time() . '-' . $employee->id . '.' . $type;
                $filePath = storage_path('app/public/absent/' . $filename);
                
                // Simpan gambar pulang ke penyimpanan
                file_put_contents($filePath, $imageData);
    
                // Update data presensi dengan waktu pulang, gambar pulang, dan lokasi pulang
                $presence->update([
                    'time_out' => now()->toTimeString(),
                    'picture_out' => $filename,
                    'latitude_longtitude_out' => $request->latitude . ',' . $request->longitude,
                ]);
    
                return response()->json([
                    'status' => 'success',
                    'message' => 'Presence updated successfully for check-out',
                    'data' => $presence,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You have already checked out today',
                ], 400);
            }
        } else {
            // Simpan gambar masuk ke penyimpanan
            file_put_contents($filePath, $imageData);
    
            // Simpan data presensi masuk ke database
            $presence = Presence::create([
                'employees_id' => $employee->id,
                'presence_date' => now()->toDateString(),
                'time_in' => now()->toTimeString(),
                'time_out' => '00:00:00',
                'picture_in' => $filename,
                'latitude_longtitude_in' => $request->latitude . ',' . $request->longitude,
                'present_id' => 1, // 1 untuk hadir
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Presence recorded successfully for check-in',
                'data' => $presence,
            ], 201);
        }
    }

    public function updateRiwayat(Request $request)
    {
        $presenceId = $request->input('presence_id');

        // Validasi input
        $request->validate([
            'present_id' => 'required|exists:present_status,present_id',
            'information' => 'nullable|string',
        ]);

        // Update data presensi
        $presence = Presence::find($presenceId);
        $presence->present_id = $request->input('present_id');
        $presence->information = $request->input('information');
        $presence->save();

        return response()->json(['status' => 'success']);
    }
    
    

}
