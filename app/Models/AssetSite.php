<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'site_id',
        'start_date',
        'stop_date',
        'status_id',
        'note',
        'note2',
        'note3',
    ];

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
     * Define a many-to-one relationship with the Site model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site()
    {

        return $this->belongsTo(Site::class, 'site_id');
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