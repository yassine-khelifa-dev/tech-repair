<?php

namespace App\Http\Controllers\Web\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Repair\StoreRepairTicketRequest;
use App\Http\Requests\Repair\UpdateRepairTicketRequest;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\DeviceType;
use App\Models\RepairTicket;
use Illuminate\Support\Arr;

class RepairTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = RepairTicket::with(['customer', 'deviceModel.brand', 'selectedOptions'])->latest()->paginate(3);
        return view('repair.tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $devicetypes = DeviceType::with('deviceModels.brand', 'deviceModels.allowed_options.specAttribute')->get();
        $brands = Brand::all();
        return view(
            'repair.tickets.create',
            compact('devicetypes', 'brands')
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairTicket $repair_ticket)
    {
        $devicetypes = DeviceType::with('deviceModels.brand', 'deviceModels.allowed_options.specAttribute')->get();
        $brands = Brand::all();
        $repair_ticket->load(['customer', 'deviceModel.brand', 'selectedOptions']);
        return view('repair.tickets.show', compact('repair_ticket', 'brands', 'devicetypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepairTicketRequest $request)
    {
        $data = $request->validated();

        $customerData = Arr::only($data, [
            'fullname',
            'email',
            'phone'
        ]);

        $ticketData = Arr::except($data, [
            'fullname',
            'email',
            'phone',
            'attributes',
            'brand_id'
        ]);

        $optionsIds = collect($data['attributes'] ?? [])->values()->unique()->toArray();

        $customer = Customer::create($customerData);

        $ticket = $customer->tickets()->create($ticketData);

        $ticket->selectedOptions()->sync($optionsIds);

        return redirect()->route('repair-tickets.index')->with('success', 'Ticket has bene created');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairTicket $repair_ticket)
    {
        $devicetypes = DeviceType::with('deviceModels.brand', 'deviceModels.allowed_options.specAttribute')->get();
        $brands = Brand::all();
        $repair_ticket->load(['customer', 'deviceModel.brand', 'selectedOptions.specAttribute']);
        $attributes =  collect($repair_ticket->selectedOptions)->mapWithKeys(function ($option) {
            $key   = $option->specAttribute->name;
            $value = $option->id;
            return [$key  => $value];
        })->toArray() ?? [];
        return view('repair.tickets.edit', compact('repair_ticket', 'brands', 'devicetypes', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepairTicketRequest $request, RepairTicket $repair_ticket)
    {
        $data = $request->validated();

        $customerData = Arr::only($data, [
            'fullname',
            'email',
            'phone'
        ]);

        $ticketData = Arr::except($data, [
            'fullname',
            'email',
            'phone',
            'attributes',
            'brand_id'
        ]);

        $optionsIds = collect($data['attributes'] ?? [])->values()->unique()->toArray();

        $repair_ticket->customer->update($customerData);

        $repair_ticket->customer->tickets()->update($ticketData);

        $repair_ticket->selectedOptions()->sync($optionsIds);

        return redirect()->route('repair-tickets.index')->with('updated', 'Ticket has bene updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairTicket $repair_ticket)
    {

        $repair_ticket->delete();

        return redirect()->route('repair-tickets.index')->with('deleted', 'Ticket has bene deleted');
    }
}
