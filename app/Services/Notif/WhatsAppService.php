<?php

namespace App\Services\Notif;

use Twilio\Rest\Client;

class WhatsAppService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function send(string $phone, string $message): void
    {
        $this->client->messages->create(
            'whatsapp:' . $phone,
            [
                'from' => config('services.twilio.whatsapp_from'),
                'body' => $message,
            ]
        );
    }
}
