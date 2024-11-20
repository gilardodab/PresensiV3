<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;

class AuthController extends Controller
{

   /**
     * @OA\Post(
     *     path="/yf/login",
     *     tags={"Auth"},
     *     summary="Login user",
     *     description="Login user yang sudah terdaftar",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil login"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Login gagal"
     *     )
     * )
     */
    public function login(Request $request)
    {
        try {
            $salt = salt();
    
            // Mendapatkan employee berdasarkan email
            $employee = Employee::where('employees_email', $request->email)->first();
    
            // Jika email tidak ditemukan, kembalikan respons "Email salah"
            if (!$employee) {
                return response()->json(['status' => 'error', 'message' => 'Email salah'], 404);
            }
    
            // Gabungkan salt dengan password yang dimasukkan
            $passwordWithSalt = $salt . $request->password;
    
            // Hash password dengan SHA-256
            $hashedPassword = hash('sha256', $passwordWithSalt);
    
            // Cek apakah password yang di-hash cocok dengan password di database
            if ($hashedPassword !== $employee->employees_password) {
                return response()->json(['status' => 'error', 'message' => 'Password salah'], 401);
            }
    
            // Jika email dan password cocok, buat token autentikasi untuk employee
            $token = $employee->createToken('Personal Access Token')->plainTextToken;
    
            return response()->json(['status' => 'success', 'message' => 'Login successful', 'token' => $token], 200);
    
        } catch (\Exception $e) {
            // Penanganan error jika ada masalah koneksi atau error lainnya
            return response()->json(['status' => 'error', 'message' => 'Failed to connect to server'], 500);
        }
    }
    
    
        /**
     * @OA\Post(
     *     path="/yf/logout",
     *     tags={"Auth"},
     *     summary="Logout user",
     *     description="Logout user yang sedang login",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil logout",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Logout successful")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="User tidak terautentikasi",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="User not authenticated")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        // Cek apakah pengguna terautentikasi
        if ($request->user()) {
            // Hapus token dari request
            $request->user()->tokens()->where('id', $request->user()->currentAccessToken()->id)->delete();
    
            return response()->json(['status' => 'success', 'message' => 'Logout successful'], 200);
        }
    
        return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
    }
    
    
    
}
