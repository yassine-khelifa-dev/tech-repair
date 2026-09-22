<?php

namespace App\Notifications;

use App\Mail\Repair\RepairRequestReviewedMail;
use App\Models\RepairRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RepairRequestReviewedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public RepairRequest $repair_request
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): RepairRequestReviewedMail
    {
        $mail  = new RepairRequestReviewedMail($this->repair_request);
        $mail->to($notifiable->routeNotificationFor('mail'));

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
