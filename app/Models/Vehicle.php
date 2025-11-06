<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'model',
        'type',
        'license_plate',
        'ac_price',
        'non_ac_price',
        'ac_price_per_day',
        'non_ac_price_per_day',
        'status',
    ];

    // A vehicle can have many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'vehicle_id');
    }

    // Optional: get available drivers for this vehicle
    public function drivers()
    {
        return $this->hasMany(Driver::class, 'vehicle_id')
                    ->where('driver_availability', 'yes');
    }
}
