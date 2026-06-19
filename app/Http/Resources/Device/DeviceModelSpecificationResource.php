<?php

namespace App\Http\Resources\Device;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceModelSpecificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'unit' => strtolower($this['unit']) !== 'none' ? $this['unit'] : null,
            'options' => SpecAttributeOptionResource::collection($this['options']),
        ];
    }
}
