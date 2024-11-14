<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'status_id',
        'note',
        'note2',
        'note3',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey())
            {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Define a many-to-one relationship with the Status model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        // return $this->belongsTo(Status::class, 'status');
        return $this->belongsTo(Status::class, 'status_id');
    }
    
    public function devices()
    {
        return $this->belongsToMany(Device::class, 'device_assets'); 
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'asset_sites'); 
    }
}