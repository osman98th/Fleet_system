<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
    ];

    // A user has one customer profile
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A customer can have many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
