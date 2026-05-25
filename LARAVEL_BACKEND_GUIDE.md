# Laravel 12 Backend Architecture Guide
## Real-Time Public Transport Tracking System

---

## 📁 BACKEND FOLDER STRUCTURE

```
laravel-backend/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── API/
│   │   │   │   ├── Auth/
│   │   │   │   │   ├── LoginController.php
│   │   │   │   │   ├── RegisterController.php
│   │   │   │   │   └── LogoutController.php
│   │   │   │   ├── Admin/
│   │   │   │   │   ├── BusController.php
│   │   │   │   │   ├── DriverController.php
│   │   │   │   │   ├── RouteController.php
│   │   │   │   │   ├── BusStopController.php
│   │   │   │   │   ├── AnalyticsController.php
│   │   │   │   │   └── EmergencyAlertController.php
│   │   │   │   ├── Driver/
│   │   │   │   │   ├── TripController.php
│   │   │   │   │   ├── LocationController.php
│   │   │   │   │   └── EmergencyController.php
│   │   │   │   └── Passenger/
│   │   │   │       ├── BusTrackingController.php
│   │   │   │       ├── RouteSearchController.php
│   │   │   │       └── NearbyBusController.php
│   │   ├── Middleware/
│   │   │   ├── RoleMiddleware.php
│   │   │   └── ApiTokenMiddleware.php
│   │   ├── Requests/
│   │   │   ├── StoreBusRequest.php
│   │   │   ├── UpdateRouteRequest.php
│   │   │   └── StartTripRequest.php
│   │   └── Resources/
│   │       ├── BusResource.php
│   │       ├── RouteResource.php
│   │       ├── TripResource.php
│   │       └── LocationResource.php
│   │
│   ├── Models/
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Bus.php
│   │   ├── Route.php
│   │   ├── BusStop.php
│   │   ├── Trip.php
│   │   ├── GpsLocation.php
│   │   ├── Notification.php
│   │   ├── EmergencyAlert.php
│   │   └── Feedback.php
│   │
│   ├── Services/
│   │   ├── AuthService.php
│   │   ├── BusTrackingService.php
│   │   ├── ETACalculationService.php
│   │   ├── RouteOptimizationService.php
│   │   └── NotificationService.php
│   │
│   ├── Repositories/
│   │   ├── BusRepository.php
│   │   ├── RouteRepository.php
│   │   ├── TripRepository.php
│   │   └── LocationRepository.php
│   │
│   ├── Events/
│   │   ├── BusLocationUpdated.php
│   │   ├── TripStarted.php
│   │   ├── TripEnded.php
│   │   └── EmergencyTriggered.php
│   │
│   └── Listeners/
│       ├── NotifyPassengers.php
│       ├── UpdateETACalculations.php
│       └── SendEmergencyAlert.php
│
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
│
├── routes/
│   ├── api.php
│   ├── web.php
│   └── channels.php
│
└── config/
    ├── broadcasting.php
    ├── sanctum.php
    └── cors.php
```

---

## 🗄️ DATABASE SCHEMA

### Migration Files

#### 1. Create Roles Table
```php
// database/migrations/2026_01_01_000001_create_roles_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // admin, driver, passenger
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
```

#### 2. Create Users Table
```php
// database/migrations/2026_01_01_000002_create_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

#### 3. Create Routes Table
```php
// database/migrations/2026_01_01_000003_create_routes_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('route_number')->unique();
            $table->string('name');
            $table->string('start_point');
            $table->string('end_point');
            $table->decimal('distance', 8, 2); // in kilometers
            $table->integer('estimated_duration'); // in minutes
            $table->string('color')->default('#3B82F6');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
```

#### 4. Create Bus Stops Table
```php
// database/migrations/2026_01_01_000004_create_bus_stops_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bus_stops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->integer('stop_order'); // Order in the route
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['latitude', 'longitude']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus_stops');
    }
};
```

#### 5. Create Buses Table
```php
// database/migrations/2026_01_01_000005_create_buses_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->string('bus_number')->unique();
            $table->string('registration_number')->unique();
            $table->string('model');
            $table->integer('capacity');
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->year('year_of_manufacture')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
```

#### 6. Create Trips Table
```php
// database/migrations/2026_01_01_000006_create_trips_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->decimal('distance_covered', 8, 2)->nullable();
            $table->integer('duration')->nullable(); // in minutes
            $table->enum('status', ['ongoing', 'completed', 'cancelled'])->default('ongoing');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('started_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
```

#### 7. Create GPS Locations Table
```php
// database/migrations/2026_01_01_000007_create_gps_locations_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gps_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('speed', 5, 2)->default(0); // km/h
            $table->decimal('heading', 5, 2)->nullable(); // degrees
            $table->timestamp('recorded_at');
            $table->timestamps();

            $table->index(['bus_id', 'recorded_at']);
            $table->index(['latitude', 'longitude']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gps_locations');
    }
};
```

#### 8. Create Notifications Table
```php
// database/migrations/2026_01_01_000008_create_notifications_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['info', 'warning', 'alert', 'success'])->default('info');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
```

#### 9. Create Emergency Alerts Table
```php
// database/migrations/2026_01_01_000009_create_emergency_alerts_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emergency_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('bus_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'acknowledged', 'resolved'])->default('pending');
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency_alerts');
    }
};
```

#### 10. Create Feedbacks Table
```php
// database/migrations/2026_01_01_000010_create_feedbacks_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('trip_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('bus_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('rating')->unsigned(); // 1-5
            $table->text('comment')->nullable();
            $table->enum('category', ['bus_condition', 'driver_behavior', 'timeliness', 'safety', 'other'])->default('other');
            $table->timestamps();

            $table->index('rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
```

---

## 🔗 MODEL RELATIONSHIPS

### User Model
```php
<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role_id',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function drivingBuses()
    {
        return $this->hasMany(Bus::class, 'driver_id');
    }

    public function trips()
    {
        return $this->hasMany(Trip::class, 'driver_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function emergencyAlerts()
    {
        return $this->hasMany(EmergencyAlert::class, 'driver_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role->name === 'admin';
    }

    public function isDriver(): bool
    {
        return $this->role->name === 'driver';
    }

    public function isPassenger(): bool
    {
        return $this->role->name === 'passenger';
    }
}
```

### Bus Model
```php
<?php
// app/Models/Bus.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_number',
        'registration_number',
        'model',
        'capacity',
        'route_id',
        'driver_id',
        'status',
        'year_of_manufacture',
    ];

    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
            'year_of_manufacture' => 'integer',
        ];
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    public function gpsLocations()
    {
        return $this->hasMany(GpsLocation::class);
    }

    public function latestLocation()
    {
        return $this->hasOne(GpsLocation::class)->latestOfMany('recorded_at');
    }

    public function emergencyAlerts()
    {
        return $this->hasMany(EmergencyAlert::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
```

### Route Model
```php
<?php
// app/Models/Route.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_number',
        'name',
        'start_point',
        'end_point',
        'distance',
        'estimated_duration',
        'color',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'distance' => 'decimal:2',
            'estimated_duration' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function busStops()
    {
        return $this->hasMany(BusStop::class)->orderBy('stop_order');
    }

    public function buses()
    {
        return $this->hasMany(Bus::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
```

---

## 🛣️ API ROUTES

```php
<?php
// routes/api.php

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
```

---

## 📡 WEBSOCKET / BROADCASTING

### channels.php
```php
<?php
// routes/channels.php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('bus.{busId}', function ($user, $busId) {
    return true; // Public channel for tracking
});

Broadcast::channel('route.{routeId}', function ($user, $routeId) {
    return true; // Public channel for route tracking
});

Broadcast::channel('emergency.alerts', function ($user) {
    return $user->isAdmin();
});
```

### BusLocationUpdated Event
```php
<?php
// app/Events/BusLocationUpdated.php

namespace App\Events;

use App\Models\GpsLocation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BusLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public GpsLocation $location)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('bus.' . $this->location->bus_id),
            new Channel('route.' . $this->location->bus->route_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'location.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'bus_id' => $this->location->bus_id,
            'bus_number' => $this->location->bus->bus_number,
            'latitude' => $this->location->latitude,
            'longitude' => $this->location->longitude,
            'speed' => $this->location->speed,
            'recorded_at' => $this->location->recorded_at,
        ];
    }
}
```

---

## 🚀 LARAVEL COMMANDS

### Installation
```bash
# Create new Laravel project
composer create-project laravel/laravel smartcity-transport-api

cd smartcity-transport-api

# Install Laravel Sanctum
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# Install Laravel Reverb for WebSockets
composer require laravel/reverb
php artisan reverb:install

# Database setup
php artisan migrate:fresh --seed

# Start development server
php artisan serve

# Start queue worker (for notifications)
php artisan queue:work

# Start WebSocket server
php artisan reverb:start
```

### Seeding Database
```bash
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=RouteSeeder
php artisan db:seed --class=BusSeeder
```

---

## 🔒 SECURITY IMPLEMENTATION

### RoleMiddleware
```php
<?php
// app/Http/Middleware/RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!$request->user() || $request->user()->role->name !== $role) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
```

### Register Middleware
```php
// bootstrap/app.php

->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

---

## 📊 API ENDPOINT EXAMPLES

### Start Trip (Driver)
**POST** `/api/driver/trips/start`
```json
{
  "bus_id": 1,
  "route_id": 1
}
```

### Update GPS Location (Driver)
**POST** `/api/driver/location/update`
```json
{
  "bus_id": 1,
  "latitude": 40.7128,
  "longitude": -74.0060,
  "speed": 45.5,
  "heading": 180.0
}
```

### Get Live Buses (Passenger)
**GET** `/api/passenger/buses/live?route_id=1`

### Trigger Emergency (Driver)
**POST** `/api/driver/emergency/trigger`
```json
{
  "bus_id": 1,
  "latitude": 40.7128,
  "longitude": -74.0060,
  "description": "Engine failure"
}
```

---

## 🧪 TESTING STRATEGY

```bash
# Create test files
php artisan make:test AuthenticationTest
php artisan make:test BusTrackingTest
php artisan make:test EmergencyAlertTest

# Run tests
php artisan test
php artisan test --filter AuthenticationTest
```

---

## 📦 DEPLOYMENT

### Production Checklist
```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Setup supervisor for queue workers
sudo apt-get install supervisor

# Configure .env for production
APP_ENV=production
APP_DEBUG=false
QUEUE_CONNECTION=database
BROADCAST_DRIVER=reverb
```

---

## 🎓 RESUME-READY DESCRIPTION

**Project:** Real-Time Public Transport Tracking System  
**Role:** Full-Stack Developer  
**Tech Stack:** Laravel 12, React.js, MySQL, Laravel Sanctum, WebSockets (Laravel Reverb), Leaflet.js  

**Key Achievements:**
- Architected and developed a production-grade real-time bus tracking system serving 3 user roles
- Implemented WebSocket broadcasting for live GPS updates with sub-second latency
- Built RESTful APIs with role-based authentication using Laravel Sanctum
- Designed optimized database schema with 10+ tables and complex relationships
- Created responsive React frontend with interactive maps using Leaflet.js and OpenStreetMap
- Implemented emergency alert system with instant push notifications
- Applied Repository pattern and Service layer architecture for clean, maintainable code

---

*This guide provides the complete backend architecture. Refer to the React frontend in the `src/` directory.*
