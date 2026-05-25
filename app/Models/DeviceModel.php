<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    protected $fillable = ['name', 'slug', 'brand_id', 'device_type_id', 'is_active'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function type()
    {
        return $this->belongsTo(DeviceType::class, 'device_type_id');
    }


    public function allowed_options()
    {
        return $this->belongsToMany(
            SpecAttributeOption::class,
            'device_model_allowed_options',
            'device_model_id',
            'spec_attribute_option_id'
        );
    }
}
