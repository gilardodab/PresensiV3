<?php

namespace App\Providers;
use App\Models\User;
use App\Models\Presence;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Shift;
use App\Models\Building;
use App\Models\Cuty;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //view global user 
        View::composer('*', function ($view) {
            date_default_timezone_set('Asia/Jakarta');
            $date     = DATE('Y-m-d');
            $day      = DATE('d');
            $day_en   = DATE('l');
            $month_en = DATE('F');
            $month    = DATE('m');
            $year     = DATE('Y');
            $time     = DATE('H:i:s');
            $timeNow  = DATE('Y-m-d H:i:s');
            $today = now()->toDateString();
            $currentMonth = now()->month;
            $currentYear = now()->year;
            $user = User::first();
            // $presence = Presence::all();
            $presence = Presence::whereDate('presence_date', $today)->get();
            $month = date('m');
            $year = date('Y');
            $employeeCount = Employee ::count();
            $positionCount = Position::count();
            $shiftCount = Shift::count();
            $buildingCount = Building::count();
            $absentDay  = Presence::with('employee')->whereDate('presence_date', $today)->get();
            $cutyRequests = Cuty::with('employees')
                            ->whereMonth('cuty_start', $currentMonth)
                            ->whereYear('cuty_start', $currentYear)
                            ->get();
            // $userId = auth()->user()->id;
            // $cuti = Cuty::all();
            // Mengambil data cuty dengan cuty_status = 3
            $cuti = Cuty::where('cuty_status', 3)->get();
            $settings = Setting::where('id', '1'); // Ambil satu data pengaturan
            $view->with('user', $user);
            $view->with('presence', $presence);
            $view->with('cuti', $cuti);
            $view->with('month', $month);
            $view->with('year', $year);
            $view->with('employeeCount', $employeeCount);
            $view->with('positionCount', $positionCount);
            $view->with('shiftCount', $shiftCount);
            $view->with('buildingCount', $buildingCount);
            $view->with('absentDay', $absentDay);
            $view->with('cutyRequests', $cutyRequests);
            $view->with('settings', $settings);
            $view->with('date', $date);
            $view->with('day', $day);
            $view->with('day_en', $day_en);
            $view->with('month_en', $month_en);
            $view->with('time', $time);
            $view->with('timeNow', $timeNow);

        });
    }
}
