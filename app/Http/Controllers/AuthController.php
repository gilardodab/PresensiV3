<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Position;
use App\Models\Shift;
use App\Models\Building;
use App\Models\Employee;
use App\Models\Presence;
use App\Models\Cuty;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class AuthController extends Controller
{
    // proses login admin
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showLoginFormadmin()
    {
        return view('auth.loginadmin');
    }

    public function create()
    {
        // Fetch positions, shifts, and buildings from the database to populate the dropdowns
        $positions = Position::orderBy('position_name', 'ASC')->get();
        $shifts = Shift::orderBy('shift_name', 'ASC')->get();
        $buildings = Building::orderBy('name', 'ASC')->get();

        return view('auth.register', compact('positions', 'shifts', 'buildings'));
    }

    // Handle form submission and employee registration
    public function store(Request $request)
    {
        // Validate form inputs
        $validator = Validator::make($request->all(), [
            'employees_code' => 'required|string|max:255|unique:employees', // Ensure unique NIK
            'employees_name' => 'required|string|max:255',
            'employees_email' => 'required|email|unique:employees,email', // Ensure unique email
            'employees_password' => 'required|string|min:8',
            'position_id' => 'required|exists:positions,id', // Ensure the position exists
            'shift_id' => 'required|exists:shifts,id', // Ensure the shift exists
            'building_id' => 'required|exists:buildings,id', // Ensure the building exists
        ]);

        // Redirect back with errors if validation fails
        if ($validator->fails()) {
            return redirect()->route('register.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Create a new Employee
        $employee = Employee::create([
            'employees_code' => $request->employees_code,
            'employees_name' => $request->employees_name,
            'employees_email' => $request->employees_email,
            'employees_password' => Hash::make($request->employees_password), // Hash the password
            'position_id' => $request->position_id,
            'shift_id' => $request->shift_id,
            'building_id' => $request->building_id,
        ]);

        // Redirect to a success page or employee list after successful registration
        return redirect()->route('register.create')->with('success', 'Employee registered successfully!');
    }

    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        // Check if an employee with the provided email exists
        $employee = Employee::where('employees_email', $request->email)->first();
    
        // If employee is found and password matches, log them in
        if ($employee && Hash::check($request->password, $employee->employees_password)) {
            // Log in the employee using the 'employee' guard
            Auth::guard('employee')->login($employee);
    
            // Return JSON success response for AJAX
            return response()->json(['status' => 'success', 'message' => 'Login successful'], 200);
        }
    
        // Return error message if credentials are incorrect
        // return response()->json(['status' => 'error', 'message' => 'Invalid credentials'], 401);
        return response()->json(['status' => 'error', 'message' => 'Email atau password salah'], 401);

    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registeradmin(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        Auth::login($user);

        return redirect('dashboard');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:40'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'fullname' => ['required', 'string', 'max:40'],
        ]);
    }

    protected function createadmin(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'fullname' => $data['fullname'],
            'level' => $data['level'],
            'registered' => now(),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        // dd(Auth::guard('employee')->logout());
        return redirect('/');
    }

    //name old prosesloginadmin
    public function prosesloginadmin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $credentials = $request->only('username', 'password');
        
        // Debug: Check the incoming request credentials
        Log::info('Login attempt with:', $credentials);
    
        if (Auth::guard('user')->attempt($credentials)) {
            // Authentication passed
            $user = Auth::guard('user')->user();
            $request->session()->regenerate();
    
            if ($user->status == '0') {
                Auth::guard('user')->logout();
                return response()->json(['response' => ['error' => '2']]);
            }
    
            $request->session()->put('user', $user);
            return response()->json(['response' => ['error' => '1']]);
        }
    
        // Log failed attempt
        Log::warning('Login failed for credentials:', $credentials);
        return response()->json(['response' => ['error' => '0']]);
    }
    
    
    

    //logout
    public function logoutadmin(Request $request)
    {
        Auth::guard('user')->logout(); // Ensure the correct guard is used
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/loginadmin');
    }
    

    public function dashboard()
    {
        $employeeCount = Employee::count();
        $positionCount = Position::count();
        $shiftCount = Shift::count();
        $buildingCount = Building::count();
        $user = User::first();
        $absentDay  = Presence::with('employee')->get();
        $cutyRequests  = Cuty::with('employees')->get();
        return view('adminyofa.dashboard', compact('employeeCount', 'user', 'positionCount', 'shiftCount', 'buildingCount','absentDay','cutyRequests'));
    }

    public function useradmin(){
        $op = request()->get('op');
        $users = DB::table('users')
            ->join('user_level', 'users.level', '=', 'user_level.level_id') // Join user_level based on user.level
            ->select('users.user_id', 'users.username', 'users.fullname', 'users.email', 'users.registered', 'users.level', 'user_level.level_id', 'user_level.level_name') // Select specific columns
            ->orderBy('users.user_id', 'DESC') // Order by user_id descending
            ->get(); // Execute the query and retrieve the results

        $levels = DB::table('user_level')->get();
        return view('adminyofa.user.index', compact('users', 'op', 'levels'));
    }
}
