<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAttribute extends Model
{
    protected $fillable = ['name', 'code', 'input_type', 'is_filterable',
                           'sort_order', 'is_required', 'device_type_id'];


   public function type(){
        return $this->belongsTo(DeviceType::class, 'device_type_id');
    }

    public function options(){
        return $this->hasMany(DeviceAttributeOption::class);
    }

}


