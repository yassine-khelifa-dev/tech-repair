<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SearchDeviceModelRequest;
use App\Http\Resources\Device\DeviceModelResource;
use App\Http\Resources\Device\DeviceModelSpecificationResource;
use App\Http\Resources\Device\SpecAttributeOptionResource;
use App\Http\Resources\Device\SpecAttributeResource;
use App\Models\DeviceModel;
use App\Services\Devices\DeviceModelAttributeService;

class DeviceModelController extends Controller
{

    public function __construct(
        public DeviceModelAttributeService $service
    ) {}



    /**
     * Get available device models.
     *
     * Returns all device models matching the selected
     * Brand and Device Type.
     *
     * This endpoint is used during the repair request process
     * after the customer selects a device type and a brand.
     *
     * Examples:
     *
     * Brand: Apple
     * Device Type: Smartphone
     *
     * Results:
     * - iPhone 15
     * - iPhone 15 Pro
     * - iPhone 15 Pro Max
     *
     * Brand: Samsung
     * Device Type: Smartphone
     *
     * Results:
     * - Galaxy S24
     * - Galaxy S24 Ultra
     *
     * Required parameters:
     *
     * - brand_id
     * - device_type_id
     *
     * Example response:
     *
     * [{ <br />
     *     "id": 1, <br />
     *     "name": "iPhone 15 Pro Max", <br />
     *     "slug": "iphone-15-pro-max" <br />
     *    }
     * ] <br />
     */
    public function index(SearchDeviceModelRequest $request)
    {
        $data = $request->validated();

        $_models = DeviceModel::with(['brand', 'type'])
            ->where('brand_id', $data['brand_id'])
            ->where('device_type_id', $data['device_type_id'])
            ->get();
        return DeviceModelResource::collection($_models);
    }

    /**
     * Get specifications for a device model.
     *
     * Returns all available attributes and their allowed options
     * for the selected device model.
     *
     * This endpoint is used after a customer selects a device model.
     * The frontend can use the response to dynamically build
     * the repair request form.
     *
     * Available specifications may include:
     *
     * - Color
     * - Storage
     * - RAM
     * - Network
     * - Condition
     *
     * Example response:
     *
     * Color
     * - Black
     * - White
     *
     * Storage
     * - 128 GB
     * - 256 GB
     *
     * RAM
     * - 8 GB
     * - 12 GB
     *
     * Each attribute contains:
     *
     * - id
     * - name
     * - unit
     * - available options
     */
    public function getAttributesWithOptions(DeviceModel $device_model)
    {
        $device_model->load('allowed_options.specAttribute');

        $attributes = $this->service
            ->getSpecificationsWithOptions($device_model);

        return DeviceModelSpecificationResource::collection($attributes);
    }
}
