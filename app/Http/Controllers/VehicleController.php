<?php
namespace App\Http\Controllers;
use App\Models\Location;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    //
    public function showMap($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $latestLocation = Location::where('vehicle_id', $id)
            ->latest('recorded_at')
            ->first();    
        if (!$latestLocation) {
            return "No location data found for vehicle ID: $id";
        }
        return view('map', [
            'latitude' => $latestLocation->latitude,
            'longitude' => $latestLocation->longitude,
            'vehicle_id' => $id
        ]);
    } 
    public function getLocation($id) {
        $vehicle = Vehicle::findOrFail($id);
        return response()->json([
            'lat' => $vehicle->latitude,
            'lng' => $vehicle->longitude
        ]);
    }


    public function getLatestLocation($id)
    {
        $location = Location::where('vehicle_id', $id)
                    ->latest('recorded_at')
                    ->first();

    return response()->json($location);
    }

    public function simulateMove($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json(['error' => 'Vehicle not found'], 404);
        }

        $lat = 28.6139 + ((rand(-100, 100)) / 10000); // Random lat near Delhi
        $lng = 77.2090 + ((rand(-100, 100)) / 10000); // Random lng near Delhi

        Location::create([
            'vehicle_id' => $vehicle->id,
            'latitude' => $lat,
            'longitude' => $lng,
            'recorded_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'lat' => $lat,
            'lng' => $lng,
        ]);
    }

    
}

