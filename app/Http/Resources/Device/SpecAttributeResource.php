<?php

namespace App\Http\Resources\Device;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'unit' => $this->when($this->unit != 'None', $this->unit),
            'options' => SpecAttributeOptionResource::collection( $this->whenLoaded('specOptions'))
        ];
        
    }
}

