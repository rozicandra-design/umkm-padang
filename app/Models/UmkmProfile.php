<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'category_id', 'description',
        'logo', 'address', 'kelurahan', 'kecamatan',
        'latitude', 'longitude', 'phone', 'whatsapp',
        'instagram', 'website', 'operational_hours',
        'nik_pemilik', 'no_izin_usaha', 'status', 'verified_at',
    ];

    protected $casts = [
        'operational_hours' => 'array',
        'verified_at'       => 'datetime',
        'latitude'          => 'decimal:8',
        'longitude'         => 'decimal:8',
    ];

    // Scope
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Helpers
    public function isActive(): bool   { return $this->status === 'active'; }
    public function isPending(): bool  { return $this->status === 'pending'; }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo
            ? asset('storage/' . $this->logo)
            : asset('images/default-umkm.png');
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(UmkmCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'umkm_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'umkm_id');
    }
}
