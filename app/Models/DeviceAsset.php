<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'asset_id',
        'state_date',
        'stop_date',
        'status_id',
        'note',
        'note2',
        'note3',
    ];
}