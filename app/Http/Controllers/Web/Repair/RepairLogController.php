<?php

namespace App\Http\Controllers\Web\Repair;

use App\Enums\RepairStatus;
use App\Http\Controllers\Controller;
use App\Models\RepairTicket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RepairLogController extends Controller
{

    public function store(Request $request, RepairTicket $repair_ticket)
    {
        $data = $request->validate([
            'message' =>     'required|min:2',
            'new_status' =>  Rule::enum(RepairStatus::class),
            'is_visible_to_customer' =>  ['required', 'in:0,1'],
        ]);

        $data['old_status'] = $repair_ticket->status;

        $repair_ticket->logs()->create($data);

        // update ticket:
        $repair_ticket->status  = $data['new_status'];
        $repair_ticket->save();

        return  redirect()->route('repair-tickets.show', $repair_ticket->id)
            ->with('success', 'Log has bene Updated');
    }
}
