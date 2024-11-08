<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'manu_date',
        'status',
        'note',
    ];

    //This help to show the parent data.
    public function status()
    {
        return $this->belongsTo(Status::class, 'status');
    }
}
