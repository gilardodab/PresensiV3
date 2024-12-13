<?php

namespace App\Jobs;

use App\Models\Employee;
use App\Services\FirebaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $firebaseService;

    /**
     * Create a new job instance.
     */
    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Mengambil semua token FCM dari tabel Employee
        $tokens = Employee::pluck('fcm_token')->toArray();

        // Memastikan ada token yang ditemukan
        if (empty($tokens)) {
            Log::warning('Tidak ada FCM token yang ditemukan untuk pengiriman notifikasi.');
            return;
        }

        $title = 'E-Presensi';
        $body = 'Jangan Lupa Presensi yaa.';
        $data = ['key' => 'value'];

        // Mengirimkan notifikasi ke setiap token
        foreach ($tokens as $token) {
            try {
                $response = $this->firebaseService->sendNotification($token, $title, $body, $data);
                // Log jika pengiriman berhasil
                Log::info('Notifikasi terkirim ke token: ' . $token);
            } catch (\Exception $e) {
                // Menangani error jika pengiriman gagal
                Log::error('Gagal mengirim notifikasi ke token: ' . $token . '. Error: ' . $e->getMessage());
            }
        }
    }

    /**
     * Tentukan jika job ini perlu diulang setelah gagal
     *
     * @return int
     */
    public function retryAfter()
    {
        // Mengatur delay antara retry (misalnya 2 menit)
        return 120;
    }
}
