<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $fillable = ['vehicle_id','title','amount','date','notes'];

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }
}
