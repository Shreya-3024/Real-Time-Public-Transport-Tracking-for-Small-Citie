<?php

namespace App\Http\Controllers\API\Passenger;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\BusStop;
use Illuminate\Http\Request;

class NearbyBusController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'nullable|numeric|min:0.1|max:50',
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;
        $radius = $request->get('radius', 5); // km

        $buses = Bus::where('status', 'active')
            ->with(['route', 'driver', 'latestLocation'])
            ->get()
            ->filter(function ($bus) use ($lat, $lng, $radius) {
                $location = $bus->latestLocation;
                if (!$location) return false;
                $distance = $this->haversine($lat, $lng, $location->latitude, $location->longitude);
                return $distance <= $radius;
            })
            ->map(function ($bus) use ($lat, $lng) {
                $location = $bus->latestLocation;
                $distance = $this->haversine($lat, $lng, $location->latitude, $location->longitude);
                return [
                    'id' => $bus->id,
                    'bus_number' => $bus->bus_number,
                    'route' => $bus->route,
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'speed' => $location->speed,
                    'distance_km' => round($distance, 2),
                    'eta_minutes' => round(($distance / max($location->speed, 15)) * 60, 0),
                ];
            })
            ->sortBy('distance_km')
            ->values();

        return response()->json($buses);
    }

    public function stops(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'nullable|numeric|min:0.1|max:10',
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;
        $radius = $request->get('radius', 2); // km

        $stops = BusStop::where('is_active', true)
            ->with('route')
            ->get()
            ->filter(function ($stop) use ($lat, $lng, $radius) {
                $distance = $this->haversine($lat, $lng, $stop->latitude, $stop->longitude);
                return $distance <= $radius;
            })
            ->map(function ($stop) use ($lat, $lng) {
                $distance = $this->haversine($lat, $lng, $stop->latitude, $stop->longitude);
                return [
                    'id' => $stop->id,
                    'name' => $stop->name,
                    'address' => $stop->address,
                    'latitude' => $stop->latitude,
                    'longitude' => $stop->longitude,
                    'route' => $stop->route,
                    'distance_km' => round($distance, 2),
                ];
            })
            ->sortBy('distance_km')
            ->values();

        return response()->json($stops);
    }

    private function haversine($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}
