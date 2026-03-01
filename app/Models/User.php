<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'phone', 'avatar', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    // Role helpers
    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isUmkm(): bool     { return $this->role === 'umkm'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }
    public function isDinas(): bool    { return $this->role === 'dinas'; }

    // Redirect setelah login berdasarkan role
    public function dashboardRoute(): string
    {
        return match($this->role) {
            'admin'    => 'admin.dashboard',
            'umkm'     => 'umkm.dashboard',
            'dinas'    => 'dinas.dashboard',
            default    => 'customer.dashboard',
        };
    }

    // Relations
    public function umkmProfile()
    {
        return $this->hasOne(UmkmProfile::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }
}
