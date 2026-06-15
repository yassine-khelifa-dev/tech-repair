<?php

namespace App\Http\Controllers\Web\Repair;

use App\Enums\RepairRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\RepairRequest;
use App\Services\Repair\RepairRequestService;
use Illuminate\Http\Request;
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
        return view(
            'repair.requests.show',
            $this->repair_request_service->showDetailsRequest($repair_request)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function review(Request $request, RepairRequest $repair_request)
    {
        $_response = $request->validate([
            'response' => 'required',
            'status'   =>  Rule::enum(RepairRequestStatus::class),
        ]);

        $this->repair_request_service->reviewRequest($repair_request, $_response);

        return redirect()->route('repair-tickets.index')
            ->with('success', 'Ticket has bene approved');
    }
}
