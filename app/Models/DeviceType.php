<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    public $fillable = ['name', 'slug'];

    public function deviceModels(){
        return $this->hasMany(DeviceModel::class);
    }

}
