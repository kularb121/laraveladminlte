<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telemetry extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'key',
        'value',
        'timestamp', // If you want to store the timestamp explicitly
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}