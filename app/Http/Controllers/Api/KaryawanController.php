<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    /**
     * @OA\Get(
     *     path="/yf/karyawan/data",
     *     tags={"Karyawan"},
     *     summary="Get employee data",
     *     description="Mendapatkan data karyawan yang sedang login berdasarkan token autentikasi",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data karyawan",
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
     *         response=404,
     *         description="Employee data not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Employee data not found")
     *         )
     *     )
     * )
     */
    public function getEmployeeData(Request $request)
    {
        // Mendapatkan karyawan yang sedang login berdasarkan token
        $userId = Auth::user();
    
        // Jika pengguna tidak ditemukan (tidak terautentikasi), kembalikan error
        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated'
            ], 401);
        }
        $employee = Employee::with('shift', 'building', 'position')->where('id', $userId->id)->first();
        // Periksa apakah properti employees_name dan employees_email ada
        $employeeName = $employee->employees_name ?? 'Guest';
        $employeeEmail = $employee->employees_email ?? null;
    
        // Jika email karyawan tidak ditemukan, kembalikan error
        if (!$employeeEmail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee data not found'
            ], 404);
        }
    
        // Mengembalikan data karyawan dalam struktur JSON yang diinginkan
        return response()->json([
            'status' => 'success',
            'data' => $employee
        ], 200);
    }


    public function updatePassworduser(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'employees_password' => 'required|string|min:6|confirmed',  // Password harus terkonfirmasi
        ]);
    
        // Jika validasi gagal, kirimkan response error dengan status dan message
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 400); // Error 400 dengan pesan pertama
        }
    
        $userId = Auth::user();
        // Ambil data karyawan berdasarkan ID
        $employee = Employee::findOrFail($userId->id);
    
        // Buat salt (Anda bisa membuat salt statis atau random)
        $salt = salt();
        $passwordWithSalt = $salt . $request->employees_password;
    
        // Hash password dengan SHA-256 dan salt
        $hashedPassword = hash('sha256', $passwordWithSalt);
    
        // Simpan hashed password ke database
        $employee->employees_password = $hashedPassword;
        $employee->save();  // Simpan perubahan
    
        // Kirim respons sukses dengan status dan message
        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diperbarui'
        ]);
    }

    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'employees_name' => 'required|exists:employees,employees_name',
                'employees_code' => 'required|exists:employees,employees_code',
            ]);
            $userId = Auth::user();
            $employees = Employee::findOrFail($userId->id);
            if (!$employees) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employee not found.'
                ], 404);
            }
            $employees->employees_code = $request->input('employees_code');
            $employees->employees_name = $request->input('employees_name');

    
            $employees->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Profil berhasil diperbarui.',
                'data' => $employees // Menyertakan data karyawan yang diperbarui
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'errors' => $e->validator->errors() // Menyertakan kesalahan validasi
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the employee.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
