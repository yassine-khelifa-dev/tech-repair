<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairRequest extends Model
{
   protected $fillable = ['data','converted_ticket_id', 'response' , 'status'];
}
