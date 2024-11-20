<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Presence;
use App\Models\PresentStatus;
use App\Models\Position;
use App\Models\Shift;
use App\Models\Cuty;
use App\Models\Building;
use App\Models\User;
use App\Models\Employee;
use Carbon\Carbon;

class PresenceController extends Controller
{
    //
    // public function index()
    // {
    //     $employees = Employee::with('position', 'shift', 'building')->get();
    //     $month_en = Carbon::now()->locale('en')->monthName;
        
    //     // Dapatkan nilai bulan dan tahun saat ini sebagai default
    //     $currentMonth = Carbon::now()->format('m'); 
    //     $currentYear = Carbon::now()->format('Y'); 
    
    //     // Ambil parameter dari request, jika tidak ada gunakan default bulan dan tahun saat ini
    //     $op = request()->get('op');
    //     $id = request()->get('id');
    //     $month = request()->get('month', $currentMonth);  // Gunakan bulan saat ini jika tidak ada
    //     $year = request()->get('year', $currentYear);     // Gunakan tahun saat ini jika tidak ada
    
    //     if ($op == 'views') {
    //         // Ambil data karyawan berdasarkan ID
    //         $employees = Employee::with('position', 'shift', 'building')->find($id);
    
    //         if (!$employees) {
    //             return response()->json(['message' => 'Employee not found'], 404);
    //         }
    
    //         // Ambil presensi karyawan berdasarkan bulan dan tahun
            
    //         $presences = Presence::where('employees_id', $employees->id)
    //                             ->whereMonth('presence_date', $month)
    //                             ->whereYear('presence_date', $year)
    //                             ->get();
    
    //         // if ($presences->isEmpty()) {
    //         //     return response()->json(['message' => 'Presences not found'], 404);
    //         // }
    
    //         $shift = $employees->shift; // Ambil shift dari relasi
    
    //         return view('adminyofa.absensi.index', compact('employees', 'presences', 'shift', 'op', 'id', 'month_en', 'month', 'year'));
    //     } else {
    //         // Jika $op bukan 'views', ambil semua karyawan
    //         $employees = Employee::with('position', 'shift', 'building')->get();
    
    //         if ($employees->isEmpty()) {
    //             return response()->json(['message' => 'Employees not found'], 404);
    //         }
    
    //         return view('adminyofa.absensi.index', compact('employees', 'op', 'id', 'month_en', 'currentMonth', 'currentYear'));
    //     }
    // }

    public function index(){
        $employees = Employee::with('position', 'shift', 'building')->get();
        $positions = Position::all();
        return view('adminyofa.absensi.index', compact('employees', 'positions'));
    }

    public function loadDataAbsen(Request $request)
    {
        $id = $request->input('id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // If no date range is provided, default to the current month
        if (!$startDate || !$endDate) {
            $currentDate = now(); // current date and time
            $startDate = $currentDate->copy()->startOfMonth()->format('Y-m-d'); // first day of the current month
            $endDate = $currentDate->format('Y-m-d'); // today's date
        }
    
        $query = Presence::query();
    
        if ($id) {
            $query->where('employees_id', $id);
        }
    
        if ($startDate && $endDate) {
            $query->whereBetween('presence_date', [$startDate, $endDate]);
        }
    
        $presences = $query->get();
        return view('adminyofa.absensi.partials.absensi_table', compact('presences'));
    }
    
    
    
    public function showMap(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $name = $request->input('name');

        return view('adminyofa.absensi.maps', compact('latitude', 'longitude', 'name'));
    }
    

    public function userindex(){
        $salam_info = get_salam();
        $employeeId = auth()->user()->id;
        
        // Mengambil tanggal saat ini atau bisa juga dari inputan
        $date = Carbon::today()->toDateString(); // Atau bisa menggunakan $request->input('date');

        // Query Eloquent untuk mendapatkan data presence
        $presence = Presence::where('employees_id', $employeeId)
                            ->where('presence_date', $date)
                            ->select('employees_id', 'time_in', 'time_out')
                            ->first(); // Ambil satu hasil saja
                            $hasCheckedIn = $presence ? true : false;                    
        $building = Auth ::user()->building;
        return view('absent', compact('presence', 'building', 'hasCheckedIn', 'salam_info'));
        // if ($presence) {
        //     return response()->json([
        //         'status' => 'success',
        //         'data' => $presence
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'No presence data found for today'
        //     ]);
        // }
    }

    public function userindexhistory(){
        $presences = Presence::all();
        $building = Auth ::user()->building;
        $presentStatuses = PresentStatus::orderBy('present_name', 'ASC')->get();
        return view('history', compact('presences', 'building', 'presentStatuses'));
    }

    public function storeAbsence(Request $request)
{
    // Validasi input
    $request->validate([
        'webcam' => 'required',  // Validasi webcam base64 string
        'latitude' => 'required',
        // 'radius' => 'required',
    ]);

    // Mendekode base64 menjadi file gambar
    $imageData = $request->input('webcam');
    $user = Auth::user();
    $employee = Employee::with('shift', 'building')->where('id', $user->id)->first();
    $presence = Presence::where('employees_id', $employee->id)
    ->where('presence_date', now()->toDateString())
    ->first();
    
    // Pastikan data base64 valid
    if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
        $imageData = substr($imageData, strpos($imageData, ',') + 1);
        $type = strtolower($type[1]); // jpg, png, gif

        if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
            return response()->json(['error' => 'Format gambar tidak valid!'], 422);
        }

        $imageData = base64_decode($imageData);

        if ($imageData === false) {
            return response()->json(['error' => 'Base64 decode gagal!'], 422);
        }
        if ($presence) {
            if ($presence->time_out == '00:00:00') {
                // Update absensi pulang
                         // Tentukan nama file dan path penyimpanan
            $filename = now()->toDateString() . '-out-' . time() . '-' . Auth::id() . '.' . $type;
            $filePath = storage_path('app/public/absent/' . $filename);
                $presence->update([
                    'time_out' => now()->toTimeString(),
                    'picture_out' => $filename,
                    'latitude_longtitude_out' => $request->latitude,
                ]);
                // Simpan gambar
 
                return response()->json([
                    'status' => 'success',
                    'message' => 'Selamat "' . $employee->employees_name . '" berhasil Absen Pulang pada Tanggal ' . now()->toDateString() . ' dan Jam : ' . now()->toTimeString()
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda sudah melakukan absen pulang pada Tanggal ' . now()->toDateString() . ' dan Jam ' . $presence->time_out . '.'
                ], 400);
            }
        } else {

            $filename = now()->toDateString() . '-in-' . time() . '-' . Auth::id() . '.' . $type;
            $filePath = storage_path('app/public/absent/' . $filename);
        // Simpan gambar ke direktori
        file_put_contents($filePath, $imageData);

        // Simpan data absensi ke database atau lakukan logika lainnya
        // Contoh menyimpan absensi:
        Presence::create([
            'employees_id' => Auth::id(),
            'presence_date' => now()->toDateString(),
            'time_in' => now()->toTimeString(),
            'time_out' => '00:00:00',
            'picture_in' => $filename,
            'latitude_longtitude_in' => $request->latitude,
            'present_id' => 1,  // 1 untuk hadir
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Selamat "' . $employee->employees_name . '" berhasil Absen Masuk pada Tanggal ' . now()->toDateString() . ' dan Jam : ' . now()->toTimeString()
        ], 200);
    }

        return response()->json(['status' => 'success', 'message' => 'Absensi berhasil disimpan.'], 200);
    } else {
        return response()->json(['error' => 'Format base64 gambar tidak valid!'], 422);
    }
}


    // Show the form for creating a new resource
    public function create()
    {
        return view('presences.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employees_id' => 'required|exists:employees,id',
            'presence_date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
            'picture_in' => 'nullable|string',
            'picture_out' => 'nullable|string',
            'present_id' => 'required|in:Masuk,Pulang,Tidak Hadir',
            'latitude_longtitude_in' => 'nullable|string',
            'latitude_longtitude_out' => 'nullable|string',
            'information' => 'nullable|string'
        ]);

        Presence::create($validatedData);

        return redirect()->route('presences.index')->with('success', 'Presence record created successfully.');
    }

    // Display the specified resource
    public function show($id)
    {
        $employee = Employee::with('position')->find($id);
        if (!$employee) {
            return redirect()->route('absensi.index')->with('error', 'Data karyawan tidak ditemukan');
        }

        return view('adminyofa.absensi.detail', compact('employee'));
    }

    // Show the form for editing the specified resource
    public function edit(Presence $presence)
    {
        return view('presences.edit', compact('presence'));
    }

    // Update the specified resource in storage
    public function update(Request $request, Presence $presence)
    {
        $validatedData = $request->validate([
            'employees_id' => 'required|exists:employees,id',
            'presence_date' => 'required|date',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
            'picture_in' => 'nullable|string',
            'picture_out' => 'nullable|string',
            'present_id' => 'required|in:Masuk,Pulang,Tidak Hadir',
            'latitude_longtitude_in' => 'nullable|string',
            'latitude_longtitude_out' => 'nullable|string',
            'information' => 'nullable|string'
        ]);

        $presence->update($validatedData);

        return redirect()->route('presences.index')->with('success', 'Presence record updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(Presence $presence)
    {
        $presence->delete();

        return redirect()->route('presences.index')->with('success', 'Presence record deleted successfully.');
    }

    public function loadData(Request $request)
    {
        $userId = auth()->id(); // Get the logged-in user's ID
        $filter = [];

        if ($request->has('from') && $request->has('to')) {
            $from = $request->input('from') ? date('Y-m-d', strtotime($request->input('from'))) : '00-00-0000'; 
            $to = date('Y-m-d', strtotime($request->input('to'))); 
            $filter[] = ['presence_date', '>=', $from];
            $filter[] = ['presence_date', '<=', $to];
        } else {
            $month = date('m');
            $filter[] = [DB::raw('MONTH(presence_date)'), '=', $month];
        }

        $shift = Shift::where('shift_id', auth()->user()->shift_id)->first();
        $shift_time_in = $shift->time_in;
        $shift_time_out = $shift->time_out;
        $hadir = Presence::where('present_id', 1)->where($filter)->count();
        $telat = Presence::where('present_id', 1)->where('time_in', '>', '08:00:00')->where($filter)->count();
        $sakit = Presence::where('present_id', 2)->where($filter)->count();
        $izin = Presence::where('present_id', 3)->where($filter)->count();
        
        $absences = Presence::with('presentStatus')
            ->select('*', DB::raw("
                TIMEDIFF(TIME(time_in), '$shift_time_in') AS selisih,
                IF(time_in > '$shift_time_in', 'Telat', IF(time_in = '00:00:00', 'Tidak Masuk', 'Tepat Waktu')) AS status,
                IF(time_out < '$shift_time_out', 'Pulang Cepat', 'Tepat Waktu') AS status_pulang
            "))
            ->where('employees_id', $userId)
            ->where($filter)
            ->orderBy('presence_id', 'DESC')
            ->get();

        return view('partials.history_table', compact('absences', 'hadir', 'sakit', 'izin', 'telat'));
    }

    // public function loadDataadmin( Request $request)
    // {
    //     $id = $request->get('id'); // Get the ID from the request
    //     $employee = Employee::find($id);
    //     $shift = Shift::find($employee->shift_id);
    //     // Fetch the data from the Presence model based on the ID
    //     $presenceData = Presence::where('employees_id', $id)->first();

    //     // Assuming you'll render a partial view with the data
    //     if ($presenceData) {
    //         return view('adminyofa.absensi.partials.absensi_table', compact('presenceData', 'shift'));
    //     } else {
    //         return response()->json(['message' => 'Data not found'], 404);
    //     }
    // }

    public function updateHistory(Request $request)
    {
        $presenceId = $request->input('presence_id');

        // Validasi input
        $request->validate([
            'present_id' => 'required|exists:present_status,present_id',
            'information' => 'nullable|string',
        ]);

        // Update data presensi
        $presence = Presence::find($presenceId);
        $presence->present_id = $request->input('present_id');
        $presence->information = $request->input('information');
        $presence->save();

        return response()->json(['status' => 'success']);
    }
}
