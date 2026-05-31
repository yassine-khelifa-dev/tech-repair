<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairTicketImage extends Model
{
    protected $fillable = [
        'repair_ticket_id',
        'path',
        'description'
    ];

    public function ticket(){
        return $this->belongsTo(RepairTicket::class);
    }
}
