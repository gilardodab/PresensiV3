<?php

namespace App\Providers;
use App\Models\User;
use App\Models\Presence;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Shift;
use App\Models\Building;
use App\Models\Cuty;
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
            $user = User::first();
            $presence = Presence::all();
            $month = date('m');
            $year = date('Y');
            $employeeCount = Employee ::count();
            $positionCount = Position::count();
            $shiftCount = Shift::count();
            $buildingCount = Building::count();
            $absentDay  = Presence::with('employee')->get();
            $cutyRequests  = Cuty::with('employees')->get();
            // $userId = auth()->user()->id;
            $cuti = Cuty::all();
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
        });
    }
}
