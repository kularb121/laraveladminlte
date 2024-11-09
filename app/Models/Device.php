<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'status_id',
        'mobile_number',
        'manu_date',
        'customer_id',
        'note',
        'note2',
        'note3',
    ];

    //This help to show the parent data.
    public function status()
    {
        return $this->belongsTo(Status::class, 'status');
    }
}
