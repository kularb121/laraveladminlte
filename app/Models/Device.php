<?php

namespace App\Models;

// use App\Models\Status;
// use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    //This help to show the parent data from status.
    public function status()
    {
        // return $this->belongsTo(Status::class, 'status');
        return $this->belongsTo(Status::class);
    }

    //This help to show the parent data from customer.
    public function customer()
    {

        return $this->belongsTo(Customer::class);
    }
    
}
