<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Route;
use App\Models\BusStop;
use App\Models\Trip;
use App\Models\User;
use App\Models\Role;
use App\Models\GpsLocation;
use App\Models\EmergencyAlert;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalBuses = Bus::count();
        $activeBuses = Bus::where('status', 'active')->count();
        $totalRoutes = Route::where('is_active', true)->count();
        $totalStops = BusStop::where('is_active', true)->count();

        $driverRole = Role::where('name', 'driver')->first();
        $totalDrivers = $driverRole ? User::where('role_id', $driverRole->id)->count() : 0;

        $tripsToday = Trip::whereDate('started_at', $today)->count();
        $completedTripsToday = Trip::whereDate('started_at', $today)->where('status', 'completed')->count();
        $ongoingTrips = Trip::where('status', 'ongoing')->count();

        $totalDistanceToday = Trip::whereDate('started_at', $today)
            ->where('status', 'completed')
            ->sum('distance_covered');

        $avgSpeed = GpsLocation::whereDate('recorded_at', $today)
            ->where('speed', '>', 0)
            ->avg('speed') ?? 0;

        $activeAlerts = EmergencyAlert::where('status', 'pending')->count();

        return response()->json([
            'total_buses' => $totalBuses,
            'active_buses' => $activeBuses,
            'total_routes' => $totalRoutes,
            'total_stops' => $totalStops,
            'total_drivers' => $totalDrivers,
            'trips_today' => $tripsToday,
            'completed_trips_today' => $completedTripsToday,
            'ongoing_trips' => $ongoingTrips,
            'total_distance_today' => round($totalDistanceToday, 2),
            'avg_speed' => round($avgSpeed, 1),
            'active_alerts' => $activeAlerts,
            'passengers_today' => $tripsToday * 25, // estimated
        ]);
    }
}
