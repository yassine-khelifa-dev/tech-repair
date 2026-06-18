<?php

namespace App\Http\Controllers\Api\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RepairRequest;
use App\Models\User;
use App\Notifications\RepairRequestReceivedNotification;
use App\Services\Repair\RepairRequestService;
use Illuminate\Support\Facades\Log;

class RepairRequestController extends Controller
{

    /**
     * @var RepairTicketService
     */
    public function __construct(
        public RepairRequestService $repair_request_service
    ) {}


    /**
     * Submit a repair request.
     *
     * Creates a new repair request for a customer device.
     *
     * The request contains customer information,
     * device information and a description of the issue.
     *
     * After submission, the request is stored with
     * a Pending status and awaits technician review.
     *
     * Example:
     *
     * Customer:
     * - John Smith
     *
     * Device:
     * - Apple iPhone 15 Pro Max
     *
     * Issue:
     * - Cracked screen
     * - Touch not working
     */
    public function store(RepairRequest $request)
    {
        $data = $request->validated();

        // save the repair request :
        $repair_request =  $this->repair_request_service->create($data);

        // get first admin:
        $admin = User::where('role', 'admin')->first();

        // send notif to admin ( email, DB)
        try {
            $admin->notify(new RepairRequestReceivedNotification($repair_request));

            Log::info("API: Notif has been sent (notif:new Repair Request) : repair-req-id: " . $repair_request->id);
        } catch (\Throwable $th) {
            Log::error("API: Notif failed", [
                'API:repair_request_id' => $repair_request->id,
                'message' => $th->getMessage(),
            ]);
        }

        return $repair_request;
    }
}
