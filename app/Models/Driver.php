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
        'vehicle_id',
        'phone',
        'license_number',
    ];

    /**
     * Driver belongs to a Vehicle
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Driver has many Bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
