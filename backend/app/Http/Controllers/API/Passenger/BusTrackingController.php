<?php

namespace App\Http\Controllers\API\Passenger;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\GpsLocation;
use Illuminate\Http\Request;

class BusTrackingController extends Controller
{
    public function live(Request $request)
    {
        $query = Bus::where('status', 'active')
            ->with(['route', 'driver', 'latestLocation']);

        if ($request->has('route_id')) {
            $query->where('route_id', $request->route_id);
        }

        $buses = $query->get()->map(function ($bus) {
            $location = $bus->latestLocation;
            return [
                'id' => $bus->id,
                'bus_number' => $bus->bus_number,
                'registration_number' => $bus->registration_number,
                'model' => $bus->model,
                'capacity' => $bus->capacity,
                'status' => $bus->status,
                'route_id' => $bus->route_id,
                'route' => $bus->route,
                'driver' => $bus->driver ? [
                    'id' => $bus->driver->id,
                    'name' => $bus->driver->name,
                ] : null,
                'latitude' => $location ? $location->latitude : null,
                'longitude' => $location ? $location->longitude : null,
                'speed' => $location ? $location->speed : 0,
                'heading' => $location ? $location->heading : 0,
                'last_updated' => $location ? $location->recorded_at : null,
            ];
        });

        return response()->json($buses);
    }

    public function track($id)
    {
        $bus = Bus::with(['route.busStops', 'driver', 'latestLocation'])->findOrFail($id);

        $recentLocations = GpsLocation::where('bus_id', $id)
            ->orderByDesc('recorded_at')
            ->limit(20)
            ->get();

        return response()->json([
            'bus' => $bus,
            'recent_locations' => $recentLocations,
        ]);
    }
}
