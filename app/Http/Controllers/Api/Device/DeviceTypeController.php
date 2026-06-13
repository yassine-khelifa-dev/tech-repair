<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Controller;
use App\Http\Resources\Device\DeviceTypeResource;
use App\Models\DeviceType;

class DeviceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DeviceTypeResource::collection(DeviceType::all());
    }
}
