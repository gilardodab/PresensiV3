<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendNotificationJob;
use App\Services\FirebaseService;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();


        // $schedule->call(function () {
        //     app(\App\Http\Controllers\NotificationController::class)->sendNotification();
        // })
        // ->dailyAt('14:58');
        // ->unlessBetween('Sunday', 'Sunday');


        $schedule->call(function () {
            // Dispatch job ke queue
            dispatch(new SendNotificationJob(new FirebaseService()));
        })->dailyAt('15:37');
        //  ->unlessBetween('Sunday', 'Sunday');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    
}
