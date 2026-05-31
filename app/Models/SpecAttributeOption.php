<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecAttributeOption extends Model
{
    protected $fillable = [
        'value',
        'label',
        'sort_order',
        'is_active',
        'spec_attribute_id'
    ];


    public function specAttribute()
    {
        return $this->belongsTo(SpecAttribute::class);
    }

    public function repairTickets()
    {
        return $this->belongsToMany(
            RepairTicket::class,
            'repair_ticket_options', // table pivot
            'spec_attribute_option_id',
            'repair_ticket_id'
        );
    }
}
