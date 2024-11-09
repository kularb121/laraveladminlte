<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'customer_id',
        'note',
        'note2',
        'note3',
    ];

    //This help to show the parent data from customer.
    public function customer()
    {

        return $this->belongsTo(Customer::class);
    }
}