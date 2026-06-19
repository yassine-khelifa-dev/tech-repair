<?php

namespace App\Services\Devices;

use App\Models\DeviceModel;

class DeviceModelAttributeService
{

    /**
     * Get all available specifications and options for a device model.
     *
     * Groups the allowed options by attribute and returns a
     * structured collection ready for API responses or forms.
     *
     * Example:
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
     * @param DeviceModel $deviceModel
     * @return \Illuminate\Support\Collection
     */
    public function getSpecificationsWithOptions(DeviceModel $deviceModel)
    {
        return $deviceModel->allowed_options
            ->groupBy('specAttribute.id')
            ->map(function ($options) {
                $attribute = $options->first()->specAttribute;

                return [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'unit' => strtolower($attribute->unit) !== 'none'
                        ? $attribute->unit
                        : null,
                    'options' => $options,
                ];
            })
            ->values();
    }
}
