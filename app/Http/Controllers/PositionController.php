<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
// Display a listing of the resource
public function index()
{
    $jabatan = Position::withCount('employees')->get();
    $positions = Position::withCount('employees')->get();
    // dd($jabatans); // Tambahkan ini untuk debug
    return view('adminyofa.jabatan.index', compact('jabatan', 'positions'));
}


// Show the form for creating a new resource
public function create()
{
    return view('adminyofa.jabatan.index');
}

// Store a newly created resource in storage
public function store(Request $request)
{
    $validatedData = $request->validate([
        'position_name' => 'required|string|max:255'
    ]);

    Position::create($validatedData);

    return redirect()->route('adminyofa.jabatan.index')->with('success', 'Position created successfully.');
}

// Display the specified resource
public function show(Position $position)
{
    return view('adminyofa.jabatan.index', compact('position'));
}

// Show the form for editing the specified resource
public function edit(Position $position)
{
    return view('adminyofa.jabatan.index', compact('position'));
}

// Update the specified resource in storage
public function update(Request $request, Position $position)
{
    $validatedData = $request->validate([
        'position_name' => 'required|string|max:255'
    ]);

    $position->update($validatedData);

    return redirect()->route('adminyofa.jabatan.index')->with('success', 'Position updated successfully.');
}

// Remove the specified resource from storage
public function destroy(Position $position_id)
{
    $position_id->delete();

    return redirect()->route('adminyofa.jabatan.index')->with('success', 'Position deleted successfully.');
}
}
