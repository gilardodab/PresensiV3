<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Cuty;
use Illuminate\Support\Facades\Auth;

class CutiController extends Controller
{
    //
        /**
     * @OA\Get(
     *     path="/yf/cuti/data-cuti",
     *     tags={"Cuti"},
     *     summary="Memuat data cuti",
     *     description="Mendapatkan data cuti yang sedang login berdasarkan token autentikasi",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data cuti",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="employee_name", type="string", example="John Doe"),
     *                 @OA\Property(property="employee_email", type="string", example="johndoe@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data Cuti Tidak Ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Employee data not found")
     *         )
     *     )
     * )
     */
    public function datacuti()
    {
        //
        $userId = Auth::user(); // Get the logged-in user's ID
        $year = date('Y');
        $filter[] = [DB::raw('YEAR(cuty_start)'), '=', $year];
        $cuties = Cuty::with('employees','')
        ->where('employees_id', $userId->id)
        ->where($filter)
        ->get();
        if ($cuties->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $cuties
        ], 200);
    }

    /**
     *     @OA\POST(
     *     path="/yf/cuti/tambah-data-cuti",
     *     tags={"Cuti"},
     *     summary="Memuat data cuti",
     *     description="Menambahkan data cuti yang sedang login berdasarkan token autentikasi",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil menyimpan data cuti",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="employee_name", type="string", example="John Doe"),
     *                 @OA\Property(property="employee_email", type="string", example="johndoe@example.com")
     *             )
     *         )
     *     ),
     * )
     */

    public function tambahcuti(Request $request)
    {
        // Mendapatkan tanggal hari ini dan H+7
        $today = now()->toDateString(); // Tanggal hari ini
        $maxDate = now()->addDays(7)->toDateString(); // Tanggal H+7
        $employee = Auth::user();
        // Validasi input
        Log::info('Received data for cuti creation', [
            'cuty_start' => $request->cuty_start,
            'cuty_end' => $request->cuty_end,
            'date_work' => $request->date_work,
            'cuty_total' => $request->cuty_total,
            'cuty_description' => $request->cuty_description,
        ]);
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'cuty_start' => 'required|date_format:Y-m-d',
            'cuty_end' => 'required|date_format:Y-m-d',
            'date_work' => 'required|date_format:Y-m-d',
            'cuty_total' => 'required|integer',
            'cuty_description' => 'nullable|string',
        ]);
    
        // Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Coba simpan data cuti
        try {
            $cuty = Cuty::create([
                'employees_id' => $employee->id,
                'cuty_start' =>  $request->cuty_start,
                'cuty_end' => $request->cuty_end,
                'date_work' => $request->date_work,
                'cuty_total' => $request->cuty_total,
                'cuty_description' => $request->cuty_description,
                'cuty_status' => 3,  
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Cuty created successfully.',
                'data' => $cuty, // Menampilkan data yang baru saja disimpan
            ], 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat penyimpanan data
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create cuty.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function editCuti(Request $request, $id)
    {
        // Dapatkan data cuti berdasarkan ID
        $cuty = Cuty::find($id);
        if (!$cuty) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data cuti tidak ditemukan',
            ], 404);
        }

        // Mendapatkan tanggal hari ini untuk validasi
        $today = now()->toDateString();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'cuty_start' => "required|date|after_or_equal:$today",
            'cuty_end' => 'required|date|after_or_equal:cuty_start',
            'date_work' => 'required|date|after_or_equal:cuty_end',
            'cuty_total' => 'required|integer|min:1',
            'cuty_description' => 'nullable|string',
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Update data cuti
        try {
            $cuty->update([
                'cuty_start' => $request->cuty_start,
                'cuty_end' => $request->cuty_end,
                'date_work' => $request->date_work,
                'cuty_total' => $request->cuty_total,
                'cuty_description' => $request->cuty_description,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data cuti berhasil diupdate',
                'data' => $cuty,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengupdate data cuti',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function hapusCuti($id)
    {
        // Temukan data cuti berdasarkan ID
        $cuty = Cuty::find($id);
        if (!$cuty) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data cuti tidak ditemukan',
            ], 404);
        }

        // Hapus data cuti
        try {
            $cuty->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data cuti berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data cuti',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
