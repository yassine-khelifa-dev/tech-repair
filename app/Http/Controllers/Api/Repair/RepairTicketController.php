<?php

namespace App\Http\Controllers\Api\Repair;

use App\Http\Controllers\Controller;
use App\Http\Resources\Repair\RepairTicketResource;
use App\Models\RepairTicket;

class RepairTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = RepairTicket::all();
        return RepairTicketResource::collection($tickets);
    }
}
