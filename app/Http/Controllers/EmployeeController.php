<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Shift;
use App\Models\Building;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $employees = Employee::with ('position', 'shift', 'building')->get();
        return view('adminyofa.karyawan.index', compact('employees'));
    }

    public function userprofile()
    {
        $employees = Employee::with ('position', 'shift', 'building')->get();
        $positions = Position::orderBy('position_name', 'ASC')->get();
        $shifts = Shift::orderBy('shift_name', 'ASC')->get();
        $buildings = Building::orderBy('name', 'ASC')->get();
        return view('profile', compact('employees', 'positions', 'shifts', 'buildings'));
    }


    // Show the form for creating a new resource
    public function create()
    {
        $positions = Position::orderBy('position_name', 'ASC')->get();
        $shifts = Shift::orderBy('shift_name', 'ASC')->get();
        $buildings = Building::orderBy('name', 'ASC')->get();
        return view('adminyofa.karyawan.index', compact('positions', 'shifts', 'buildings'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'employees_code' => 'required|unique:employees',
            'employees_email' => 'required|email|unique:employees',
            'employees_password' => 'required',
            'employees_name' => 'required',
            'position_id' => 'required',  // Fixed typo from 'require' to 'required'
            'shift_id' => 'required',
            'building_id' => 'required',
            'photo' => 'nullable|image',  // The photo is nullable
            'created_login' => 'nullable|date',
            'created_cookies' => 'nullable'
        ]);
    
        // If validation fails, return errors as JSON
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()->all()
            ], 400);  // Return 400 Bad Request for validation errors
        }
    
        // Handle file upload (photo) if provided
        $filename = null;  // Default to null if no photo is uploaded
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $extension = $file->extension();
            $filename = time() . '.' . $extension;
            $file->storeAs('public/photos', $filename);  // Store the file in 'public/photos'
        }
    
        // Create a new employee record with hashed password
        $employee = \App\Models\Employee::create([
            'employees_code' => $request->input('employees_code'),
            'employees_email' => $request->input('employees_email'),
            'employees_password' => Hash::make($request->input('employees_password')),  // Hash the password
            'employees_name' => $request->input('employees_name'),
            'position_id' => $request->input('position_id'),
            'shift_id' => $request->input('shift_id'),
            'building_id' => $request->input('building_id'),
            'photo' => $filename,  // If no photo is uploaded, this will remain null
            'created_login' => $request->input('created_login'),
            'created_cookies' => $request->input('created_cookies')
        ]);
    
        // Return a success response with the employee data
        return response()->json([
            'status' => 'success',
            'message' => 'Employee created successfully.',
            'employee' => $employee
        ], 201);  // Return 201 Created status
    }
    
    

    // Display the specified resource
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    // Show the form for editing the specified resource
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    // Update the specified resource in storage
    public function update(Request $request)
    {
        try {
            $request->validate([
                // 'employees_name' => 'required|exists:employees,employees_name',
                'position_id' => 'required|exists:positions,position_id',
                'shift_id' => 'required|exists:shift,shift_id',
                'building_id' => 'required|exists:buildings,building_id',
                // 'photo' => 'nullable|image',
                'created_login' => 'nullable|date',
                'created_cookies' => 'nullable'
            ]);
    
            $employees = Employee::find(Auth::user()->id);
            if (!$employees) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employee not found.'
                ], 404);
            }
            $employees->employees_code = $request->input('employees_code');
            $employees->employees_name = $request->input('employees_name');
            $employees->position_id = $request->input('position_id');
            $employees->shift_id = $request->input('shift_id');
            $employees->building_id = $request->input('building_id');
            $employees->created_login = $request->input('created_login');
            $employees->created_cookies = $request->input('created_cookies');
    
            // Handle photo upload if applicable
            // if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            //     $file = $request->file('photo');
            //     $extension = $file->extension();
            //     $filename = time() . '.' . $extension;
            //     $file->storeAs('public/photos', $filename);
            //     $employees->photo = $filename;
            // }
    
            $employees->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Employee updated successfully.',
                'data' => $employees // Menyertakan data karyawan yang diperbarui
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'errors' => $e->validator->errors() // Menyertakan kesalahan validasi
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the employee.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePhoto(Request $request)
    {
        try {
            // Validasi file foto
            $request->validate([
                'photo' => 'required|image|max:2048', // Aturan validasi, bisa disesuaikan
            ]);
    
            $employees = Employee::find(Auth::user()->id);
            if (!$employees) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Employee not found.'
                ], 404);
            }
    
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
    
                if ($file->isValid()) {
                    $extension = $file->extension();
                    $filename = time() . '.' . $extension;
    
                    // Simpan foto di direktori yang diinginkan
                    $file->storeAs('public/photos', $filename);
                    $employees->photo = $filename;
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Uploaded file is not valid.'
                    ], 400);
                }
            }
    
            $employees->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Photo updated successfully.',
                'data' => $employees // Menyertakan data karyawan yang diperbarui
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'errors' => $e->validator->errors() // Menyertakan kesalahan validasi
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the photo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    
    

    // Remove the specified resource from storage
    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
            return response()->json('success', 200);
        }

        catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
