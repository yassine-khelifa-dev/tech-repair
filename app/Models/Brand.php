<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public $fillable = ['name', 'slug'];


    public function deviceModels()
    {
        return $this->hasMany(DeviceModel::class);
    }
}
