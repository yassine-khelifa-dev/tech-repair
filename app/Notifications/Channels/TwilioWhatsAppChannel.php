<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class TwilioWhatsAppChannel
{
    protected Client $client;
    protected string $fromNumber;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.auth_token')
        );

        $this->fromNumber = config('services.twilio.from_number');
    }

    public function send(object $notifiable, Notification $notification): void
    {
        $to = $notifiable->routeNotificationFor('whatsapp');

        if (! $to) {
            return;
        }

        $data = $notification->toWhatsApp($notifiable); // now returns an array

        $this->client->messages->create(
            'whatsapp:' . $to,
            [
                'from' => 'whatsapp:' . $this->fromNumber,
                'contentSid' => $data['content_sid'],
                'contentVariables' => json_encode($data['variables']),
            ]
        );
    }
}
