<?php

namespace App\Http\Controllers\API\Driver;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\Bus;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TripController extends Controller
{
    public function start(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
        ]);

        // Check if driver already has an active trip
        $activeTrip = Trip::where('driver_id', $request->user()->id)
            ->where('status', 'ongoing')
            ->first();

        if ($activeTrip) {
            return response()->json(['message' => 'You already have an active trip.'], 422);
        }

        $trip = Trip::create([
            'bus_id' => $request->bus_id,
            'driver_id' => $request->user()->id,
            'route_id' => $request->route_id,
            'started_at' => Carbon::now(),
            'status' => 'ongoing',
        ]);

        $trip->load(['bus', 'route.busStops']);

        return response()->json($trip, 201);
    }

    public function end($id)
    {
        $trip = Trip::where('id', $id)
            ->where('driver_id', request()->user()->id)
            ->where('status', 'ongoing')
            ->firstOrFail();

        $duration = Carbon::now()->diffInMinutes(Carbon::parse($trip->started_at));

        $trip->update([
            'ended_at' => Carbon::now(),
            'duration' => $duration,
            'status' => 'completed',
        ]);

        $trip->load(['bus', 'route']);

        return response()->json($trip);
    }

    public function active()
    {
        $trip = Trip::where('driver_id', request()->user()->id)
            ->where('status', 'ongoing')
            ->with(['bus', 'route.busStops'])
            ->first();

        return response()->json($trip);
    }

    public function history()
    {
        $trips = Trip::where('driver_id', request()->user()->id)
            ->with(['bus', 'route'])
            ->orderByDesc('started_at')
            ->limit(50)
            ->get();

        return response()->json($trips);
    }
}
