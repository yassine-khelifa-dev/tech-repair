<?php

namespace App\Listeners;

use App\Events\RepairRequestReviewed;
use App\Notifications\RepairRequestReviewedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendRepairRequestReviewedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(RepairRequestReviewed $event): void
    {
        try {
            Notification::route('mail', $event->email)
                ->notify(
                    new RepairRequestReviewedNotification($event->repair_request)
                );
            Log::info("Listeners:Notif has been sent (notif: send review) : repair-req-id: " . $event->repair_request->id);
        } catch (\Throwable $th) {
            Log::error("Notif failed(Reviewed)", [
                'repair_ticket_id' => $event->repair_request->id,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
