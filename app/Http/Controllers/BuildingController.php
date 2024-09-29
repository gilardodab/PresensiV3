<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use RealRashid\SweetAlert\Facades\Alert;

class BuildingController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $buildings = Building::all();
        if (function_exists('confirmDelete')) {
            confirmDelete('Hapus shift', 'Apakah anda yakin ingin menghapus shift?');
        }
        return view('adminyofa.kantor.index', compact('buildings'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('adminyofa.kantor.index');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        function acakAngkaHuruf($panjang)
        {
            $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $string = '';
            for ($i = 0; $i < $panjang; $i++) {
                $pos = rand(0, strlen($karakter) - 1);
                $string .= $karakter[$pos];
            }
            return $string;
        }
    
        // Generate the code using the current year
        $year = now()->year;
        $code = 'YF' . acakAngkaHuruf(3) . '/' . $year;
    
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
        ]);
    
        // Combine latitude and longitude into one field
        $validatedData['code'] = $code;
        $validatedData['latitude_longtitude'] = $validatedData['latitude'] . ',' . $validatedData['longitude'];
    
        // Create the building using validated data
        Building::create($validatedData);
        Alert::success('Success', 'Lokasi Kantor Berhasil ditambahkan');
        // Redirect with success message
        return redirect()->route('adminyofa.kantor.index');
    }
    
    

    // Display the specified resource
    public function show(Building $building)
    {
        return view('adminyofa.kantor.show', compact('building'));
    }

    // Show the form for editing the specified resource
    public function edit(Building $building)
    {
        return view('adminyofa.kantor.edit', compact('building'));
    }
    
    // Update the specified resource in storage
    public function update(Request $request, Building $building)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:buildings,code,' . $building->id,
            'name' => 'required',
            'address' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric'
        ]);

        $building->update($validatedData);
        Alert::success('Update', 'Lokasi Kantor Berhasil diperbarui.');
        return redirect()->route('adminyofa.kantor.index');
    }

    // Remove the specified resource from storage
    public function destroy(Building $building)
    {
        try {
            // Cek apakah user memiliki level yang tidak sama dengan 2
            if (auth()->user()->level != 2) {
                // Cek apakah building ada sebelum menghapus
                if ($building) {
                    $building->delete();
                    Alert::success('Success', 'Lokasi Kantor Berhasil dihapus');
                } else {
                    return redirect()->route('adminyofa.kantor.index')->with('error', 'Bangunan tidak ditemukan.');
                }
            } else {
                // Jika user level 2, redirect dengan pesan error
                Alert::error('Error', 'Anda tidak diizinkan untuk menghapus Lokasi Kantor.');
                return redirect()->route('adminyofa.kantor.index');
            }
        } catch (\Exception $e) {
            // Tangkap semua pengecualian dan tampilkan pesan error
            Alert::error('Error', $e->getMessage());
            return redirect()->route('adminyofa.kantor.index');
        }
    
        // Redirect ke halaman index setelah proses selesai
        return redirect()->route('adminyofa.kantor.index');
    }
    
}
