<?php

namespace App\Observers;

use App\Models\RepairTicket;
use App\Notifications\RepairTicketCreatedNotification;
use Illuminate\Support\Facades\Log;

class RepairTicketObserver
{
    /**
     * Handle the RepairTicket "created" event.
     */
    public function created(RepairTicket $repairTicket): void
    {
        $repairTicket->load([
            'customer',
            'deviceModel.brand',
            'deviceModel.type',
        ]);

        // send to customer first email ( new ticket )
        try {
            if (! $repairTicket->customer?->email) {
                return;
            }
            $repairTicket->customer->notify(
                new RepairTicketCreatedNotification($repairTicket)
            );

            Log::info("RepairTicketObserver: New RepairTicketCreatedNotification  : ticket-id: " . $repairTicket->id);
        } catch (\Throwable $th) {
            Log::error("RepairTicketObserver: RepairTicketCreatedNotification failed", [
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
