<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Callplan;
use App\Models\Kunjungan;
use App\Models\Employee;
use Illuminate\Http\Request;

class CallplanController extends Controller
{
    //
    public function loadDataCallplan(Request $request) {
        try {
            $employee = Auth::user();
            
            // Memvalidasi input tanggal jika tersedia
            if ($request->has('from') && $request->has('to')) {
                $from = $request->input('from') ? date('Y-m-d', strtotime($request->input('from'))) : '0000-00-00'; 
                $to = $request->input('to') ? date('Y-m-d', strtotime($request->input('to'))) : '0000-00-00';
                
                $filter[] = ['tanggal_cp', '>=', $from];
                $filter[] = ['tanggal_cp', '<=', $to];
            } else {
                // Default filter menggunakan bulan saat ini jika tanggal tidak diberikan
                $month = date('m');
                $filter[] = [DB::raw('MONTH(tanggal_cp)'), '=', $month];
            }
    
            // Query Callplan sesuai dengan filter yang diterapkan
            $callplans = Callplan::where('employees_id', $employee->id)
                ->where($filter)
                ->get();
    
            // Memeriksa apakah data Callplan ditemukan
            if ($callplans->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Tidak ada data callplan yang ditemukan untuk periode ini.',
                    'data' => []
                ], 200);
            }
    
            // Respons jika data ditemukan
            return response()->json([
                'status' => 'success',
                'message' => 'Data callplan berhasil ditemukan.',
                'data' => $callplans
            ], 200);
    
        } catch (\Exception $e) {
            // Respons jika terjadi kesalahan
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memuat data callplan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function buatcallpan(Request $request)
    {
        // Validasi input yang diterima
        $request->validate([
            'tanggal_cp' => 'required|date',
            'nama_outlet' => 'required|string',
            'description' => 'required|string',
        ]);
    
        try {
            // Membuat data callplan dan mendapatkan ID-nya
            $callplan = Callplan::create([
                'employees_id' => Auth::id(),
                'tanggal_cp' => $request->tanggal_cp,
                'nama_outlet' => $request->nama_outlet,
                'description' => $request->description,
            ]);
    
            // Menggunakan ID callplan yang baru dibuat untuk membuat data kunjungan
            Kunjungan::create([
                'employees_id' => Auth::id(),
                'kunjungan_tgl' => $request->tanggal_cp,
                'status_kunjungan' => 'Belum Selesai',
                'callplan_id' => $callplan->id, // Menggunakan ID dari callplan yang baru saja dibuat
                'description' => $request->description,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Data Call Plan berhasil ditambah!',
                'data' => [
                    'callplan_id' => $callplan->id, // Mengembalikan ID Callplan yang baru
                    'kunjungan_status' => 'Belum Selesai'
                ]
            ], 201);
    
        } catch (\Exception $e) {
            // Mengembalikan respons error jika terjadi kesalahan
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function editCallplan(Request $request)
    {
        $callplanId = $request->input('callplan_id'); 
        
        // Validasi input
        $request->validate([
            'callplan_id' => 'required|exists:callplans,id', // Pastikan nama tabel dan kolom sesuai
            'tanggal_cp' => 'required|date_format:d-m-Y',
            'nama_outlet' => 'required|string',
            'description' => 'nullable|string',
        ]);

        try {
            // Mencari record callplan
            $callplan = Callplan::find($callplanId);
            if (!$callplan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data Callplan tidak ditemukan.'
                ], 404);
            }

            // Memformat tanggal dan memperbarui data
            $callplan->tanggal_cp = $request->tanggal_cp;
            $callplan->nama_outlet = $request->nama_outlet;
            $callplan->description = $request->description;
            $callplan->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Data Callplan berhasil diubah.',
                'data' => [
                    'callplan_id' => $callplan->id,
                    'tanggal_cp' => $callplan->tanggal_cp,
                    'nama_outlet' => $callplan->nama_outlet,
                    'description' => $callplan->description,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengubah data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //create delete callplan 
    public function hapusCallplan(Request $request)
    {
        $callplanId = $request->input('callplan_id');
        $callplan = Callplan::find($callplanId);

        if (!$callplan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Callplan tidak ditemukan.'
            ], 404);
        }

        $callplan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data Callplan berhasil dihapus.'
        ], 200);
    }
}
