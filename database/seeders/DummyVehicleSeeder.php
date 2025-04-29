<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()

    {
    
        $vehicle = \App\Models\Vehicle::create([
    
            'name' => 'Test Vehicle',
    
            'plate_number' => 'TEST123'
    
        ]);
    
    
    
        \App\Models\Location::create([
    
            'vehicle_id' => $vehicle->id,
    
            'latitude' => 28.6139,
    
            'longitude' => 77.2090,
    
            'recorded_at' => now(),
    
        ]);
    
    
    
    }
    
    

}
