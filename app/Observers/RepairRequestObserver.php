<?php

namespace App\Observers;

use App\Models\RepairRequest;
use App\Notifications\RepairRequestCreatedNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class RepairRequestObserver
{
    /**
     * Handle the RepairRequest "created" event.
     */
    public function created(RepairRequest $repairRequest): void
    {
        try {
            Notification::route('mail', 'tech-repair-admin@eprostam.com')
             //   ->route('whatsapp', '+393516332693')
                ->notify(new RepairRequestCreatedNotification($repairRequest));

            Log::info("RepairRequestObserver: Notif has been sent (notif:new Repair Request) : repair-req-id: " . $repairRequest->id);
        } catch (\Throwable $th) {
            Log::error("RepairRequestObserver. API: Notif failed", [
                'API:repair_request_id' => $repairRequest->id,
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Handle the RepairRequest "updated" event.
     */
    public function updated(RepairRequest $repairRequest): void {}

    /**
     * Handle the RepairRequest "deleted" event.
     */
    public function deleted(RepairRequest $repairRequest): void
    {
        //
    }

    /**
     * Handle the RepairRequest "restored" event.
     */
    public function restored(RepairRequest $repairRequest): void
    {
        //
    }

    /**
     * Handle the RepairRequest "force deleted" event.
     */
    public function forceDeleted(RepairRequest $repairRequest): void
    {
        //
    }
}
