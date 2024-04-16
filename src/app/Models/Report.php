<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function monitoringData(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MonitoringData::class);
    }
}
