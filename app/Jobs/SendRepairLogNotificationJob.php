<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\RepairLog;
use App\Notifications\RepairLogCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendRepairLogNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public RepairLog $log,
        public array $repairImages,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $customer = $this->log->ticket->customer;
        $customer->notify(
            new RepairLogCreatedNotification(
                 $this->log,
                 $this->repairImages ?? []
            )
        );
    }
}
