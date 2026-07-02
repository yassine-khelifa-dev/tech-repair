<?php

namespace App\Services\Repair;

use App\Enums\RepairRequestStatus;
use App\Enums\RepairStatus;
use App\Http\Requests\Repair\StoreRepairTicketRequest;
use App\Models\DeviceModel;
use App\Models\RepairRequest;
use App\Notifications\RepairRequestReviewedNotification;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class RepairRequestService
{

    public function __construct(
        public RepairTicketService $repair_ticket_service,
        public FileUploadService $file_upload_service,

    ) {}

    public function getList(array $query)
    {
        $q = RepairRequest::query();

        $q->when(
            !empty($query['status']) && $query['status'] !== 'all',
            fn($q) => $q->where('status', $query['status'])
        );

        $q->when(
            !empty($query['customer']),
            fn($q) => $q->where('data->fullname', 'like', $query['customer'] . '%')
        );

        $q->when(
            !empty($query['start']) && !empty($query['end']),
            fn($q) => $q->whereBetween('created_at', [$query['start'], $query['end']])
        );

        $q->when(
            !empty($query['start']) && empty($query['end']),
            fn($q) => $q->whereDate('created_at', '>', $query['start'])
        );

        $q->when(
            empty($query['start']) && !empty($query['end']),
            fn($q) => $q->whereDate('created_at', '<=', $query['end'])
        );

        return $q->orderByRaw("CASE
            WHEN status = 'pending' THEN 1
            WHEN status = 'approved' THEN 2
            WHEN status = 'rejected' THEN 3
            END")
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    public function showDetailsRequest(RepairRequest $repair_request): array
    {
        $data = $repair_request->data;

        $images = collect($data['images_device_path'] ?? [])
            ->map(fn($item) => (object) $item);

        $device_model = DeviceModel::with(['type', 'brand'])
            ->findOrFail($data['device_model_id']);

        return [
            'repair_request' => $repair_request,
            'data' => $data,
            'device_model' => $device_model,
            'images' => $images
        ];
    }


    public function reviewRequest(RepairRequest $repair_request, array $_response)
    {
        if ($repair_request->status !== RepairRequestStatus::pending->value) {

            return;
        }

        $request_status  = $_response['status'];
        $feedback_admin  = $_response['response'];

        $data = $repair_request->data;

        switch ($request_status) {
            case RepairRequestStatus::approved->value:
                $this->approveRequest($data, $repair_request, $feedback_admin);
                break;

            case RepairRequestStatus::rejected->value:
                $this->rejectRequest($repair_request, $feedback_admin);
                break;

            default:
                throw new \InvalidArgumentException(
                    "Invalid repair request status: {$request_status}"
                );
        }

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
    }


    public function approveRequest(array $data, RepairRequest $repair_request, string $feedback_admin)
    {

        DB::transaction(function () use ($data, $repair_request, $feedback_admin) {

            $ticketData = $this->mapRequestToTicketData($data, $feedback_admin);

            Validator::make($ticketData, (new StoreRepairTicketRequest())->rules())->validate();

            $ticket = $this->repair_ticket_service->create($ticketData);

            // save images device :
            if (! empty($data['images_device_path'])) {
                $ticket->photos()->createMany($data['images_device_path']);
            }

            $repair_request->update([
                'converted_ticket_id' =>  $ticket->id,
                'response' =>  $feedback_admin,
                'status' => RepairRequestStatus::approved->value,
            ]);
        });
    }


    public function rejectRequest(RepairRequest $repair_request, string $feedback_admin)
    {
        $repair_request->update([
            'converted_ticket_id' =>  null,
            'response' =>  $feedback_admin,
            'status' => RepairRequestStatus::rejected->value,
        ]);
    }


    public function mapRequestToTicketData(array $data, string $feedback_admin)
    {
        $device_model = DeviceModel::with(['type', 'brand'])
            ->findOrFail($data['device_model_id']);

        return [
            'fullname'          => $data['fullname'],
            'email'             => $data['email'],
            'phone'             => $data['phone'],
            'status'            => RepairStatus::WAITING_DEVICE->value,
            'device_model_id'   => $device_model->id,
            'brand_id'          => $device_model->brand->id,
            'selected_option_ids'        => $data['option_ids'],
            'technician_note'   => $feedback_admin,
            'issue_description' => $data['issue_description'],
            'images_device_path' => []
        ];
    }

    // call by API
    public function create(array $data): RepairRequest
    {
        $data['images_device_path'] =
            $this->file_upload_service->storeImages($data['images_device'] ?? [], 'repair-devices');

        return  RepairRequest::create(
            [
                'data' =>  $data,
                // status: default:pending
                'status' => RepairRequestStatus::pending->value,
            ]
        );
    }
}
