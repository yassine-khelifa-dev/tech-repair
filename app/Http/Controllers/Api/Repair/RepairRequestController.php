<?php

namespace App\Http\Controllers\Api\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RepairRequest;
use App\Models\User;
use App\Notifications\RepairRequestReceivedNotification;
use App\Services\AI\AIRepairRequestService;
use App\Services\Repair\RepairRequestService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RepairRequestController extends Controller
{

    /**
     * @var RepairTicketService
     */
    public function __construct(
        public RepairRequestService $repair_request_service,
        public AIRepairRequestService $airepair

    ) {}


    /**

     * Submit a repair request.
     *
     * Creates a new repair request for a customer's device.
     *
     * This endpoint is intended for customers who want to request
     * a repair before visiting the repair shop. The request contains
     * customer details, device information, selected specifications,
     * a description of the issue, and optional device images.
     *
     * Once submitted, the repair request is created with a
     * **Pending** status and awaits technician review.
     *
     * Required fields:
     * * fullname
     * * email
     * * phone
     * * device_model_id
     * * option_ids
     * * issue_description
     *
     * Optional fields:
     * * imei
     * * sn
     * * images_device
     *
     * Notes:
     * * The request must be sent as **multipart/form-data** when uploading images.
     * * Array values must be submitted using repeated keys:
     * * option_ids[] = 10
     * * option_ids[] = 92
     * * option_ids[] = 113
     *
     * Success Response (201 Created):
     *
     * {
     * "message": "Repair request submitted successfully.",
     * "data": {
     * ```
     *"id": 18,
     * "status": "pending"
     *```
     * }
     * }
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
            if ($admin) {
                $admin->notify(new RepairRequestReceivedNotification($repair_request));
            } else {
                Notification::route('mail', 'tech-repair-admin@eprostam.com')
                    ->notify(new RepairRequestReceivedNotification($repair_request));
            }

            Log::info("API: Notif has been sent (notif:new Repair Request) : repair-req-id: " . $repair_request->id);
        } catch (\Throwable $th) {
            Log::error("API: Notif failed", [
                'API:repair_request_id' => $repair_request->id,
                'message' => $th->getMessage(),
            ]);
        }

        return response()->json([
            'message' => 'Repair request submitted successfully.',
            'data' => [
                'id' => $repair_request->id,
                'status' => $repair_request->status,
            ],
        ], 201);
    }


    public function ask(Request $request)
    {
        $request->validate([
            'issue_description' => ['required', 'string'],
        ]);
        $req = $this->airepair->analyzeRepairRequest($request->input('issue_description'));
        if ($req['success']) {
            return $req;
        }
        return [];
    }
}
