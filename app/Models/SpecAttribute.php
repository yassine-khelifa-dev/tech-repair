<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecAttribute extends Model
{
    protected $fillable = ['name',
                            'code',
                            'input_type',
                            'unit',
                            'is_filterable',
                            'sort_order',
                            'is_required'
                        ];


    public function specOptions(){
        return $this->hasMany(SpecAttributeOption::class);
    }


    public function deviceTypes(){
        return $this->belongsToMany( DeviceType::class, 'spec_attribute_device_type');
    }
}
