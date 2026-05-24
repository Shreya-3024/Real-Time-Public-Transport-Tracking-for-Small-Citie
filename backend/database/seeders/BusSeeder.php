<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bus;
use App\Models\Route;
use App\Models\User;
use App\Models\Role;

class BusSeeder extends Seeder
{
    public function run(): void
    {
        $driverRole = Role::where('name', 'driver')->first();
        $drivers = User::where('role_id', $driverRole->id)->get();

        $buses = [
            ['bus_number' => 'JPC-101', 'registration_number' => 'RJ-14-PA-1001', 'model' => 'Tata Starbus', 'capacity' => 40, 'route_number' => 'R-01', 'driver_email' => 'rajesh@smartcity.com', 'status' => 'active', 'year_of_manufacture' => 2022],
            ['bus_number' => 'JPC-102', 'registration_number' => 'RJ-14-PA-1002', 'model' => 'Ashok Leyland', 'capacity' => 45, 'route_number' => 'R-01', 'driver_email' => 'amit@smartcity.com', 'status' => 'active', 'year_of_manufacture' => 2023],
            ['bus_number' => 'JPC-201', 'registration_number' => 'RJ-14-PA-2001', 'model' => 'Tata Starbus', 'capacity' => 40, 'route_number' => 'R-02', 'driver_email' => 'sunil@smartcity.com', 'status' => 'active', 'year_of_manufacture' => 2021],
            ['bus_number' => 'JPC-202', 'registration_number' => 'RJ-14-PA-2002', 'model' => 'Volvo 8400', 'capacity' => 50, 'route_number' => 'R-02', 'driver_email' => 'vikram@smartcity.com', 'status' => 'active', 'year_of_manufacture' => 2023],
            ['bus_number' => 'JPC-301', 'registration_number' => 'RJ-14-PA-3001', 'model' => 'Ashok Leyland', 'capacity' => 42, 'route_number' => 'R-03', 'driver_email' => null, 'status' => 'maintenance', 'year_of_manufacture' => 2020],
            ['bus_number' => 'JPC-302', 'registration_number' => 'RJ-14-PA-3002', 'model' => 'Tata Starbus', 'capacity' => 40, 'route_number' => 'R-03', 'driver_email' => 'manoj@smartcity.com', 'status' => 'active', 'year_of_manufacture' => 2022],
            ['bus_number' => 'JPC-401', 'registration_number' => 'RJ-14-PA-4001', 'model' => 'Eicher Skyline', 'capacity' => 35, 'route_number' => 'R-04', 'driver_email' => 'deepak@smartcity.com', 'status' => 'active', 'year_of_manufacture' => 2021],
            ['bus_number' => 'JPC-501', 'registration_number' => 'RJ-14-PA-5001', 'model' => 'Volvo 8400', 'capacity' => 50, 'route_number' => 'R-05', 'driver_email' => 'ravi@smartcity.com', 'status' => 'active', 'year_of_manufacture' => 2024],
        ];

        foreach ($buses as $busData) {
            $route = Route::where('route_number', $busData['route_number'])->first();
            $driver = $busData['driver_email'] ? User::where('email', $busData['driver_email'])->first() : null;

            Bus::firstOrCreate(
                ['bus_number' => $busData['bus_number']],
                [
                    'bus_number' => $busData['bus_number'],
                    'registration_number' => $busData['registration_number'],
                    'model' => $busData['model'],
                    'capacity' => $busData['capacity'],
                    'route_id' => $route->id,
                    'driver_id' => $driver ? $driver->id : null,
                    'status' => $busData['status'],
                    'year_of_manufacture' => $busData['year_of_manufacture'],
                ]
            );
        }
    }
}
