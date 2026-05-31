<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairTicket extends Model
{
    protected $fillable = [
        'ticket_number',
        'device_access_info',
        'customer_id',
        'technician_note',
        'final_price',
        'estimated_price',
        'received_at',
        'completed_at',
        'delivered_at',
        'issue_description',
        'status',
        'sn',
        'imei',
        'device_model_id'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function deviceModel()
    {
        return $this->belongsTo(DeviceModel::class);
    }

    public function photos()
    {
        return $this->hasMany(RepairTicketImage::class );
    }

    public function selectedOptions()
    {
        return  $this->belongsToMany(
            SpecAttributeOption::class,
            'repair_ticket_options', // table pivot
            'repair_ticket_id',
            'spec_attribute_option_id'
        )->withTimestamps();
    }
}
