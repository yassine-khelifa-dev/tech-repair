<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairRequest extends Model
{
    protected $fillable = ['data', 'converted_ticket_id', 'response', 'status'];

    protected $casts = [
        'data'  => 'array',
    ];

    public function getFullnameAttribute(): ?string
    {
        return $this->data['fullname'] ?? null;
    }

    public function getPhoneAttribute(): ?string
    {
        return $this->data['phone'] ?? null;
    }

    public function getEmailAttribute(): ?string
    {
        return $this->data['email'] ?? null;
    }

    public function getDeviceModelIdAttribute(): ?int
    {
        return $this->data['device_model_id'] ?? null;
    }
}
