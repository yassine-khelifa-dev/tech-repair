<?php

namespace App\Http\Controllers\Customer\Repair;

use App\Http\Controllers\Controller;
use App\Models\RepairTicket;

class RepairTrackingController extends Controller
{
    public function show(string $ticket_number)
    {
        $repair_ticket = RepairTicket::where('ticket_number', $ticket_number)->

        with([
            'customer',
            'deviceModel.brand',
            'deviceModel.type',
            'selectedOptions.specAttribute',
            'photos',
            'logs' => fn ($q) => $q->where('is_visible_to_customer', true)->with('images'),
        ])->first();
        return view(
            'customer.repair.track',
            compact('repair_ticket')
        );
    }
}
