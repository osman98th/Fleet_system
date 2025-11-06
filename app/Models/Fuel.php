<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'date',
        'liters',
        'cost',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
