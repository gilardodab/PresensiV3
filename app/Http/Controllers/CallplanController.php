<?php

namespace App\Http\Controllers;

use App\Models\Callplan;
use App\Models\Kunjungan;
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
            Callplan::create([
                'employees_id' => Auth::id(),
                'tanggal_cp' => $request->tanggal_cp,
                'nama_outlet' => $request->nama_outlet,
                'description' => $request->description,
            ]);

            Kunjungan::create([
                'employees_id' => Auth::id(),
                'kunjungan_tgl' => $request->tanggal_cp,
                'status_kunjungan' => 'Belum Selesai',
                'callplan' => $request->nama_outlet,
                'description' => $request->description,
            ]);
    
            return response()->json(['status' => 'success', 'message' => 'Data Call Plan berhasil ditambah!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }
    

    public function update(Request $request){
        $CallplanId = $request->input('callplan_id'); 
    
        // Correct validation rules
        $request->validate([
            'callplan_id' => 'required|exists:callplan,callplan_id', // exists on the cuty table
            'tanggal_cp' => 'required|date',
            'nama_outlet' => 'required|string',
            'description' => 'nullable|string',
        ]);

        
    }
}
