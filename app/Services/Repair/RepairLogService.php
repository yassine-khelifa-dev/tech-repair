<?php

namespace App\Services\Repair;

use App\Jobs\SendRepairLogNotificationJob;
use App\Models\RepairTicket;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RepairLogService
{
    public function __construct(
        public FileUploadService $file_upload_service
    ) {}

    /**
     * data: 'message' , 'new_status', 'is_visible_to_customer', 'images_log' , 'images_log.*'
     */
    public function addLog(array $data, RepairTicket $repair_ticket)
    {
        /** @var RepairLog::class */
        $log = null;

        DB::transaction(function () use ($data, $repair_ticket, &$log) {

            // create a Log:
            $logData = collect($data)->except('images_log')->toArray();
            $logData['old_status'] = $repair_ticket->status;

            $log = $repair_ticket->logs()->create($logData);

            $imagesForDatabase = $this->file_upload_service->storeImages(
                images: $data['images_log'] ?? [],
                folder: 'repair-logs'
            );

            if (! empty($imagesForDatabase)) {
                $log->images()->createMany($imagesForDatabase);
            }

            // update repair ticket status
            if ($repair_ticket->status !== $log->new_status) {

                $repair_ticket->update(
                    [
                        'status' => $log->new_status,
                    ]
                );
            }
        });

        // Job Send Notif:
        if (
            $log  &&
            $log->is_visible_to_customer &&
            filled($repair_ticket->customer?->email)
        ) {
            try {
                SendRepairLogNotificationJob::dispatch($log);

                Log::info("Notif has been sent (notif:new Log) : repair-id: " . $repair_ticket->id);
            } catch (\Throwable $th) {
                Log::error("Notif failed", [
                    'repair_ticket_id' => $repair_ticket->id,
                    'message' => $th->getMessage(),
                ]);
            }
        }
        Log::info("Create Log for ticket ID: " . $repair_ticket->id);

        //return $log;
    }
}
