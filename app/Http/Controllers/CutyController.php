<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Notification;


use App\Services\FirebaseService;
use App\Models\Cuty;

class CutyController extends Controller
{
    //
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }
    public function index()
    {
        $cuties = Cuty::with ('employees')->get();
        return view('adminyofa.cuti.index', compact('cuties'));
    }

    public function userindex()
    {
        $cuties = Cuty::all();
        return view('cuty', compact('cuties'));
    }

    public function loadDataCuty( Request $request){
        $userId = auth()->id(); // Get the logged-in user's ID
        $filter = [];

        if ($request->has('from') && $request->has('to')) {
            $from = $request->input('from') ? date('Y-m-d', strtotime($request->input('from'))) : '00-00-0000';
            $to = date('Y-m-d', strtotime($request->input('to')));        
            $filter[] = ['cuty_start', '>=', $from];
            $filter[] = ['cuty_start', '<=', $to];
        } else {
            $month = date('m');
            $filter[] = [DB::raw('MONTH(cuty_start)'), '=', $month];
        }

        $cuties = Cuty::where('employees_id', $userId)
        ->where($filter)
        ->get();
        return view('partials.cuty_list', compact('cuties'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('cuties.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     // 'employees_id' => 'required|exists:employees_id',
        //     'cuty_start' => 'required|date',
        //     'cuty_end' => 'required|date',
        //     'date_work' => 'required|date',
        //     'cuty_total' => 'required|integer',
        //     'cuty_description' => 'nullable|string',
        //     // 'cuty_status' => 'required|string|max:255'
        // ]);
        $request->validate([
            'cuty_start' => 'required|date',
            'cuty_end' => 'required|date',
            'date_work' => 'required|date',
            'cuty_total' => 'required|integer',
            'cuty_description' => 'nullable|string',
        ]);
    
        try {
            // Cuty::create($validatedData);
            Cuty::create([
                'employees_id' => Auth::id(),
                'cuty_start' => $request->cuty_start,
                'cuty_end' => $request->cuty_end,
                'date_work' => $request->date_work,
                'cuty_total' => $request->cuty_total,
                'cuty_description' => $request->cuty_description,
                'cuty_status' => 3,  
            ]);
    
            return response()->json(['status' => 'success', 'message' => 'Cuty created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    
    

    // Display the specified resource
    public function show(Cuty $cuty)
    {
        return view('cuties.show', compact('cuty'));
    }

    // Show the form for editing the specified resource
    public function edit(Cuty $cuty)
    {
        return view('cuties.edit', compact('cuty'));
    }

    // Update the specified resource in storage
    public function update(Request $request)
    {
        // Correct the request data
        $CutyId = $request->input('cuty_id'); 
    
        // Correct validation rules
        $request->validate([
            'cuty_id' => 'required|exists:cuty,cuty_id', // exists on the cuty table
            'cuty_start' => 'required|date',
            'cuty_end' => 'required|date',
            'date_work' => 'required|date',
            'cuty_total' => 'required|integer',
            'cuty_description' => 'nullable|string',
        ]);
    
        try {
            // Find the Cuty record
            $cuty = Cuty::find($CutyId);
            if (!$cuty) {
                return response()->json(['status' => 'error', 'message' => 'Cuty not found.'], 404);
            }
    
            // Update the record
            $cuty->cuty_start = Carbon::createFromFormat('d-m-Y', $request->cuty_start)->format('Y-m-d');
            $cuty->cuty_end = Carbon::createFromFormat('d-m-Y', $request->cuty_end)->format('Y-m-d');
            $cuty->date_work = Carbon::createFromFormat('d-m-Y', $request->date_work)->format('Y-m-d');
            $cuty->cuty_total = $request->cuty_total;
            $cuty->cuty_description = $request->cuty_description;
            $cuty->save();
    
    
            return response()->json(['status' => 'success', 'message' => 'Cuty updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required|exists:cuty,cuty_id',
            'status' => 'required',
        ]);
    
        try {
            // Cari data cuti
            $cuty = Cuty::find($request->id);
            if (!$cuty) {
                return response()->json(['status' => 'error', 'message' => 'Cuti tidak ditemukan.'], 404);
            }
    
            // Update status cuti
            $cuty->cuty_status = $request->status;
            $cuty->save();
    
            // Ambil semua token 
            $employee = Employee::find($cuty->employees_id);

            if (!$employee || !$employee->fcm_token) {
                return response()->json(['status' => 'error', 'message' => 'Employee FCM token not found.'], 404);
            }
            // $tokens = Employee::pluck('fcm_token')->toArray();
            $token = $employee->fcm_token;
            $title = 'Permohonan Cuti Yofa Group';
            
            // Tentukan pesan body berdasarkan status
            if ($request->status == 1) {
                $body = 'Yeayy 😍, Cuti Anda Telah  Disetujui. Selamat Menikmati Hari Cuti Anda';
                Notification::create([
                    'employee_id' => $employee->id,
                    'title' => $title,
                    'body' => $body
                ]);
            } elseif ($request->status == 2) {
                $body = 'Maaf Cuti Anda Ditolak 😥. Silahkan Hubungi Admin HR Untuk Info Lebih Lanjut.';
                Notification::create([
                    'employee_id' => $employee->id,
                    'title' => $title,
                    'body' => $body
                ]);
            } else {
                $body = 'Cuti Anda Telah Di Respon.';
            }
    
            $data = ['key' => 'value'];  // Data tambahan (jika diperlukan)
    
            // Kirim notifikasi ke setiap token
            $response = null;
                $response = $this->firebaseService->sendNotification($token, $title, $body, $data);
                // Optionally, log or handle response
                // Misalnya log jika perlu
                Log::info("Notification sent to token: $token with response: " . json_encode($response));
            // Jika sukses mengirim notifikasi, kembalikan respons sukses
            return response()->json(['status' => 'success', 'message' => 'Cuty status updated and notifications sent successfully.']);
            
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    

    public function print($id)
    {
        $cuty = Cuty::with('employeess')->where('cuty_id', $id)->first();
        if (!$cuty) {
            return redirect()->back()->with('error', 'Cuti tidak ditemukan.');
        }
    
        return view('adminyofa.cuti.print', compact('cuty'));
    }
    
    

    // Remove the specified resource from storage
    public function destroy(Cuty $cuty)
    {
        $cuty->delete();

        return redirect()->route('cuties.index')->with('success', 'Cuty deleted successfully.');
    }
}
