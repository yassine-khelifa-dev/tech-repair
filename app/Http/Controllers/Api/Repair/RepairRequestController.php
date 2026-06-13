<?php

namespace App\Http\Controllers\Api\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RepairRequest;
use App\Models\RepairRequest as ModelsRepairRequest;

class RepairRequestController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(RepairRequest $request)
    {
        $data = $request->validated();

        return ModelsRepairRequest::create([
            'data' =>  json_encode($data)
        ]);
    }
}
