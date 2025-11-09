<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    // If the table name follows Laravel convention, this is optional
    // protected $table = 'customers';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    /**
     * Get all bookings for this customer
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

     public function users()
    {
        return $this->belongsTo(User::class);
    }
}
