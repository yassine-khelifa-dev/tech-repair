<?php

namespace App\Notifications;

use App\Mail\Repair\RepairLogMail;
use App\Models\RepairLog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RepairLogCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public RepairLog $log
    ) {}

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
    public function toMail(object $notifiable): RepairLogMail
    {
        $mail = new RepairLogMail(
            'New Log for ticket : ' . $this->log->ticket->ticket_number,
            $this->log
        );
        $mail->to($notifiable->email);

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
            'title' => 'New Log for ticket : ' . $this->log->ticket->ticket_number,
            'message' => $this->log->message,
            'repair_log_id' => $this->log->id,
            'repair_ticket_id' => $this->log->repair_ticket_id,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
