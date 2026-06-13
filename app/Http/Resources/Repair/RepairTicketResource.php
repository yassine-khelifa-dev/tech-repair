<?php

namespace App\Http\Resources\Repair;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepairTicketResource extends JsonResource
{

    public static $wrap = 'tickets';

    /**
     * Transform the resource into an array.
     * 'ticket_number',
     *  'device_access_info',
     *  'customer_id',
     * 'technician_note',
     * 'final_price',
     * 'estimated_price',
     * 'received_at',
     * 'completed_at',
     * 'delivered_at',
     * 'issue_description',
     * 'status',
     * 'sn',
     * 'public_token',
     * 'imei',
     * 'device_model_id'
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'customer_id'       => $this->customer_id,
            'device_model_id' => $this->device_model_id,
            'received_at'       =>  $this->received_at->format('Y-m-d H:i:s'),
            'issue_description' => $this->issue_description,
            'status' => $this->status,
            'technician_note' =>  $this->whenNotNull($this->technician_note),
            'final_price' => $this->whenNotNull($this->final_price),
        ];
    }
}
