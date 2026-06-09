<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;
use Carbon\Carbon;

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

    protected $casts = [
        'received_at'  => 'datetime',
        'completed_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    #[Override]
    protected static function booted()
    {
        static::creating(function ($repair_ticket) {
            $repair_ticket->ticket_number =
                'RT-' . Carbon::now()->format('YmdHis') . '-' . random_int(100, 999);
            $repair_ticket->received_at = now();
        });
    }


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
        return $this->hasMany(RepairTicketImage::class);
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

    public function logs(){
        return $this->hasMany(RepairLog::class, 'repair_ticket_id', 'id');
    }
}
