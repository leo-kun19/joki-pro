<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;
use App\Models\User;
use App\Notifications\SendPushNotification;

class SendPushNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $title;
    public $body;
    public $image;
    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($title,$body,$image,$data )
    {
        $this->title = $title;
        $this->body = $body;
        $this->image = $image;
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable): FcmMessage
    {
        return (new FcmMessage(notification: new FcmNotification(
                title: $this->title,
                body: $this->body,
                image: $this->image
            )))
            ->data($this->data);
    }
}
