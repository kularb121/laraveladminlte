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

    public function asset()
    {
        
        return $this->belongsTo(Asset::class);
    }

    public function site()
    {

        return $this->belongsTo(Site::class);
    }

    public function status()
    {

        return $this->belongsTo(Status::class);
    }
}