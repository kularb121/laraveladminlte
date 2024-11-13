<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'name',
        'unit',
        'display_type',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    // Optional: Relationship to Telemetry if needed
    // public function telemetries()
    // {
    //     return $this->hasMany(Telemetry::class, 'key', 'name');
    // }
}