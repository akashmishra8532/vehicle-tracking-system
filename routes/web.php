<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Models\Location;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vehicle/{id}/map', [VehicleController::class, 'showMap']);


Route::get('/api/vehicle/{id}/location', function($id) {
    $location = \App\Models\Location::where('vehicle_id', $id)->latest('recorded_at')->first();
    return response()->json([
        'latitude' => $location->latitude,
        'longitude' => $location->longitude
    ]);
});

Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/vehicles/{id}/locations', [LocationController::class, 'getVehicleLocations']);
Route::post('/vehicles/{id}/locations', [LocationController::class, 'store']);



Route::get('/api/vehicle/{id}/location', [VehicleController::class, 'getLatestLocation']);
Route::get('/simulate-move/{id}', [VehicleController::class, 'simulateMove']);




Route::get('/simulate-move/{id}', function ($id) {
    $lastLocation = Location::where('vehicle_id', $id)->latest('recorded_at')->first();

    if (!$lastLocation) {
        return response()->json(['error' => 'No location found'], 404);
    }

    $newLat = $lastLocation->latitude + (rand(-10, 10) / 10000);
    $newLng = $lastLocation->longitude + (rand(-10, 10) / 10000);

    Location::create([
        'vehicle_id' => $id,
        'latitude' => $newLat,
        'longitude' => $newLng,
        'recorded_at' => now(),
    ]);

    return response()->json(['message' => 'Vehicle moved!', 'lat' => $newLat, 'lng' => $newLng]);
});

Route::get('/get-location/{id}', function ($id) {
    $location = Location::where('vehicle_id', $id)->latest()->first();

    if ($location) {
        return response()->json([
            'lat' => $location->latitude,
            'lng' => $location->longitude,
        ]);
    } else {
        return response()->json([
            'error' => 'No location found'
        ]);
    }
});


Route::get('/map', function () {
    return view('map');
});
