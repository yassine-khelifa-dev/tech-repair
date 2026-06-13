<?php

namespace App\Http\Controllers\Web\Repair;

use App\Enums\RepairRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\DeviceModel;
use App\Models\RepairRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RepairRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repair_requests = RepairRequest::all();
        return view('repair.requests.index', compact('repair_requests'));
    }



    /**
     * Display the specified resource.
     */
    public function show(RepairRequest $repair_request)
    {


        $data = json_decode($repair_request->data, true);

        $device_model = DeviceModel::with(['type', 'brand'])
            ->findOrFail($data['device_model_id']);

        return view('repair.requests.show', [
            'repair_request_id' => $repair_request->id,
            'data' => $data,
            'device_model' => $device_model
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function review(Request $request, RepairRequest $repair_request)
    {
        $_response = $request->validate([
            'response' => 'required',
            'status' =>  Rule::enum(RepairRequestStatus::class),
        ]);

        if ($_response['status'] === RepairRequestStatus::approved->value) {

            $data = json_decode($repair_request->data, true);
            $device_model = DeviceModel::with(['type', 'brand'])
                ->findOrFail($data['device_model_id']);

            $_ticket = [
                'fullname'  => $data['fullname'],
                'email'  => $data['email'],
                'phone'  => $data['phone'],
                'attributes'  => $data['option_ids'],
                'brand_id'  => $device_model->brand->id,
                'images_device'  => $data['images_device_path'],
            ];


            dd($_ticket);


            $repair_request->converted_ticket_id = "value";
        }

        // converted_ticket_id : approved, rejected

        return $this->to(
            'repair-tickets.index',
            'success',
            'Ticket has bene approved'
        );
    }

    public function to(string $route, string $key, string $message)
    {
        return redirect()
            ->route($route)
            ->with($key, $message);
    }
}
