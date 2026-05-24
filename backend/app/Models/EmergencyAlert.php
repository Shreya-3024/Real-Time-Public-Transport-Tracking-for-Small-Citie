<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyAlert extends Model
{
    protected $fillable = [
        'driver_id', 'bus_id', 'trip_id', 'latitude', 'longitude',
        'description', 'status', 'acknowledged_at', 'resolved_at',
    ];

    protected function casts(): array
    {
        return ['acknowledged_at' => 'datetime', 'resolved_at' => 'datetime'];
    }

    public function driver() { return $this->belongsTo(User::class, 'driver_id'); }
    public function bus() { return $this->belongsTo(Bus::class); }
    public function trip() { return $this->belongsTo(Trip::class); }
}
