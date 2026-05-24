<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            [
                'route_number' => 'R-01',
                'name' => 'City Center → Airport',
                'start_point' => 'Hawa Mahal',
                'end_point' => 'Jaipur Airport',
                'distance' => 15.5,
                'estimated_duration' => 35,
                'color' => '#3B82F6',
                'is_active' => true,
            ],
            [
                'route_number' => 'R-02',
                'name' => 'Station → University',
                'start_point' => 'Jaipur Junction',
                'end_point' => 'Rajasthan University',
                'distance' => 12.3,
                'estimated_duration' => 28,
                'color' => '#10B981',
                'is_active' => true,
            ],
            [
                'route_number' => 'R-03',
                'name' => 'Mall → Old City',
                'start_point' => 'World Trade Park',
                'end_point' => 'Amer Fort',
                'distance' => 18.7,
                'estimated_duration' => 42,
                'color' => '#F59E0B',
                'is_active' => true,
            ],
            [
                'route_number' => 'R-04',
                'name' => 'Hospital → Market',
                'start_point' => 'SMS Hospital',
                'end_point' => 'Johari Bazaar',
                'distance' => 8.2,
                'estimated_duration' => 20,
                'color' => '#EF4444',
                'is_active' => true,
            ],
            [
                'route_number' => 'R-05',
                'name' => 'Tech Park → Mansarovar',
                'start_point' => 'Mahindra SEZ',
                'end_point' => 'Mansarovar Metro',
                'distance' => 22.1,
                'estimated_duration' => 50,
                'color' => '#8B5CF6',
                'is_active' => true,
            ],
        ];

        foreach ($routes as $route) {
            Route::firstOrCreate(['route_number' => $route['route_number']], $route);
        }
    }
}
