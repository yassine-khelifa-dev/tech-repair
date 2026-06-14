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
        public RepairRequestService $_service)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RepairRequest $request)
    {
        $data = $request->validated();

        // save the repair request :
        $repair_request =  $this->_service->insert($data);

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
