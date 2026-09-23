<?php

namespace App\Http\Controllers\Web\Repair;

use App\Enums\RepairRequestStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Repair\ReviewRepairRequestRequest;
use App\Models\RepairRequest;
use App\Services\Repair\RepairRequestService;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class RepairRequestController extends Controller
{
    /**
     * @var RepairTicketService
     */
    public function __construct(
        public RepairRequestService $repair_request_service,

    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->all();
        return view('repair.requests.index', [
            'repair_requests' => $this->repair_request_service->getList($query)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairRequest $repair_request)
    {
        DatabaseNotification::where('data->id_repair_request', $repair_request->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        if (
            $repair_request->status === RepairRequestStatus::approved->value
            && $repair_request->converted_ticket_id
        ) {
            return redirect()->route('repair-tickets.show', $repair_request->converted_ticket_id);
        }

        return view(
            'repair.requests.show',
            $this->repair_request_service->showDetailsRequest($repair_request)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function review(ReviewRepairRequestRequest $request, RepairRequest $repair_request)
    {
        $this->repair_request_service->reviewRequest(
            $repair_request,
            $request->validated()
        );

        return redirect()->route('repair-tickets.index')
            ->with('success', 'Repair request has been reviewed.');
    }
}
