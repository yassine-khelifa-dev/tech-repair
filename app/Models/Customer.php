<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use Notifiable;
    protected $fillable = [
        'fullname',
        'email',
        'phone',
        'note'
    ];

    public function tickets(){
        return $this->hasMany(RepairTicket::class);
    }
}
