<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $shifts = Shift::all();
        return view('adminyofa.shifts.index', compact('shifts'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('shifts.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'shift_name' => 'required|string|max:255',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        // Jika validasi gagal, kembalikan pesan kesalahan
        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 400);
        }

        try {
            // Membuat shift baru
            $shift = new Shift();
            $shift->shift_name = $request->shift_name;
            $shift->time_in = $request->time_in;
            $shift->time_out = $request->time_out;
            $shift->save();

            // Mengembalikan respon sukses
            return response()->json('success', 200);
        } catch (\Exception $e) {
            // Mengembalikan respon error jika terjadi kesalahan
            return response()->json($e->getMessage(), 500);
        }
    }

    // Mengupdate shift
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'shift_name' => 'required|string|max:255',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 400);
        }

        try {
            // Cari shift berdasarkan ID dan update
            $shift = Shift::findOrFail($id);
            $shift->shift_name = $request->shift_name;
            $shift->time_in = $request->time_in;
            $shift->time_out = $request->time_out;
            $shift->save();

            return response()->json('success', 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    // Menghapus shift
    public function destroy($id)
    {
        try {
            $shift = Shift::findOrFail($id);
            $shift->delete();

            return response()->json('success', 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    // Display the specified resource
    // public function show(Shift $shift)
    // {
    //     return view('shifts.show', compact('shift'));
    // }

    // Show the form for editing the specified resource
    public function edit(Shift $shift)
    {
        return view('shifts.edit', compact('shift'));
    }


}
