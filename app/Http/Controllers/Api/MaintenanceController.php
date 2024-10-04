<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
        /**
     * Menampilkan semua data maintenance.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Mengambil semua data maintenance
        $maintenance = Maintenance::all();

        // Mengembalikan response dalam format JSON
        return response()->json([
            'status' => 'success',
            'data' => $maintenance
        ], 200);
    }

}
