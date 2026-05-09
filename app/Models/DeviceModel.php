<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    protected $fillable = ['name', 'slug', 'brand_id', 'type_id'];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function type(){
        return $this->belongsTo(DeviceType::class, 'type_id');
    }

}
