<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusStop extends Model
{
    protected $fillable = [
        'name', 'address', 'latitude', 'longitude', 'route_id', 'stop_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['latitude' => 'decimal:7', 'longitude' => 'decimal:7', 'is_active' => 'boolean'];
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
