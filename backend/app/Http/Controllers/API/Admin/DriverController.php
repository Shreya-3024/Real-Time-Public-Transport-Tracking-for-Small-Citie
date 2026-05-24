<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function index()
    {
        $driverRole = Role::where('name', 'driver')->first();
        $drivers = User::where('role_id', $driverRole->id)
            ->with(['drivingBuses.route'])
            ->get();

        return response()->json($drivers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|unique:users,phone',
            'password' => 'required|string|min:6',
        ]);

        $driverRole = Role::where('name', 'driver')->first();

        $driver = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $driverRole->id,
        ]);

        $driver->load('role');

        return response()->json($driver, 201);
    }

    public function show(User $driver)
    {
        $driver->load(['role', 'drivingBuses.route', 'trips' => function ($q) {
            $q->latest()->limit(10);
        }]);

        return response()->json($driver);
    }

    public function update(Request $request, User $driver)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $driver->id,
            'phone' => 'nullable|string|unique:users,phone,' . $driver->id,
            'is_active' => 'sometimes|boolean',
        ]);

        $driver->update($request->only(['name', 'email', 'phone', 'is_active']));

        return response()->json($driver);
    }

    public function destroy(User $driver)
    {
        $driver->delete();
        return response()->json(['message' => 'Driver deleted successfully']);
    }
}
