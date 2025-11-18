<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'license_plate',
        'ac_price',
        'non_ac_price',
        'ac_price_per_day',
        'non_ac_price_per_day',
    ];

    /**
     * Vehicle has many Bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Vehicle has many Drivers
     */
    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }
}
