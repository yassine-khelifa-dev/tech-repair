<?php

namespace App\Http\Controllers\Web\Repair;

use App\Enums\RepairStatus;
use App\Http\Controllers\Controller;
use App\Mail\Repair\RepairLogMail;
use App\Models\RepairTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class RepairLogController extends Controller
{
    public function __invoke(Request $request, RepairTicket $repair_ticket)
    {

        $log = null;
        $imagesForMail = [];
        DB::transaction(function () use ($request, $repair_ticket, &$log,  &$imagesForMail) {

            $data = $request->validate([
                'message' => 'required|min:2',
                'new_status' => [Rule::enum(RepairStatus::class)],
                'is_visible_to_customer' => ['required', 'in:0,1'],
                'images_log' => ['nullable', 'array'],
                'images_log.*' => ['image', 'max:5120'],
            ]);

            // create a Log:
            $logData = collect($data)
                ->except('images_log')
                ->toArray();
            $logData['old_status'] = $repair_ticket->status;
            $log = $repair_ticket->logs()->create($logData);

            // create log images
            $imagesForDatabase = [];
            foreach ($request->file('images_log', []) as $image) {
                $path = $image->store('repair-logs', 'public');

                $imagesForDatabase[] = ['path' => $path];

                $imagesForMail[]     = storage_path('app/public/' . $path);
            }
            if (! empty($imagesForDatabase)) {
                $log->images()->createMany($imagesForDatabase);
            }

            // update stauts repair-ticket
            if ($repair_ticket->status !== $data['new_status']) {
                $repair_ticket->update([
                    'status' => $data['new_status'],
                ]);
            }
        });

        Log::info("Create Log for ticket ID: " . $repair_ticket->id);

        // TODO: queue notification mail
        // send Mail:
        if (
            $log  &&
            $log->is_visible_to_customer &&
            filled($repair_ticket->customer?->email)
        ) {
            try {
                Mail::to($repair_ticket->customer->email)
                    ->send(
                        new RepairLogMail(
                            $log,
                            "New Log for ticket : " . $repair_ticket->ticket_number,
                            $imagesForMail
                        )
                    );
                Log::info("Email has been sent (notif:new Log) : repair-id: " . $repair_ticket->id);
            } catch (\Throwable $th) {
                Log::error("Email failed", [
                    'repair_ticket_id' => $repair_ticket->id,
                    'message' => $th->getMessage(),
                ]);
            }
        }


        return  redirect()->route('repair-tickets.show', $repair_ticket->id)
            ->with('success', 'Log has been added successfully.');
    }
}
