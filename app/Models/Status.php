<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'note'
    ];

    /**
     * Define a one-to-many relationship with the Device model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices()
    {
        return $this->hasMany(Device::class, 'status_id');
    }

    /**
     * Define a one-to-many relationship with the Asset model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assets()
    {
        return $this->hasMany(Asset::class, 'status_id');
    }

    /**
     * Define a one-to-many relationship with the Site model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sites()
    {
        return $this->hasMany(Site::class, 'status_id');
    }

    /**
     * Define a one-to-many relationship with the DeviceAsset model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deviceAssets()
    {
        return $this->hasMany(DeviceAsset::class, 'status_id');
    }
}
