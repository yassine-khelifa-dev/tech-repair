<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairLog extends Model
{
    protected $fillable = [
        'repair_ticket_id',
        'user_id', 'message',
         'old_status',
          'new_status',
          'is_visible_to_customer'
    ];

    protected $casts = [
        'is_visible_to_customer' => 'boolean',
    ];

    public function ticket(){
        return $this->belongsTo(RepairTicket::class,'repair_ticket_id');
    }

    public function images(){
        return $this->hasMany(RepairLogImage::class, 'repair_log_id');
    }
}

