<?php

namespace App\Http\Controllers\Web\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Repair\StoreRepairLogRequest;
use App\Models\RepairTicket;
use App\Services\Repair\RepairLogService;


class RepairLogController extends Controller
{
    public function __construct(
        public RepairLogService $repair_log_service
    ) {}

    public function __invoke(StoreRepairLogRequest $request, RepairTicket $repair_ticket)
    {
        $validatedData = $request->validated();

        $this->repair_log_service->addLog($validatedData, $repair_ticket);

        return  redirect()->route('repair-tickets.show', $repair_ticket->id)
            ->with('success', 'Log has been added successfully.');
    }
}
