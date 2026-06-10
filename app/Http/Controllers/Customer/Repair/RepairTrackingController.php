<?php

namespace App\Http\Controllers\Customer\Repair;

use App\Http\Controllers\Controller;
use App\Models\RepairTicket;

class RepairTrackingController extends Controller
{
    public function show(string $public_token)
    {
        $repair_ticket = RepairTicket::where('public_token', $public_token)->


        with([
            'customer',
            'deviceModel.brand',
            'deviceModel.type',
            'selectedOptions.specAttribute',
            'photos',
            'logs' => fn ($q) => $q->where('is_visible_to_customer', true)->with('images'),
        ])->firstOrFail();
        return view(
            'customer.repair.track',
            compact('repair_ticket')
        );
    }
}
