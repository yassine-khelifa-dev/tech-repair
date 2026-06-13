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
     * Display a listing of the resource.
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
                    'unit' => $attribute->unit !== 'None' ? $attribute->unit : null,
                    'options' => SpecAttributeOptionResource::collection($options),
                ];
            })
            ->values();

        return $attributes;
    }
}
