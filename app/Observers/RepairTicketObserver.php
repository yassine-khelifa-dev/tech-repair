<?php

namespace App\Observers;

use App\Jobs\SendRepairTicketCreatedNotificationJob;
use App\Models\RepairTicket;
use Illuminate\Support\Facades\Log;

class RepairTicketObserver
{
    /**
     * Handle the RepairTicket "created" event.
     */
    public function created(RepairTicket $repairTicket): void
    {
        // send to customer first email ( new ticket )
        try {
            SendRepairTicketCreatedNotificationJob::dispatch($repairTicket);
            Log::info("RepairTicketObserver: New ticket notification job dispatched: ticket-id: " . $repairTicket->id);
        } catch (\Throwable $th) {
            Log::error("RepairTicketObserver:Notif failed", [
                'ticket_id' => $repairTicket->id,
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Handle the RepairTicket "updated" event.
     */
    public function updated(RepairTicket $repairTicket): void
    {
        //
    }

    /**
     * Handle the RepairTicket "deleted" event.
     */
    public function deleted(RepairTicket $repairTicket): void
    {
        //
    }

    /**
     * Handle the RepairTicket "restored" event.
     */
    public function restored(RepairTicket $repairTicket): void
    {
        //
    }

    /**
     * Handle the RepairTicket "force deleted" event.
     */
    public function forceDeleted(RepairTicket $repairTicket): void
    {
        //
    }
}
