<?php
namespace App\Http\Controllers\Web\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Repair\StoreRepairTicketRequest;
use App\Http\Requests\Repair\UpdateRepairTicketRequest;
use App\Models\RepairTicket;
use App\Services\Repair\RepairTicketService;

class RepairTicketController extends Controller
{

    /**
     * @var RepairTicketService
     */
    protected $_service = null;
    public function __construct(RepairTicketService $_service)
    {
        $this->_service = $_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'repair.tickets.index',
            $this->_service->getList()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'repair.tickets.create',
            $this->_service->getFormData()
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

        $this->_service->insert($data);

        return $this->to(
            'repair-tickets.index',
            'success',
            'Ticket has bene created'
        );
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
                    'attributes' => $this->_service->getSelectedAttributesForForm($repair_ticket)
                ],
                $this->_service->getFormData()
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRepairTicketRequest $request, RepairTicket $repair_ticket)
    {
        $data = $request->validated();

        $this->_service->update($data, $repair_ticket);

        return $this->to(
            'repair-tickets.index',
            'updated',
            'Ticket has bene updated'
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
            'Ticket has bene deleted'
        );
    }

    public function to(string $route, string $key, string $message)
    {
        return redirect()
            ->route($route)
            ->with($key, $message);
    }
}
