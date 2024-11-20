<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Kunjungan;
use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class KunjunganController extends Controller
{
    //
    public function userindex(){
    $kunjungan = Kunjungan::all();
    return view('kunjungan', compact('kunjungan')) ;
    }

    public function unplan(){
        $salam_info = get_salam();
        $employeeId = auth()->user()->id;
        
        // Mengambil tanggal saat ini atau bisa juga dari inputan
        $date = Carbon::today()->toDateString(); // Atau bisa menggunakan $request->input('date');

        // Query Eloquent untuk mendapatkan data unplan
        $unplan = Kunjungan::where('employees_id', $employeeId)
                            ->where('kunjungan_tgl', $date)
                            ->select('employees_id', 'time_in')
                            ->first(); // Ambil satu hasil saja
                                               
        $building = Auth ::user()->building;
        return view('unplan', compact('unplan', 'building', 'salam_info'));
    }

    public function storeUnplan(Request $request)
    {
        // Validate input
        $request->validate([
            'webcam' => 'required',  // Validate webcam base64 string
            'latitude' => 'required',
        ]);
    
        // Get the current user and related employee data
        $user = Auth::user();
        $employee = Employee::with('shift', 'building')->where('id', $user->id)->first();
    
        // Get the start and end dates for the current week
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
    
        // Check if there are already 6 "UNPLAN" visits within the week
        $unplanCount = Kunjungan::where('employees_id', $user->id)
            ->whereBetween('kunjungan_tgl', [$startOfWeek, $endOfWeek])
            ->where('status_kunjungan', 'UNPLAN')
            ->count();
    
            if ($unplanCount >= 6) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda sudah mencapai batas maksimal kunjungan UNPLAN untuk minggu ini!'
                ], 403);
            }
            
    
        // Continue processing the image and saving the record
        $imageData = $request->input('webcam');
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
    
            // Determine filename and storage path
            $filename = now()->toDateString() . '-unplan-' . time() . '-' . $user->id . '.' . $type;
            $filePath = storage_path('app/public/kunjungan/' . $filename);
            file_put_contents($filePath, $imageData);
    
            // Save the visit data to the database
            Kunjungan::create([
                'employees_id' => $user->id,
                'kunjungan_tgl' => now()->toDateString(),
                'time_in' => now()->toTimeString(),
                'picture_in' => $filename,
                'latitude_longtitude_in' => $request->latitude,
                'status_kunjungan' => 'UNPLAN',
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Selamat "' . $employee->employees_name . '" berhasil Absen Masuk pada Tanggal ' . now()->toDateString() . ' dan Jam : ' . now()->toTimeString()
            ], 200);
        } else {
            return response()->json(['error' => 'Format base64 gambar tidak valid!'], 422);
        }
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

    public function loadDataKunjunganRiwayat(Request $request)
    {
        $userId = auth()->id(); // Ambil ID user yang login
        $filter = [];
    
        // Cek apakah input `from` dan `to` ada
        if ($request->has('from') && $request->has('to')) {
            $from = $request->input('from') ? date('Y-m-d', strtotime($request->input('from'))) : '1970-01-01';
            $to = $request->input('to') ? date('Y-m-d', strtotime($request->input('to'))) : date('Y-m-d');       
            $filter[] = ['kunjungan_tgl', '>=', $from];
            $filter[] = ['kunjungan_tgl', '<=', $to];
        } else {
            // Jika `from` dan `to` tidak ada, ambil data bulan ini
            $month = date('m');
            $filter[] = [DB::raw('MONTH(kunjungan_tgl)'), '=', $month];
            // $filter[] = [DB::raw('YEAR(kunjungan_tgl)'), '=', date('Y')];
        }
    
        // Filter data berdasarkan employee_id dan filter yang ditentukan
            $kunjungans = DB::table('kunjungan')
            ->where('employees_id', $userId)
            ->where($filter)
            ->orderBy('kunjungan_id', 'DESC')
            ->get();
    
            // dd($kunjungan); // Debugging, jika diperlukan
        
        // Kembalikan tampilan `partials.riwayat_kunjungan_list` dengan data
        return view('partials.riwayat_kunjungan_list', compact('kunjungans'));
    }
    
    

    public function selfiekunjungan($kunjungan_id)
    {
        // Dekripsi kunjungan_id
        try {
            $kunjungan = epm_decode($kunjungan_id);
        } catch (\Exception $e) {
            // Tangani error jika terjadi kegagalan dekripsi
            return redirect()->route('error.page')->with('error', 'Invalid ID');
        }
    
        return view('masuk_kunjungan', compact('kunjungan'));
    }
    


    public function storeKunjungan(Request $request)
    {
        $kunjungan_id = $request->input('kunjungan_id'); 
    
        $request->validate([
            'webcam' => 'required',
            'latitude' => 'required',
        ]);
    
        $imageData = $request->input('webcam');
        $user = Auth::user();
        $employee = Employee::with('shift', 'building')->where('id', $user->id)->first();
        $kunjungan = Kunjungan::where('employees_id', $employee->id)
            ->where('kunjungan_tgl', now()->toDateString())
            ->where('kunjungan_id', $kunjungan_id)
            ->first();
            
            
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $type = strtolower($type[1]);
    
            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                return response()->json(['error' => 'Format gambar tidak valid!'], 422);
            }
    
            $imageData = base64_decode($imageData);
    
            if ($imageData === false) {
                return response()->json(['error' => 'Base64 decode gagal!'], 422);
            }
    
            if ($kunjungan) {
                if ($kunjungan->time_in == '00:00:00' ||$kunjungan->time_in == '' ) {
                    $filename = now()->toDateString() . '-kunjungan-' . time() . '-' . Auth::id() . '.' . $type;
                    $filePath = storage_path('app/public/kunjungan/' . $filename);
                    file_put_contents($filePath, $imageData);
    
                    $kunjungan->update([
                        'time_in' => now()->toTimeString(),
                        'picture_in' => $filename,
                        'latitude_longtitude_in' => $request->latitude,
                        'status_kunjungan' => 'Selesai'
                    ]);
    
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Selamat "' . $employee->employees_name . '" berhasil Absen Tempat pada Tanggal ' . now()->toDateString() . ' dan Jam : ' . now()->toTimeString()
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Anda sudah melakukan absen tempat pada Tanggal ' . now()->toDateString() . ' dan Jam ' . $kunjungan->time_in . '.'
                    ], 400);
                }
            }
            
            return response()->json(['status' => 'success', 'message' => 'Absensi berhasil disimpan.'], 200);
        } else {
            return response()->json(['error' => 'Format base64 gambar tidak valid!'], 422);
        }
    }

    //admin
    public function index(){
        $employees = Employee::with('position', 'shift', 'building')->get();
        $positions = Position::all();
        return view('adminyofa.kunjungan.index', compact('employees', 'positions'));
    }
    public function loadDataKunjunganAdmin(Request $request){
        $id = $request->input('id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // If no date range is provided, default to the current month
        if (!$startDate || !$endDate) {
            $currentDate = now(); // current date and time
            $startDate = $currentDate->copy()->startOfMonth()->format('Y-m-d'); // first day of the current month
            $endDate = $currentDate->format('Y-m-d'); // today's date
        }
    
        $query = Kunjungan::query();
    
        if ($id) {
            $query->where('employees_id', $id);
        }
    
        if ($startDate && $endDate) {
            $query->whereBetween('kunjungan_tgl', [$startDate, $endDate]);
        }
    
        $kunjungans = $query->get();
        return view('adminyofa.kunjungan.partials.kunjungan_table', compact('kunjungans'));
    }
    
}
