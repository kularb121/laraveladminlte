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

    /**
     * Define a many-to-one relationship with the Device model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    /**
     * Define a many-to-one relationship with the Asset model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    /**
     * Define a many-to-one relationship with the Status model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}

// In app/Http/Controllers/IotApplicationController.php

