<?php

namespace App\Http\Controllers\Web\Repair;

use App\Enums\RepairStatus;
use App\Http\Controllers\Controller;
use App\Models\RepairTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class RepairLogController extends Controller
{
    public function store(Request $request, RepairTicket $repair_ticket)
    {
        DB::transaction(function () use ($request, $repair_ticket) {

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
            $imagesPath = [];
            foreach ($request->file('images_log', []) as $image) {
                $imagesPath[] = [
                    'path' => $image->store('repair-logs', 'public'),
                ];
            }
            if (! empty($imagesPath)) {
                $log->images()->createMany($imagesPath);
            }

            // update stauts repair-ticket
            if ($repair_ticket->status !== $data['new_status']) {
                $repair_ticket->update([
                    'status' => $data['new_status'],
                ]);
            }
        });

        Log::info("Create Log for ticket ID: " . $repair_ticket->id);

        return  redirect()->route('repair-tickets.show', $repair_ticket->id)
            ->with('success', 'Log has bene Updated');
    }
}
