<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::with(['busStops', 'buses'])->get();
        return response()->json($routes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'route_number' => 'required|string|unique:routes,route_number',
            'name' => 'required|string',
            'start_point' => 'required|string',
            'end_point' => 'required|string',
            'distance' => 'required|numeric|min:0',
            'estimated_duration' => 'required|integer|min:1',
            'color' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $route = Route::create($request->all());
        $route->load(['busStops', 'buses']);

        return response()->json($route, 201);
    }

    public function show(Route $route)
    {
        $route->load(['busStops', 'buses.driver', 'trips' => function ($q) {
            $q->latest()->limit(20);
        }]);

        return response()->json($route);
    }

    public function update(Request $request, Route $route)
    {
        $request->validate([
            'route_number' => 'sometimes|string|unique:routes,route_number,' . $route->id,
            'name' => 'sometimes|string',
            'start_point' => 'sometimes|string',
            'end_point' => 'sometimes|string',
            'distance' => 'sometimes|numeric|min:0',
            'estimated_duration' => 'sometimes|integer|min:1',
            'color' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $route->update($request->all());
        $route->load(['busStops', 'buses']);

        return response()->json($route);
    }

    public function destroy(Route $route)
    {
        $route->delete();
        return response()->json(['message' => 'Route deleted successfully']);
    }
}
