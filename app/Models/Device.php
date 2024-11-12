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

    /**
     * Define a many-to-one relationship with the Customer model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
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
    public function telemetries()
    {
        return $this->hasMany(Telemetry::class);
    }
}
