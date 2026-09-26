<?php

namespace App\Notifications;

use App\Mail\Repair\RepairRequestMail;
use App\Models\RepairRequest;
use App\Notifications\Channels\TwilioWhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;

class RepairRequestCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public RepairRequest $repair_request,
        private bool $databaseOnly = false,
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
        if ($this->databaseOnly) {
            return ['database'];
        }

        if ($notifiable instanceof AnonymousNotifiable) {
            return ['mail', TwilioWhatsAppChannel::class];
        }

        return ['mail', 'database', TwilioWhatsAppChannel::class];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): RepairRequestMail
    {
        $mail = new RepairRequestMail($this->repair_request);

        $mail->to('tech-repair-admin@eprostam.com');

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


    public function toWhatsApp($notifiable): array
    {
        return [
            'content_sid' => config('services.twilio.repair_request_template_sid'),
            'variables' => [
                '1' => (string) $this->repair_request->id,
                '2' => $this->repair_request->customer->name ?? 'N/A',
            ],
        ];
    }
}
