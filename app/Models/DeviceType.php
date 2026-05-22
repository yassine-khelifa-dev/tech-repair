<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    public $fillable = ['name', 'slug'];

    public function deviceModels(){
        return $this->hasMany(DeviceModel::class);
    }

    public function specAttributes(){
        return $this->belongsToMany( SpecAttribute::class, 'spec_attribute_device_type');
    }

}
