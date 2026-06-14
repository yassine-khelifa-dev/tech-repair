<?php

namespace App\Http\Controllers\Web\Repair;

use App\Enums\RepairRequestStatus;
use App\Enums\RepairStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Repair\StoreRepairTicketRequest;
use App\Models\DeviceModel;
use App\Models\RepairRequest;
use App\Notifications\RepairRequestReviewedNotification;
use App\Services\Repair\RepairTicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class RepairRequestController extends Controller
{
    /**
     * @var RepairTicketService
     */
    protected $_service = null;
    protected $_service_pdf = null;
    public function __construct(RepairTicketService $_service)
    {
        $this->_service     = $_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repair_requests = RepairRequest::orderByRaw("
            CASE
                WHEN status = 'pending'  THEN 1
                WHEN status = 'approved' THEN 2
                WHEN status = 'rejected' THEN 3
            END
        ")->latest()
            ->paginate(7);
        return view('repair.requests.index', compact('repair_requests'));
    }


    /**
     * Display the specified resource.
     */
    public function show(RepairRequest $repair_request)
    {
        $data = json_decode($repair_request->data, true);


        $images = collect($data['images_device_path'] ?? [])
            ->map(fn($item) => (object) $item);


        $device_model = DeviceModel::with(['type', 'brand'])
            ->findOrFail($data['device_model_id']);

        return view('repair.requests.show', [
            'repair_request' => $repair_request,
            'data' => $data,
            'device_model' => $device_model,
            'images' => $images
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


        $data = json_decode($repair_request->data, true);

        if ($_response['status'] === RepairRequestStatus::approved->value) {


            $device_model = DeviceModel::with(['type', 'brand'])
                ->findOrFail($data['device_model_id']);

            $_ticket = [
                'fullname'  => $data['fullname'],
                'email'  => $data['email'],
                'phone'  => $data['phone'],
                'attributes'  => $data['option_ids'],
                'brand_id'  => $device_model->brand->id,
                'status' => RepairStatus::APPROVED->value,
                'device_model_id' => $device_model->id,
                'technician_note' => "technician_note",
                'issue_description' => 'issue_description....'
            ];


            $ticketValidator = Validator::make(
                $_ticket,
                (new StoreRepairTicketRequest())->rules()
            );
            try {
                $_ticket = $ticketValidator->validate();
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }

            $ticket = $this->_service->insert($_ticket);

            // images :
            $imagesForDB = $data['images_device_path'];
            if (! empty($imagesForDB)) {
                $ticket->photos()->createMany($imagesForDB);
                $repair_request->converted_ticket_id = $ticket->id;
                $repair_request->response =  $_response['response'];
                $repair_request->status = RepairRequestStatus::approved->value;
            }
            $repair_request->save();
        }

        if ($_response['status'] === RepairRequestStatus::rejected->value) {
            $repair_request->response =  $_response['response'];
            $repair_request->status = RepairRequestStatus::rejected->value;
        }



        $repair_request->save();


        // send a notif to customer
        try {
            $email = $data['email'];

            Notification::route('mail', $email)
                ->notify(
                    new RepairRequestReviewedNotification($repair_request)
                );

            Log::info("Notif has been sent (notif: send review) : repair-req-id: " . $repair_request->id);
        } catch (\Throwable $th) {
            Log::error("Notif failed(Reviewed)", [
                'repair_ticket_id' => $repair_request->id,
                'message' => $th->getMessage(),
            ]);
        }


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
