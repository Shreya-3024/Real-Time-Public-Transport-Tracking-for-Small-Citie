<?php

namespace App\Http\Controllers\API\Driver;

use App\Http\Controllers\Controller;
use App\Models\EmergencyAlert;
use App\Models\Trip;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    public function trigger(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // Find active trip
        $trip = Trip::where('bus_id', $request->bus_id)
            ->where('driver_id', $request->user()->id)
            ->where('status', 'ongoing')
            ->first();

        $alert = EmergencyAlert::create([
            'driver_id' => $request->user()->id,
            'bus_id' => $request->bus_id,
            'trip_id' => $trip ? $trip->id : null,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        $alert->load(['driver', 'bus']);

        return response()->json([
            'message' => 'Emergency alert triggered!',
            'alert' => $alert,
        ], 201);
    }
}
