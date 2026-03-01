<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_id', 'category_id', 'name', 'slug', 'description',
        'price', 'price_min', 'price_max', 'unit', 'stock',
        'min_order', 'weight', 'is_available', 'is_featured', 'view_count',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'price_min'    => 'decimal:2',
        'price_max'    => 'decimal:2',
        'is_available' => 'boolean',
        'is_featured'  => 'boolean',
    ];

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getPrimaryImageAttribute()
    {
        $primary = $this->images()->where('is_primary', true)->first();
        return $primary ? asset('storage/' . $primary->image_path) : asset('images/default-product.png');
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Relations
    public function umkm()
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlistedBy()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }
}
