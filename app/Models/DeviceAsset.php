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
        'start_date',
        'stop_date',
        'status_id',
        'note',
        'note2',
        'note3',
    ];

    public function device()
    {

        return $this->belongsTo(Device::class);
    }

    public function asset()
    {

        return $this->belongsTo(Asset::class);
    }

    public function status()
    {
        // return $this->belongsTo(Status::class, 'status');
        return $this->belongsTo(Status::class);
    }
}