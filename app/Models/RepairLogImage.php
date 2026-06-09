<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairLogImage extends Model
{
    protected $fillable = ['repair_log_id', 'path'];

    public function log()
    {
        return $this->belongsTo(RepairLog::class, 'repair_log_id');
    }
}
