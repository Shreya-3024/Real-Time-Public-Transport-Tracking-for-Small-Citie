<?php

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
        'name', 'email', 'phone', 'password', 'role_id', 'avatar', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

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

    public function emergencyAlerts()
    {
        return $this->hasMany(EmergencyAlert::class, 'driver_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

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
