<?php

namespace App\Services\Repair;

use App\Jobs\SendRepairTicketNotificationJob;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\DeviceType;
use App\Models\RepairTicket;
use App\Services\FileUploadService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RepairTicketService
{

    public function __construct(
        public FileUploadService $file_upload_service,
    ) {}


    public function getList(array $query)
    {
        $q = RepairTicket::query()
            ->with([
                'customer',
                'deviceModel.brand',
                'selectedOptions',
            ]);

        $q->when(
            !empty($query['status']) && $query['status'] !== 'all',
            fn($q) => $q->where('status', $query['status'])
        );

        $q->when(
            !empty($query['customer']),
            fn($q) => $q->whereHas('customer', function ($customer) use ($query) {
                $customer->where('fullname', 'like', $query['customer'] . '%');
            })
        );

        $q->when(
            !empty($query['start']) && !empty($query['end']),
            fn($q) => $q->whereBetween('received_at', [
                Carbon::parse($query['start'])->startOfDay(),
                Carbon::parse($query['end'])->endOfDay()
            ])
        );

        $q->when(
            !empty($query['start']) && empty($query['end']),
            fn($q) => $q->whereDate('received_at', '>=', Carbon::parse($query['start'])->startOfDay())
        );

        $q->when(
            empty($query['start']) && !empty($query['end']),
            fn($q) => $q->whereDate('received_at', '<=', Carbon::parse($query['end'])->endOfDay())
        );

        return [
            'tickets' => $q
                ->latest()
                ->paginate(8)
                ->withQueryString(),
        ];
    }

    public function getFormData()
    {
        $devicetypes = DeviceType::with('deviceModels.brand', 'deviceModels.allowed_options.specAttribute')->get();
        $brands = Brand::all();
        return  compact('devicetypes', 'brands');
    }


    public function create(array $data): RepairTicket
    {
        /** @var RepairTicket::class */
        $ticket = null;
        DB::transaction(function () use ($data, &$ticket) {
            $customerData = Arr::only($data, [
                'fullname',
                'email',
                'phone'
            ]);
            $customer = Customer::create($customerData);

            $ticketData = Arr::except($data, [
                'fullname',
                'email',
                'phone',
                'selected_option_ids',
                'brand_id',
                'images_device'
            ]);

            $ticket = $customer->tickets()->create($ticketData);

            // sync options' device customer
            $optionsIds = collect($data['selected_option_ids'] ?? [])->values()->unique()->toArray();
            $ticket->selectedOptions()->sync($optionsIds);

            // Store device photos
            if (! empty($data['images_device'])) {
                $imagesForDB =  $this->file_upload_service->storeImages(
                    images: $data['images_device'],
                    folder: 'repair-devices'
                );
                if (! empty($imagesForDB)) {
                    $ticket->photos()->createMany($imagesForDB);
                }
            }
        });

        // send to customer first email ( new ticket )
        {
            try {
                SendRepairTicketNotificationJob::dispatch($ticket);

                Log::info("New ticket notification job dispatched: ticket-id: " . $ticket->id);
            } catch (\Throwable $th) {
                Log::error("Notif failed", [
                    'ticket_id' => $ticket->id,
                    'message' => $th->getMessage(),
                ]);
            }
        }

        return $ticket;
    }


    // FORM EDIT :
    public function getSelectedAttributesForForm(RepairTicket $ticket)
    {
        return collect($ticket->selectedOptions)->mapWithKeys(function ($option) {
            $key   = $option->specAttribute->name;
            $value = $option->id;
            return [$key  => $value];
        })->toArray() ?? [];
    }


    public function update(array $data, RepairTicket $ticket)
    {
        DB::transaction(function () use ($data, &$ticket) {
            $customerData = Arr::only($data, [
                'fullname',
                'email',
                'phone'
            ]);
            $ticket->customer->update($customerData);


            $ticketData = Arr::except($data, [
                'fullname',
                'email',
                'phone',
                'selected_option_ids',
                'brand_id'
            ]);
            $ticket->update($ticketData);


            $optionsIds = collect($data['selected_option_ids'] ?? [])
                ->values()
                ->unique()
                ->toArray();
            $ticket->selectedOptions()->sync($optionsIds);
        });
        return $ticket;
    }
}
