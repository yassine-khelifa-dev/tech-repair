<?php

namespace App\Services\Repair;

use App\Jobs\SendRepairTicketNotificationJob;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\DeviceType;
use App\Models\RepairTicket;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RepairTicketService
{


    public function __construct()
    {
        Log::info("Start : RepairTicketService");
    }

    public function getList()
    {



        return [
            'tickets' => RepairTicket::with([
                'customer',
                'deviceModel.brand',
                'selectedOptions'
            ])
                ->latest()
                ->paginate(3)
        ];
    }

    public function getFormData()
    {
        $devicetypes = DeviceType::with('deviceModels.brand', 'deviceModels.allowed_options.specAttribute')->get();
        $brands = Brand::all();
        return  compact('devicetypes', 'brands');
    }



    public function insert(array $data)
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
                'attributes',
                'brand_id',
                'images_device'
            ]);

            $ticket = $customer->tickets()->create($ticketData);

            // sync options' device customer
            $optionsIds = collect($data['attributes'] ?? [])->values()->unique()->toArray();
            $ticket->selectedOptions()->sync($optionsIds);

            // Store device photos
            if (! empty($data['images_device'])) {
                $imagesForDB = [];
                foreach ($data['images_device'] as $img_device) {
                    $path = $img_device->store('repair-devices', 'public');
                    $imagesForDB[] = ['path' => $path];
                }
                if (! empty($imagesForDB)) {
                    $ticket->photos()->createMany($imagesForDB);
                }
            }
        });

        // Job: send notif:
        try {
            SendRepairTicketNotificationJob::dispatch($ticket);

            Log::info("Notif has been sent (notif:new Ticket) : repair-id: " . $ticket->id);
        } catch (\Throwable $th) {
            Log::error("Notif failed", [
                'repair_ticket_id' => $ticket->id,
                'message' => $th->getMessage(),
            ]);
        }
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
        DB::transaction(function () use ($data, $ticket) {
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
                'attributes',
                'brand_id'
            ]);
            $ticket->update($ticketData);


            $optionsIds = collect($data['attributes'] ?? [])
                ->values()
                ->unique()
                ->toArray();
            $ticket->selectedOptions()->sync($optionsIds);
        });
    }
}
