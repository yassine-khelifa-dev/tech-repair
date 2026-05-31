<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
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
