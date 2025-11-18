<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'customer_id',
        'start_datetime',
        'end_datetime',
        'car_type',
        'charge_type',
        'distance',
        'fare',
        'status',
    ];

    /**
     * Booking belongs to a Vehicle
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Booking belongs to a Driver
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Booking belongs to a Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Accessor for formatted fare
     */
    public function getFormattedFareAttribute()
    {
        return number_format($this->fare, 2);
    }

    /**
     * Accessor for formatted date range
     */
    public function getFormattedDateRangeAttribute()
    {
        $start = date('d M Y', strtotime($this->start_datetime));
        $end   = date('d M Y', strtotime($this->end_datetime));
        return $start . ' - ' . $end;
    }
}
