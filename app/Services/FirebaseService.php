<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use Google_Client;
use GuzzleHttp\Client;


class FirebaseService
{
    protected $firebaseUrl = 'https://fcm.googleapis.com/v1/projects/absen-b0b44/messages:send';
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    // public function sendNotification($token, $title, $body, $data = [])
    // {
    //     $accessToken = $this->getAccessToken();

    //     $headers = [
    //         'Authorization' => 'Bearer ' . $accessToken,
    //         'Content-Type' => 'application/json',
    //     ];

    //     $payload = [
    //         'message' => [
    //             'token' => $token,
    //             'notification' => [
    //                 'title' => $title,
    //                 'body' => $body,
    //             ],
    //             'data' => $data,
    //         ],
    //     ];

    //     $response = $this->client->post($this->firebaseUrl, [
    //         'headers' => $headers,
    //         'json' => $payload,
    //     ]);

    //     return json_decode($response->getBody()->getContents(), true);
    // }

    public function sendNotification($token, $title, $body, $data = [])
{
    $accessToken = $this->getAccessToken();

    $headers = [
        'Authorization' => 'Bearer ' . $accessToken,
        'Content-Type' => 'application/json',
    ];

    $payload = [
        'message' => [
            'token' => $token,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => $data,
        ],
    ];

    try {
        $response = $this->client->post($this->firebaseUrl, [
            'headers' => $headers,
            'json' => $payload,
        ]);
        
        // Parse response from Firebase
        $responseBody = json_decode($response->getBody()->getContents(), true);
        
        if (isset($responseBody['error'])) {
            Log::error("Error sending notification: " . json_encode($responseBody['error']));
            return ['status' => 'error', 'message' => 'Failed to send notification'];
        }
        
        return $responseBody;
        
    } catch (\Exception $e) {
        Log::error("Exception while sending notification: " . $e->getMessage());
        return ['status' => 'error', 'message' => 'An error occurred while sending the notification'];
    }
}


    private function getAccessToken()
    {
        $googleClient = new Google_Client();
        $googleClient->setAuthConfig(storage_path('app/absen-b0b44-firebase-adminsdk-w5jxi-804d06ae0a.json'));
        $googleClient->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $token = $googleClient->fetchAccessTokenWithAssertion();

        return $token['access_token'];
    }
}

