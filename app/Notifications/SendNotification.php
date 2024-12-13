<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmMessage;

class SendNotification extends Notification
{
    use Queueable;
    private $title;
    private $body;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $body)
    {
        //
        $this->title = $title;
        $this->body = $body;    
    }

    public function via($notifiable)
    {
        return ['firebase'];
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(['key' => 'value'])
            ->setNotification(
                \NotificationChannels\Fcm\Resources\Notification::create()
                    ->setTitle($this->title)
                    ->setBody($this->body)
                    
            );
    }
}
