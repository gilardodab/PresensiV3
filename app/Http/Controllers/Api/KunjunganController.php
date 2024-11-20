<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class KunjunganController extends Controller
{
    //
        /**
     * @OA\Get(
     *     path="/yf/callplan/data-callplan",
     *     tags={"Kunjungan"},
     *     summary="Mendapatkan data jadwal kunjungan",
     *     description="Mendapatkan data karyawan yang sedang login berdasarkan token autentikasi",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data kunjungan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="employee_name", type="string", example="John Doe"),
     *                 @OA\Property(property="employee_email", type="string", example="johndoe@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="User not authenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="User not authenticated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Jadwal Kunjungan Tidak tersedia diperiode ini ",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Employee data not found")
     *         )
     *     )
     * )
     */

    public function jadwalDataKunjungan(Request $request)
    {
        $userId = Auth::id(); // Mengambil ID pengguna yang sedang login
        $filter = [];
    
        try {
            // Memproses filter tanggal jika ada input 'from' dan 'to'
            if ($request->has('from') && $request->has('to')) {
                $from = $request->input('from') ? date('Y-m-d', strtotime($request->input('from'))) : '0000-00-00';
                $to = $request->input('to') ? date('Y-m-d', strtotime($request->input('to'))) : '0000-00-00';

                $filter[] = ['kunjungan_tgl', '>=', $from];
                $filter[] = ['kunjungan_tgl', '<=', $to];
            } else {
                // Default filter menggunakan bulan saat ini jika tanggal tidak diberikan
                $month = date('m');
                $filter[] = [DB::raw('MONTH(kunjungan_tgl)'), '=', $month];
            }
    
            // Mendapatkan data kunjungan sesuai dengan filter
            $kunjungan = Kunjungan::where('employees_id', $userId)
                ->where($filter)
                ->get();
    
            // Menyertakan pengecekan jika data tidak ditemukan
            if ($kunjungan->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Tidak ada data kunjungan yang ditemukan untuk periode ini.',
                    'data' => []
                ], 200);
            }
    
            // Mengembalikan respons jika data ditemukan
            return response()->json([
                'status' => 'success',
                'message' => 'Data kunjungan berhasil ditemukan.',
                'data' => $kunjungan
            ], 200);
    
        } catch (\Exception $e) {
            // Mengembalikan respons jika terjadi kesalahan
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memuat data kunjungan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function KunjunganRiwayat(Request $request)
    {
        $userId = Auth::id(); // Mengambil ID pengguna yang sedang login
        $filter = [];
    
        try {
            // Cek apakah input `from` dan `to` ada
            if ($request->has('from') && $request->has('to')) {
                $from = $request->input('from') ? date('Y-m-d', strtotime($request->input('from'))) : '1970-01-01';
                $to = $request->input('to') ? date('Y-m-d', strtotime($request->input('to'))) : date('Y-m-d');
       
                $filter[] = ['kunjungan_tgl', '>=', $from];
                $filter[] = ['kunjungan_tgl', '<=', $to];
            } else {
                // Jika `from` dan `to` tidak ada, ambil data bulan ini
                $month = date('m');
                $year = date('Y');
                $filter[] = [DB::raw('MONTH(kunjungan_tgl)'), '=', $month];
                $filter[] = [DB::raw('YEAR(kunjungan_tgl)'), '=', $year];
            }
    
            // Filter data berdasarkan employee_id dan filter yang ditentukan
            $kunjungans = DB::table('kunjungan')
                ->where('employees_id', $userId)
                ->where($filter)
                ->orderBy('kunjungan_id', 'DESC')
                ->get();
    
            // Menyertakan pengecekan jika data tidak ditemukan
            if ($kunjungans->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Tidak ada data kunjungan yang ditemukan untuk periode ini.',
                    'data' => []
                ], 200);
            }
    
            // Mengembalikan respons jika data ditemukan
            return response()->json([
                'status' => 'success',
                'message' => 'Data kunjungan berhasil ditemukan.',
                'data' => $kunjungans
            ], 200);
    
        } catch (\Exception $e) {
            // Mengembalikan respons jika terjadi kesalahan
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memuat data kunjungan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function presensiKunjungan(Request $request)
    {
        $kunjungan_id = $request->input('kunjungan_id'); 
    
        // Validasi input request
        $request->validate([
            'picture' => 'required|string',
            'latitude' => 'required|string',
            'kunjungan_id' => 'required|exists:kunjungan,kunjungan_id'
        ]);
    
        try {
            $imageData = $request->input('picture');
            $user = Auth::user();
            
            // Mengambil data employee lengkap dengan shift dan building
            $employee = Employee::with('shift', 'building')->where('id', $user->id)->first();
            
            if (!$employee) {
                return response()->json(['error' => 'Data karyawan tidak ditemukan.'], 404);
            }
    
            // Mencari kunjungan berdasarkan ID dan tanggal hari ini
            $kunjungan = Kunjungan::where('employees_id', $employee->id)
                ->where('kunjungan_tgl', now()->toDateString())
                ->where('kunjungan_id', $kunjungan_id)
                ->first();
                
            if (!$kunjungan) {
                return response()->json(['error' => 'Data kunjungan tidak ditemukan untuk hari ini.'], 404);
            }
    
            // Memeriksa apakah format base64 gambar valid
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]);
        
                if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return response()->json(['error' => 'Format gambar tidak valid! Hanya jpg, jpeg, png, gif yang diizinkan.'], 422);
                }
        
                $imageData = base64_decode($imageData);
        
                if ($imageData === false) {
                    return response()->json(['error' => 'Base64 decode gagal!'], 422);
                }
        
                // Memeriksa apakah kunjungan sudah ada `time_in`
                if (empty($kunjungan->time_in) || $kunjungan->time_in == '00:00:00') {
                    $filename = now()->toDateString() . '-kunjungan-' . time() . '-' . Auth::id() . '.' . $type;
                    $filePath = storage_path('app/public/kunjungan/' . $filename);
    
                    // Memastikan direktori penyimpanan ada
                    if (!file_exists(storage_path('app/public/kunjungan'))) {
                        mkdir(storage_path('app/public/kunjungan'), 0755, true);
                    }
    
                    // Menyimpan gambar ke storage
                    file_put_contents($filePath, $imageData);
        
                    // Mengupdate data kunjungan
                    $kunjungan->update([
                        'time_in' => now()->toTimeString(),
                        'picture_in' => $filename,
                        'latitude_longtitude_in' => $request->latitude,
                        'status_kunjungan' => 'Selesai'
                    ]);
        
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Selamat "' . $employee->employees_name . '" berhasil Absen Tempat pada Tanggal ' . now()->toDateString() . ' dan Jam : ' . now()->toTimeString()
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Anda sudah melakukan absen tempat pada Tanggal ' . now()->toDateString() . ' dan Jam ' . $kunjungan->time_in . '.'
                    ], 400);
                }
            } else {
                return response()->json(['error' => 'Format base64 gambar tidak valid!'], 422);
            }
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses presensi kunjungan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
}
