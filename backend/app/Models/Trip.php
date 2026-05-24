<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'bus_id', 'driver_id', 'route_id', 'started_at', 'ended_at',
        'distance_covered', 'duration', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return ['started_at' => 'datetime', 'ended_at' => 'datetime'];
    }

    public function bus() { return $this->belongsTo(Bus::class); }
    public function driver() { return $this->belongsTo(User::class, 'driver_id'); }
    public function route() { return $this->belongsTo(Route::class); }
    public function gpsLocations() { return $this->hasMany(GpsLocation::class); }
}
