<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'note',
        'note2',
        'note3',
    ];

        /**
     * Define a one-to-many relationship with the Site model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sites()
    {
        return $this->hasMany(Site::class, 'customer_id');
    }

    public function devices()
    {
        return $this->hasMany(Device::class, 'customer_id');
    }

    public function attributes()
    {
        return $this->hasMany(CustomerAttribute::class, 'customer_id'); // Explicitly define foreign key
    }
}