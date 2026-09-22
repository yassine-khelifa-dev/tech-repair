<?php

namespace App\Http\Controllers\Web\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Repair\StoreRepairTicketRequest;
use App\Http\Requests\Repair\UpdateRepairTicketRequest;
use App\Models\RepairTicket;
use App\Services\AI\AIRepairRequestService;
use App\Services\Repair\RepairPdfService;
use App\Services\Repair\RepairTicketService;
use Illuminate\Http\Request ;

class RepairTicketController extends Controller
{

    /**
     * @var RepairTicketService
     */
    public function __construct(
        public  RepairTicketService $repair_ticket_service,
        public  RepairPdfService $repair_pdf_service,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return view(
            'repair.tickets.index',
            $this->repair_ticket_service->getList($request->query())
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'repair.tickets.create',
            $this->repair_ticket_service->getFormData()
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairTicket $repair_ticket)
    {
        $repair_ticket->load([
            'customer',
            'deviceModel.brand',
            'deviceModel.type',
            'selectedOptions.specAttribute',
            'photos',
            'logs.images',
        ]);
        return view(
            'repair.tickets.show',
            compact('repair_ticket')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepairTicketRequest $request)
    {
        $data = $request->validated();

        $this->repair_ticket_service->create($data);

        return $this->to(
            'repair-tickets.index',
            'success',
            'Repair ticket has been created.'
        );
    }

    /**
     * Download a Repair Ticket recipe
     */
    public function download(RepairTicket $repair_ticket)
    {
        $repair_ticket->load([
            'customer',
            'deviceModel.brand',
            'deviceModel.type',
            'selectedOptions.specAttribute',
            'logs' => fn($q) => $q->where('is_visible_to_customer', true),
        ]);
        return $this->repair_pdf_service->downloadDepositReceipt($repair_ticket);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairTicket $repair_ticket)
    {
        $repair_ticket->load([
            'customer',
            'deviceModel.brand',
            'selectedOptions.specAttribute'
        ]);

        return view(
            'repair.tickets.edit',
            array_merge(
                [
                    'repair_ticket' => $repair_ticket,
                    'selected_option_ids' => $this->repair_ticket_service->getSelectedAttributesForForm($repair_ticket)
                ],
                $this->repair_ticket_service->getFormData()
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepairTicketRequest $request, RepairTicket $repair_ticket)
    {
        $data = $request->validated();

        $this->repair_ticket_service->update($data, $repair_ticket);

        return $this->to(
            'repair-tickets.index',
            'updated',
            'Repair ticket has been updated.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairTicket $repair_ticket)
    {
        $repair_ticket->delete();

        return $this->to(
            'repair-tickets.index',
            'deleted',
            'Repair ticket has been deleted.'
        );
    }

    public function to(string $route, string $key, string $message)
    {
        return redirect()
            ->route($route)
            ->with($key, $message);
    }



}
