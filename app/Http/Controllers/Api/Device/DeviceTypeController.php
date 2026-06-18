<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Controller;
use App\Http\Resources\Device\DeviceTypeResource;
use App\Models\DeviceType;

class DeviceTypeController extends Controller
{
    /**
     * Get all device types.
     *
     * A Device Type represents a category of devices.
     *
     * Examples:
     * - Smartphone
     * - Tablet
     * - Laptop
     *
     * Device Types are used to filter available device models.
     */
    public function index()
    {
        return DeviceTypeResource::collection(DeviceType::all());
    }
}
