<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAttributeOption extends Model
{
    protected $fillable = ['value', 'device_attribute_id', 'sort_order'];


    public function deviceAttribute(){
        return $this->belongsTo(DeviceAttribute::class);
    }
}
