<?php

namespace App\Jobs;

use App\Models\RepairTicket;
use App\Notifications\RepairTicketCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendRepairTicketNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public RepairTicket $ticket
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->ticket->load([
            'customer',
            'deviceModel.brand',
            'deviceModel.type',
        ]);

        if (! $this->ticket->customer?->email) {
            return;
        }

        $this->ticket->customer->notify(
            new RepairTicketCreatedNotification($this->ticket)
        );
    }
}
