<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusStop;
use App\Models\Route;

class BusStopSeeder extends Seeder
{
    public function run(): void
    {
        $stops = [
            // Route R-01: City Center → Airport
            ['name' => 'Hawa Mahal', 'address' => 'Hawa Mahal Rd', 'latitude' => 26.9239, 'longitude' => 75.8267, 'route_number' => 'R-01', 'stop_order' => 1],
            ['name' => 'City Palace', 'address' => 'Tulsi Marg', 'latitude' => 26.9260, 'longitude' => 75.8236, 'route_number' => 'R-01', 'stop_order' => 2],
            ['name' => 'MI Road', 'address' => 'MI Road', 'latitude' => 26.9150, 'longitude' => 75.8050, 'route_number' => 'R-01', 'stop_order' => 3],
            ['name' => 'Tonk Road', 'address' => 'Tonk Road', 'latitude' => 26.8900, 'longitude' => 75.8000, 'route_number' => 'R-01', 'stop_order' => 4],
            ['name' => 'Jaipur Airport', 'address' => 'Sanganer', 'latitude' => 26.8242, 'longitude' => 75.8122, 'route_number' => 'R-01', 'stop_order' => 5],

            // Route R-02: Station → University
            ['name' => 'Jaipur Junction', 'address' => 'Station Road', 'latitude' => 26.9196, 'longitude' => 75.7878, 'route_number' => 'R-02', 'stop_order' => 1],
            ['name' => 'Sindhi Camp', 'address' => 'Sindhi Camp', 'latitude' => 26.9226, 'longitude' => 75.7930, 'route_number' => 'R-02', 'stop_order' => 2],
            ['name' => 'Bani Park', 'address' => 'Bani Park', 'latitude' => 26.9350, 'longitude' => 75.7900, 'route_number' => 'R-02', 'stop_order' => 3],
            ['name' => 'University Gate', 'address' => 'JLN Marg', 'latitude' => 26.9050, 'longitude' => 75.8150, 'route_number' => 'R-02', 'stop_order' => 4],

            // Route R-03: Mall → Old City
            ['name' => 'World Trade Park', 'address' => 'Malviya Nagar', 'latitude' => 26.8525, 'longitude' => 75.8055, 'route_number' => 'R-03', 'stop_order' => 1],
            ['name' => 'Jawahar Circle', 'address' => 'Malviya Nagar', 'latitude' => 26.8510, 'longitude' => 75.8125, 'route_number' => 'R-03', 'stop_order' => 2],
            ['name' => 'Nahargarh Road', 'address' => 'Amer Road', 'latitude' => 26.9450, 'longitude' => 75.8150, 'route_number' => 'R-03', 'stop_order' => 3],
            ['name' => 'Amer Fort', 'address' => 'Amer', 'latitude' => 26.9855, 'longitude' => 75.8513, 'route_number' => 'R-03', 'stop_order' => 4],

            // Route R-04: Hospital → Market
            ['name' => 'SMS Hospital', 'address' => 'JLN Marg', 'latitude' => 26.9100, 'longitude' => 75.8060, 'route_number' => 'R-04', 'stop_order' => 1],
            ['name' => 'Ramniwas Bagh', 'address' => 'Ramniwas Bagh', 'latitude' => 26.9100, 'longitude' => 75.8160, 'route_number' => 'R-04', 'stop_order' => 2],
            ['name' => 'Johari Bazaar', 'address' => 'Johari Bazaar', 'latitude' => 26.9200, 'longitude' => 75.8230, 'route_number' => 'R-04', 'stop_order' => 3],

            // Route R-05: Tech Park → Mansarovar
            ['name' => 'Mahindra SEZ', 'address' => 'Mahindra World City', 'latitude' => 26.7800, 'longitude' => 75.8600, 'route_number' => 'R-05', 'stop_order' => 1],
            ['name' => 'Sitapura', 'address' => 'Sitapura Industrial', 'latitude' => 26.8000, 'longitude' => 75.8400, 'route_number' => 'R-05', 'stop_order' => 2],
            ['name' => 'Mansarovar Metro', 'address' => 'Mansarovar', 'latitude' => 26.8700, 'longitude' => 75.7700, 'route_number' => 'R-05', 'stop_order' => 3],
        ];

        foreach ($stops as $stopData) {
            $route = Route::where('route_number', $stopData['route_number'])->first();
            if ($route) {
                BusStop::firstOrCreate(
                    ['name' => $stopData['name'], 'route_id' => $route->id],
                    [
                        'name' => $stopData['name'],
                        'address' => $stopData['address'],
                        'latitude' => $stopData['latitude'],
                        'longitude' => $stopData['longitude'],
                        'route_id' => $route->id,
                        'stop_order' => $stopData['stop_order'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
