<?php

namespace App\Http\Controllers\API\Passenger;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $routes = Route::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('route_number', 'like', "%{$query}%")
                    ->orWhere('start_point', 'like', "%{$query}%")
                    ->orWhere('end_point', 'like', "%{$query}%");
            })
            ->with(['busStops', 'buses'])
            ->get();

        return response()->json($routes);
    }

    public function show($id)
    {
        $route = Route::with(['busStops', 'buses.driver', 'buses.latestLocation'])
            ->findOrFail($id);

        return response()->json($route);
    }
}
