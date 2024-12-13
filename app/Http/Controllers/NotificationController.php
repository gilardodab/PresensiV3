<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\Employee;
use App\Notifications\SendNotification;

use App\Services\FirebaseService;

class NotificationController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function sendNotification()
    {
        // Retrieve all FCM tokens of employees
        $tokens = Employee::pluck('fcm_token')->toArray();

        $title = 'E-Presensi Yofa Group';
        $body = 'Jangan Lupa Presensi yaa .';
        $data = ['key' => 'value'];

        // Send notification to each token
        foreach ($tokens as $token) {
            $response = $this->firebaseService->sendNotification($token, $title, $body, $data);
            // Optionally, log or handle response
        }
        return response()->json($response);
    }
}
// class NotificationControllers extends Controller
// {
//     public function broadcastNotification()
//     {
//         $employees = Employee::whereNotNull('fcm_token')->get();  // Ambil semua employee yang memiliki fcm_token
//         $title = 'Pemberitahuan';
//         $body = 'Pemberitahuan';
    
//         foreach ($employees as $employee) {
//             // Menyimpan notifikasi ke dalam tabel Notification
//             Notification::create([
//                 'employee_id' => $employee->id,
//                 'title' => $title,
//                 'body' => $body
//             ]);
    
//             // Mengirimkan notifikasi kepada setiap employee
//             $employee->notify(new SendNotification($title, $body));
//         }
    
//         return response()->json(['message' => 'Notification sent successfully']);
//     }    

