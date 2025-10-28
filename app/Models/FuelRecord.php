<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelRecord extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_id', 'date', 'liters', 'cost', 'remarks'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
