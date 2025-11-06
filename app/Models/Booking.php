<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id','driver_id','customer_id','rent_start_date',
        'rent_end_date','car_type','charge_type','distance','fare','status'
    ];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function driver(){
        return $this->belongsTo(Driver::class);
    }

    public function customer(){
        return $this->belongsTo(User::class,'customer_id');
    }
}
