<?php

namespace App\Http\Controllers\Api\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RepairRequest;
use App\Models\RepairRequest as ModelsRepairRequest;
use App\Models\User;
use App\Notifications\RepairRequestReceivedNotification;
use Illuminate\Support\Facades\Log;

class RepairRequestController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(RepairRequest $request)
    {
        $data = $request->validated();

        // save images device:
        $imagesForDB = [];
        foreach ($data['images_device'] as $img_device) {
            $path = $img_device->store('repair-devices', 'public');
            $imagesForDB[] = ['path' => $path];
        }
        $data['images_device_path'] = $imagesForDB;

        // save the repair request :
        $data_req =  ModelsRepairRequest::create(['data' =>  json_encode($data)]);


        $admin = User::where('role', 'admin')->first();
        // send notif to admin
        try {
            $admin->notify(new RepairRequestReceivedNotification($data_req));

            Log::info("API: Notif has been sent (notif:new Repair Request) : repair-req-id: " . $data_req->id);
        } catch (\Throwable $th) {
            Log::error("API: Notif failed", [
                'API:repair_request_id' => $data_req->id,
                'message' => $th->getMessage(),
            ]);
        }

        return $data_req;
    }
}
