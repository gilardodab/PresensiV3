<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/yf/maintenance",
     *     tags={"Maintenance"},
     *     summary="Get all maintenance data",
     *     description="Menampilkan semua data maintenance",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan data maintenance",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Routine Maintenance"),
     *                     @OA\Property(property="description", type="string", example="Monthly routine maintenance"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-11-01T12:00:00Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-11-01T12:00:00Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to retrieve data")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            // Mengambil semua data maintenance
            $maintenance = Maintenance::all();

            // Mengembalikan response dalam format JSON
            return response()->json([
                'status' => 'success',
                'data' => $maintenance
            ], 200);
        } catch (\Exception $e) {
            // Menangani kesalahan dan mengembalikan respon error
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve data'
            ], 500);
        }
    }
}
