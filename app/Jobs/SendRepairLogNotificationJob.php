<?php

namespace App\Jobs;

use App\Mail\Repair\RepairLogMail;
use App\Models\RepairLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

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

        Mail::to('tech-repair-admin@eprostam.com')->send(
            new RepairLogMail(
                'New Log for ticket : ' . $this->log->ticket->ticket_number,
                $this->log
            )
        );
    }
}
