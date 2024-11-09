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
    ];

    //This help to show the child data.
    public function devices()
    {
        return $this->hasMany(Device::class, 'status');
    }
}
