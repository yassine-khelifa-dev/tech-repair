<?php

namespace App\Jobs;

use App\Models\RepairLog;
use App\Notifications\RepairLogCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendRepairLogNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public RepairLog $log,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->log->loadMissing('ticket');

        Notification::route('mail', 'tech-repair-admin@eprostam.com')
            ->notify(new RepairLogCreatedNotification($this->log));

        Log::info('Repair log email notification sent', [
            'repair_log_id' => $this->log->id,
            'repair_ticket_id' => $this->log->repair_ticket_id,
            'ticket_number' => $this->log->ticket->ticket_number,
            'to' => 'tech-repair-admin@eprostam.com',
        ]);
    }
}
