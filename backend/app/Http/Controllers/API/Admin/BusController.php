<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::with(['route', 'driver'])->get();
        return response()->json($buses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_number' => 'required|string|unique:buses,bus_number',
            'registration_number' => 'required|string|unique:buses,registration_number',
            'model' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'route_id' => 'required|exists:routes,id',
            'driver_id' => 'nullable|exists:users,id',
            'status' => 'nullable|in:active,maintenance,inactive',
            'year_of_manufacture' => 'nullable|integer',
        ]);

        $bus = Bus::create($request->all());
        $bus->load(['route', 'driver']);

        return response()->json($bus, 201);
    }

    public function show(Bus $bus)
    {
        $bus->load(['route', 'driver', 'trips', 'gpsLocations' => function ($q) {
            $q->latest('recorded_at')->limit(10);
        }]);

        return response()->json($bus);
    }

    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'bus_number' => 'sometimes|string|unique:buses,bus_number,' . $bus->id,
            'registration_number' => 'sometimes|string|unique:buses,registration_number,' . $bus->id,
            'model' => 'sometimes|string',
            'capacity' => 'sometimes|integer|min:1',
            'route_id' => 'sometimes|exists:routes,id',
            'driver_id' => 'nullable|exists:users,id',
            'status' => 'sometimes|in:active,maintenance,inactive',
            'year_of_manufacture' => 'nullable|integer',
        ]);

        $bus->update($request->all());
        $bus->load(['route', 'driver']);

        return response()->json($bus);
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();
        return response()->json(['message' => 'Bus deleted successfully']);
    }
}
