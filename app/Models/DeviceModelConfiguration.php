<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceModelConfiguration extends Model {

    protected $table = 'device_model_allowed_options'; 

    public $fillable = ['device_model_id', 'spec_attribute_option_id', 'is_active', 'sort_order'];

}
