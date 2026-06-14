<?php

namespace App\Notifications;

use App\Mail\Repair\RepairRequestReviewedMail;
use App\Models\RepairRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RepairRequestReviewedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public string $email_customer;
    public function __construct(
        public RepairRequest $repair_request
    ) {
        $this->email_customer = json_decode(
            $this->repair_request->data,
            true
        )['email'];
    }

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
        $mail->to($this->email_customer);
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
