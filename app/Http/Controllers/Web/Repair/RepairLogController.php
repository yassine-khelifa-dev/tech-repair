<?php

namespace App\Http\Controllers\Web\Repair;

use App\Enums\RepairStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Repair\StoreRepairLogRequest;
use App\Models\RepairTicket;
use App\Services\AI\AIRepairRequestService;
use App\Services\Repair\RepairLogService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RepairLogController extends Controller
{
    public function __construct(
        public RepairLogService $repair_log_service,
        public AIRepairRequestService $airepair
    ) {}

    public function __invoke(StoreRepairLogRequest $request, RepairTicket $repair_ticket)
    {
        $validatedData = $request->validated();

        $this->repair_log_service->addLog($validatedData, $repair_ticket);

        return  redirect()->route('repair-tickets.show', $repair_ticket->id)
            ->with('success', 'Log has been added successfully.');
    }

    public function ask(Request $request)
    {
        $data = $request->validate([
            'ticket_id' => ['required', 'exists:repair_tickets,id'],
            'new_log_msg' => ['nullable', 'string'],
            'new_status' => ['required', Rule::enum(RepairStatus::class)],
        ]);

        $ticket = RepairTicket::with([
            'logs' => fn($q) => $q
                ->where('is_visible_to_customer', true)
                ->oldest(),
        ])->findOrFail($data['ticket_id']);

        return $this->airepair->analyzeRepairLog(
            ticket: $ticket,
            new_log: $data['new_log_msg'] ?? null,
            new_status: $data['new_status'],
        );
    }
}




