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
}