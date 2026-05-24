<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusStop;
use Illuminate\Http\Request;

class BusStopController extends Controller
{
    public function index()
    {
        $stops = BusStop::with('route')->orderBy('route_id')->orderBy('stop_order')->get();
        return response()->json($stops);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'route_id' => 'required|exists:routes,id',
            'stop_order' => 'required|integer|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        $stop = BusStop::create($request->all());
        $stop->load('route');

        return response()->json($stop, 201);
    }

    public function show(BusStop $busStop)
    {
        $busStop->load('route');
        return response()->json($busStop);
    }

    public function update(Request $request, BusStop $busStop)
    {
        $request->validate([
            'name' => 'sometimes|string',
            'address' => 'sometimes|string',
            'latitude' => 'sometimes|numeric',
            'longitude' => 'sometimes|numeric',
            'route_id' => 'sometimes|exists:routes,id',
            'stop_order' => 'sometimes|integer|min:1',
            'is_active' => 'sometimes|boolean',
        ]);

        $busStop->update($request->all());
        $busStop->load('route');

        return response()->json($busStop);
    }

    public function destroy(BusStop $busStop)
    {
        $busStop->delete();
        return response()->json(['message' => 'Bus stop deleted successfully']);
    }
}
