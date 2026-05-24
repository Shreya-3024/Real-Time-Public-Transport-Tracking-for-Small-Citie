<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_number', 'name', 'start_point', 'end_point',
        'distance', 'estimated_duration', 'color', 'is_active',
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
