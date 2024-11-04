<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KunjunganController extends Controller
{
    //
    public function userindex(){
    $kunjungan = Kunjungan::all();
    return view('kunjungan', compact('kunjungan')) ;
    }

    public function loadDataKunjungan (Request $request)
    {
        $userId = auth()->id(); // Get the logged-in user's ID
        $filter = [];

        if ($request->has('from') && $request->has('to')) {
            $from = $request->input('from') ? date('Y-m-d', strtotime($request->input('from'))) : '00-00-0000';
            $to = date('Y-m-d', strtotime($request->input('to')));        
            $filter[] = ['kunjungan_tgl', '>=', $from];
            $filter[] = ['kunjungan_tgl', '<=', $to];
        } else {
            $month = date('m');
            $filter[] = [DB::raw('MONTH(kunjungan_tgl)'), '=', $month];
        }

        $kunjungan = Kunjungan::where('employees_id', $userId)
        ->where($filter)
        ->get();
        return view('partials.kunjungan_list', compact('kunjungan'));
    }
}
