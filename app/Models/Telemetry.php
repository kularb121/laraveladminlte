<?php

namespace App\Models;

use App\Models\CustomerAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsTo(Device::class, 'device_id');
    }

    // public function attribute()
    // {
    //     return $this->belongsTo(CustomerAttribute::class, 'key', 'name');
    // }
}