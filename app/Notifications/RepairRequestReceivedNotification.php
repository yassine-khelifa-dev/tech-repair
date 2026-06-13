<?php

namespace App\Notifications;

use App\Mail\Repair\RepairRequestMail;
use App\Models\RepairRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RepairRequestReceivedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public RepairRequest $repair_request
    ) {
        //
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): RepairRequestMail
    {
        $mail = new RepairRequestMail($this->repair_request);

        $mail->to('admin@seven-tech.com');

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
            'id_repair_request' =>  $this->repair_request->id,
        ];
    }
}
