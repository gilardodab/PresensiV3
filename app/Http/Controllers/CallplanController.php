<?php

namespace App\Http\Controllers;

use App\Models\Callplan;
use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CallplanController extends Controller
{
    //
    public function index()
    {
        $callplan = Callplan::all();
        return view('callplan', compact('callplan'));
    }
    public function userindex()
    {
        $callplan = Callplan::all();
        return view('callplan', compact('callplan'));
    }

    public function loadDataCallplan (Request $request)
    {
        $userId = auth()->id(); // Get the logged-in user's ID
        $filter = [];

        if ($request->has('from') && $request->has('to')) {
            $from = $request->input('from') ? date('Y-m-d', strtotime($request->input('from'))) : '00-00-0000';
            $to = date('Y-m-d', strtotime($request->input('to')));        
            $filter[] = ['tanggal_cp', '>=', $from];
            $filter[] = ['tanggal_cp', '<=', $to];
        } else {
            $month = date('m');
            $filter[] = [DB::raw('MONTH(tanggal_cp)'), '=', $month];
        }

        $callplan = Callplan::where('employees_id', $userId)
        ->where($filter)
        ->get();
        return view('partials.callplan_list', compact('callplan'));
    }

    public function store(Request $request)
    {
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
                'callplan_id' => $callplan->callplan_id, // Menggunakan ID dari callplan yang baru saja dibuat
                'description' => $request->description,
            ]);
            
            return response()->json(['status' => 'success', 'message' => 'Data Call Plan berhasil ditambah!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }
    
    

    public function update(Request $request)
    {
        $CallplanId = $request->input('callplan_id'); 
    
        // Validasi input
        $request->validate([
            'callplan_id' => 'required|exists:callplan,callplan_id', // Pastikan nama tabel sesuai
            'tanggal_cp' => 'required|date',
            'nama_outlet' => 'required|string',
            'description' => 'nullable|string',
        ]);
    
        try {
            // Mencari record callplan
            $callplan = Callplan::find($CallplanId);
            if (!$callplan) {
                return response()->json(['status' => 'error', 'message' => 'Callplan tidak ada.'], 404);
            }
    
            // Memformat tanggal dan memperbarui data
            $callplan->tanggal_cp = Carbon::createFromFormat('d-m-Y', $request->tanggal_cp)->format('Y-m-d');
            $callplan->nama_outlet = $request->nama_outlet;
            $callplan->description = $request->description;
            $callplan->save();
    
            return response()->json(['status' => 'success', 'message' => 'Callplan berhasil diubah.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        $CallplanId = $request->input('callplan_id');
        $callplan = Callplan::find($CallplanId);
        if ($callplan) {
            $callplan->delete();
            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.'], 404);
        }
    }
}
