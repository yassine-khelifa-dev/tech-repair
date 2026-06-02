<?php

namespace App\Http\Controllers\Web\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Repair\StoreRepairTicketRequest;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\DeviceModel;
use App\Models\DeviceType;
use App\Models\RepairTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RepairTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('repair.tickets.index');
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
     * Store a newly created resource in storage.
     */
    public function store(StoreRepairTicketRequest $request)
    {

        $data = $request->validated();

        $customerData = Arr::only($data, [
            'fullname','email','phone'
        ]);

        $ticketData = Arr::except($data,[
            'fullname','email','phone', 'attributes'
        ]);

        $optionsIds = collect($data['attributes'] ?? [] )->values()->unique()->toArray();

        $customer = Customer::create($customerData);

        $ticket = $customer->tickets()->create( $ticketData );

        $ticket->selectedOptions()->sync( $optionsIds );

        return redirect()->route('repair-tickets.index')->with('success', 'Ticket has bene created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
