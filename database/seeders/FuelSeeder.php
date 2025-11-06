<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fuel;
use App\Models\Vehicle;
use App\Models\Driver;

class FuelSeeder extends Seeder
{
    public function run()
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        if($vehicles->count() == 0 || $drivers->count() == 0){
            $this->command->info("Please create some Vehicles and Drivers first!");
            return;
        }

        foreach (range(1, 20) as $i) {
            Fuel::create([
                'vehicle_id' => $vehicles->random()->id,
                'driver_id' => $drivers->random()->id,
                'date' => now()->subDays(rand(0, 10)),
                'quantity' => rand(10, 60),       // Fuel quantity in liters
                'price' => rand(50, 300),         // Price in $
            ]);
        }
    }
}
