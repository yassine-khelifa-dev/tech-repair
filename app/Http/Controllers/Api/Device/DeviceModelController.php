<?php

namespace App\Http\Controllers\Api\Device;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SearchDeviceModelRequest;
use App\Http\Resources\Device\DeviceModelResource;
use App\Http\Resources\Device\SpecAttributeOptionResource;
use App\Http\Resources\Device\SpecAttributeResource;
use App\Models\DeviceModel;

class DeviceModelController extends Controller
{
    /**
     * Get device models by brand and device type.
     *
     * A Device Model represents a specific device produced by a Brand.
     *
     * Examples:
     * - iPhone 15 Pro Max
     * - Galaxy S24 Ultra
     * - Redmi Note 14
     *
     * Each Device Model belongs to one Brand and one Device Type.
     *
     * This endpoint is used after selecting a Brand and Device Type.
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
     * Returns the available attributes and allowed options for a selected device model.
     *
     * This endpoint is used after the customer selects a device model.
     * The frontend can use this response to build the repair request form dynamically.
     *
     * Example response:
     *
     * [
     *   {
     *     "id": 1,
     *     "name": "Color",
     *     "unit": null,
     *     "options": [
     *       {
     *         "id": 10,
     *         "label": "Black",
     *         "value": "black"
     *       }
     *     ]
     *   }
     * ]
     */
    public function getAttributesWithOptions(DeviceModel $device_model)
    {
        $device_model->load('allowed_options.specAttribute');

        $attributes = $device_model->allowed_options
            ->groupBy('specAttribute.id')
            ->map(function ($options) {
                $attribute = $options->first()->specAttribute;

                return [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'unit' => strtolower($attribute->unit) !== 'none' ? $attribute->unit : null,
                    'options' => SpecAttributeOptionResource::collection($options),
                ];
            })
            ->values();

        return $attributes;
    }
}
