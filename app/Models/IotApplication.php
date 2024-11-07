<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class IotApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'asset_id',
        'start_date',
        'stop_date',
        'status',
        'note',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}

// In app/Http/Controllers/IotApplicationController.php

