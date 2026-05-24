<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Admin;
use App\Http\Controllers\API\Driver;
use App\Http\Controllers\API\Passenger;

// Public routes
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout']);

    // Get current user
    Route::get('/user', function (\Illuminate\Http\Request $request) {
        $user = $request->user()->load('role');
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'role' => $user->role->name,
            'avatar' => $user->avatar,
            'is_active' => $user->is_active,
        ]);
    });

    // Admin routes
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::apiResource('buses', Admin\BusController::class);
        Route::apiResource('drivers', Admin\DriverController::class);
        Route::apiResource('routes', Admin\RouteController::class);
        Route::apiResource('bus-stops', Admin\BusStopController::class);
        Route::get('analytics', [Admin\AnalyticsController::class, 'index']);
        Route::get('emergency-alerts', [Admin\EmergencyAlertController::class, 'index']);
        Route::patch('emergency-alerts/{id}/acknowledge', [Admin\EmergencyAlertController::class, 'acknowledge']);
    });

    // Driver routes
    Route::prefix('driver')->middleware('role:driver')->group(function () {
        Route::post('trips/start', [Driver\TripController::class, 'start']);
        Route::post('trips/{id}/end', [Driver\TripController::class, 'end']);
        Route::get('trips/active', [Driver\TripController::class, 'active']);
        Route::get('trips/history', [Driver\TripController::class, 'history']);
        Route::post('location/update', [Driver\LocationController::class, 'update']);
        Route::post('emergency/trigger', [Driver\EmergencyController::class, 'trigger']);
    });

    // Passenger routes
    Route::prefix('passenger')->group(function () {
        Route::get('buses/live', [Passenger\BusTrackingController::class, 'live']);
        Route::get('buses/{id}/track', [Passenger\BusTrackingController::class, 'track']);
        Route::get('routes/search', [Passenger\RouteSearchController::class, 'search']);
        Route::get('routes/{id}', [Passenger\RouteSearchController::class, 'show']);
        Route::get('nearby-buses', [Passenger\NearbyBusController::class, 'index']);
        Route::get('nearby-stops', [Passenger\NearbyBusController::class, 'stops']);
    });
});
