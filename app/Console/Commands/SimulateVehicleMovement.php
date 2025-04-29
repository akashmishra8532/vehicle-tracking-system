<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Location;
use App\Models\Vehicle;

class SimulateVehicleMovement extends Command
{
    protected $signature = 'simulate:move';
    protected $description = 'Simulates vehicle movement by inserting new locations';

    public function handle()
    {
        // Change to the vehicle ID you want to simulate
        $vehicleId = 1;

        $lastLocation = Location::where('vehicle_id', $vehicleId)->latest('recorded_at')->first();

        // Set default location if none exists
        $lat = $lastLocation ? $lastLocation->latitude : 28.6139;
        $lng = $lastLocation ? $lastLocation->longitude : 77.2090;

        // Simulate slight movement
        $lat += (rand(-10, 10) / 10000);
        $lng += (rand(-10, 10) / 10000);

        Location::create([
            'vehicle_id' => $vehicleId,
            'latitude' => $lat,
            'longitude' => $lng,
            'recorded_at' => now(),
        ]);

        $this->info("New location inserted: ($lat, $lng)");
    }
}

