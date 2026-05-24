<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $driverRole = Role::where('name', 'driver')->first();
        $passengerRole = Role::where('name', 'passenger')->first();

        // Admin
        User::firstOrCreate(
            ['email' => 'admin@smartcity.com'],
            [
                'name' => 'Admin User',
                'phone' => '9876543210',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]
        );

        // Drivers
        $drivers = [
            ['name' => 'Rajesh Kumar', 'email' => 'rajesh@smartcity.com', 'phone' => '9876543211'],
            ['name' => 'Amit Sharma', 'email' => 'amit@smartcity.com', 'phone' => '9876543212'],
            ['name' => 'Sunil Verma', 'email' => 'sunil@smartcity.com', 'phone' => '9876543213'],
            ['name' => 'Vikram Singh', 'email' => 'vikram@smartcity.com', 'phone' => '9876543214'],
            ['name' => 'Manoj Joshi', 'email' => 'manoj@smartcity.com', 'phone' => '9876543215'],
            ['name' => 'Deepak Meena', 'email' => 'deepak@smartcity.com', 'phone' => '9876543216'],
            ['name' => 'Ravi Yadav', 'email' => 'ravi@smartcity.com', 'phone' => '9876543217'],
        ];

        foreach ($drivers as $driver) {
            User::firstOrCreate(
                ['email' => $driver['email']],
                array_merge($driver, [
                    'password' => Hash::make('password'),
                    'role_id' => $driverRole->id,
                    'is_active' => true,
                ])
            );
        }

        // Passengers
        $passengers = [
            ['name' => 'Priya Patel', 'email' => 'priya@gmail.com', 'phone' => '9876543220'],
            ['name' => 'Ankit Gupta', 'email' => 'ankit@gmail.com', 'phone' => '9876543221'],
            ['name' => 'Neha Singh', 'email' => 'neha@gmail.com', 'phone' => '9876543222'],
        ];

        foreach ($passengers as $passenger) {
            User::firstOrCreate(
                ['email' => $passenger['email']],
                array_merge($passenger, [
                    'password' => Hash::make('password'),
                    'role_id' => $passengerRole->id,
                    'is_active' => true,
                ])
            );
        }
    }
}
