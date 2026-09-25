<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'brand_id', 'device_type_id', 'is_active'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function type()
    {
        return $this->belongsTo(DeviceType::class, 'device_type_id');
    }

    public function tickets()
    {
        return $this->hasMany(RepairTicket::class);
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

    public function hasOptions(array $options)
    {
        $data = $this->load('type.specAttributes.specOptions');

        $all_my_options = [];

        $data->type->specAttributes->map(function ($attr)  use (&$all_my_options) {
            $all_my_options = array_merge($all_my_options, $attr->specOptions->pluck('id')->all());
        });

        return  empty(array_diff($options, $all_my_options));
    }
}
