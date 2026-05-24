<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_number', 'registration_number', 'model', 'capacity',
        'route_id', 'driver_id', 'status', 'year_of_manufacture',
    ];

    protected function casts(): array
    {
        return ['capacity' => 'integer', 'year_of_manufacture' => 'integer'];
    }

    public function route() { return $this->belongsTo(Route::class); }
    public function driver() { return $this->belongsTo(User::class, 'driver_id'); }
    public function trips() { return $this->hasMany(Trip::class); }
    public function gpsLocations() { return $this->hasMany(GpsLocation::class); }
    public function latestLocation() { return $this->hasOne(GpsLocation::class)->latestOfMany('recorded_at'); }
    public function emergencyAlerts() { return $this->hasMany(EmergencyAlert::class); }
    public function feedbacks() { return $this->hasMany(Feedback::class); }
}
