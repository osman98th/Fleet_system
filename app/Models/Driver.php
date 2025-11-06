<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'phone',
        'vehicle_id',
        'driver_availability', // 'yes' or 'no'
    ];

    // Driver belongs to a vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    // Driver can have many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'driver_id');
    }
}
