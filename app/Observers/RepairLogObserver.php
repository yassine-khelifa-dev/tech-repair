<?php

namespace App\Observers;

use App\Jobs\SendRepairLogNotificationJob;
use App\Models\RepairLog;
use Illuminate\Support\Facades\Log;

class RepairLogObserver
{
    /**
     * Handle the RepairLog "created" event.
     */
    public function created(RepairLog $repairLog): void
    {
        // Job Send Notif:
        if (
            $repairLog &&
            $repairLog->is_visible_to_customer
        ) {
            try {
                SendRepairLogNotificationJob::dispatch($repairLog);

                Log::info("RepairLogObserver:Notif has been sent (notif:new Log) : repair-id: " . $repairLog->repair_ticket_id);
            } catch (\Throwable $th) {
                Log::error("RepairLogObserver:Notif failed", [
                    'repair_ticket_id' => $repairLog->repair_ticket_id,
                    'message' => $th->getMessage(),
                ]);
            }
        }
    }

    /**
     * Handle the RepairLog "updated" event.
     */
    public function updated(RepairLog $repairLog): void
    {
        //
    }

    /**
     * Handle the RepairLog "deleted" event.
     */
    public function deleted(RepairLog $repairLog): void
    {
        //
    }

    /**
     * Handle the RepairLog "restored" event.
     */
    public function restored(RepairLog $repairLog): void
    {
        //
    }

    /**
     * Handle the RepairLog "force deleted" event.
     */
    public function forceDeleted(RepairLog $repairLog): void
    {
        //
    }
}
