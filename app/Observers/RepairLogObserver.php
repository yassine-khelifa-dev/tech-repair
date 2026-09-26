<?php

namespace App\Observers;

use App\Models\RepairLog;
use App\Notifications\RepairLogCreatedNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

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
            Notification::route('mail', 'tech-repair-admin@eprostam.com')
                ->notify(new RepairLogCreatedNotification($repairLog));

            Log::info('Repair log email notification sent', [
                'repair_log_id' => $repairLog->id,
                'repair_ticket_id' => $repairLog->repair_ticket_id,
                'ticket_number' => $repairLog->ticket->ticket_number,
                'to' => 'tech-repair-admin@eprostam.com',
            ]);
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
