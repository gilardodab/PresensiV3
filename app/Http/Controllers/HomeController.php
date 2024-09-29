<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\helpers;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Models\Presence;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $salam_info = get_salam();
        $building = Employee::with('building')->get();
        $currentMonth = Carbon::now()->month; // Mendapatkan bulan saat ini (1-12)
        $currentYear = Carbon::now()->year;   // Mendapatkan tahun saat ini
        date_default_timezone_set('Asia/Jakarta');
        $date     = DATE('Y-m-d');
        $month    = DATE('m');
        // dd ($building);
        // $employee = Auth::employee();
        // dd ($employee);
        // $employeeId = Auth::user()->id;

        // Dapatkan data presensi dari join antara tabel 'presence', 'employees', dan 'buildings'
        $employeeId = $request->user()->id;
        $date = Carbon::now()->toDateString();
        
        // Ambil satu data kehadiran berdasarkan employees_id dan tanggal
        $presences = Presence::where('employees_id', $employeeId)
                            ->where('presence_date', $date)
                            ->get();  // Menggunakan first() untuk satu objek, bukan collection

        $attendances = DB::select(
                                'SELECT presence_date, time_in, time_out 
                                 FROM presence 
                                 WHERE MONTH(presence_date) = :month AND employees_id = :employees_id
                                 ORDER BY presence_id DESC 
                                 LIMIT 6',
                                [
                                    'month' => $month,
                                    'employees_id' => $employeeId,
                                ]
                            );
        return view('home', compact('user', 'building', 'currentMonth', 'currentYear','presences', 'attendances', 'salam_info'));
    }

    public function dashboardadmin(){
        $user = Auth::user();
        $employeeCount = Employee ::count();
        $absentDay  = Presence::with('employee')->get();
        dd($absentDay);
        return view('adminyofa.dashboard', compact('employeeCount', 'user', 'absentDay'));
    }

    public function loadHomeCounter(Request $request)
    {
        $month_filter = $request->input('month_filter') ?? date('m');
        $year = date('Y');
        $userId = auth()->user()->id; // Dapatkan ID pengguna yang sedang login

        $filter = [
            ['employees_id', '=', $userId],
            [DB::raw('MONTH(presence_date)'), '=', $month_filter],
            [DB::raw('YEAR(presence_date)'), '=', $year]
        ];

        $hadir = Presence::where($filter)->where('present_id', 1)->count();
        $sakit = Presence::where($filter)->where('present_id', 2)->count();
        $izin = Presence::where($filter)->where('present_id', 3)->count();

        $shift = Shift::where('shift_id', auth()->user()->shift_id)->first();
        $shift_time_in = $shift->time_in;
        $newtimestamp = date('H:i:s', strtotime($shift_time_in . ' + 5 minutes'));

        $telat = Presence::where($filter)->where('time_in', '>', $shift_time_in)->count();

        // Kembalikan ke view partial Blade
        return view('partials.load-home', compact('hadir', 'sakit', 'izin', 'telat'));
    }
}
