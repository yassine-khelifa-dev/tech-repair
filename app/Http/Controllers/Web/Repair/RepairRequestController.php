<?php

namespace App\Http\Controllers\Web\Repair;

use App\Enums\RepairRequestStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Repair\ReviewRepairRequestRequest;
use App\Models\RepairRequest;
use App\Services\Repair\RepairRequestService;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Validation\Rule;

class RepairRequestController extends Controller
{
    /**
     * @var RepairTicketService
     */
    public function __construct(
        public RepairRequestService $repair_request_service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('repair.requests.index', [
            'repair_requests' => $this->repair_request_service->getList()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairRequest $repair_request)
    {
        // mark notification as read
        DatabaseNotification::where('data->id_repair_request', $repair_request->id)
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

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
            ->with('success', 'Ticket has bene approved');
    }
}
