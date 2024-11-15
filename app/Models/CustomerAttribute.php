<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name',
        'unit',
        'display_type',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}