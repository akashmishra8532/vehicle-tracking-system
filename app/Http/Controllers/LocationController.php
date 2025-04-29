<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    //
    public function store(Request $request, $id)
{
    $request->validate([
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    $location = new Location();
    $location->vehicle_id = $id;
    $location->latitude = $request->latitude;
    $location->longitude = $request->longitude;
    $location->recorded_at = now();
    $location->save();

    broadcast(new \App\Events\LocationUpdated($location)); // for real-time

    return response()->json(['message' => 'Location updated.']);
}

}
