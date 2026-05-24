<?php

namespace App\Http\Controllers\API\Driver;

use App\Http\Controllers\Controller;
use App\Models\GpsLocation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LocationController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'speed' => 'nullable|numeric|min:0',
            'heading' => 'nullable|numeric|min:0|max:360',
        ]);

        // Find active trip for this bus
        $trip = \App\Models\Trip::where('bus_id', $request->bus_id)
            ->where('driver_id', $request->user()->id)
            ->where('status', 'ongoing')
            ->first();

        $location = GpsLocation::create([
            'bus_id' => $request->bus_id,
            'trip_id' => $trip ? $trip->id : null,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'speed' => $request->speed ?? 0,
            'heading' => $request->heading,
            'recorded_at' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Location updated successfully',
            'location' => $location,
        ]);
    }
}
