<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpsLocation extends Model
{
    protected $fillable = [
        'bus_id', 'trip_id', 'latitude', 'longitude', 'speed', 'heading', 'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7', 'longitude' => 'decimal:7',
            'speed' => 'decimal:2', 'recorded_at' => 'datetime',
        ];
    }

    public function bus() { return $this->belongsTo(Bus::class); }
    public function trip() { return $this->belongsTo(Trip::class); }
}
