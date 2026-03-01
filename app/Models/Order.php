<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_id', 'umkm_id', 'status',
        'total_price', 'shipping_cost', 'grand_total',
        'payment_method', 'payment_status', 'shipping_address',
        'notes', 'confirmed_at', 'delivered_at',
    ];

    protected $casts = [
        'total_price'   => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'grand_total'   => 'decimal:2',
        'confirmed_at'  => 'datetime',
        'delivered_at'  => 'datetime',
    ];

    public static function generateOrderNumber(): string
    {
        return 'ORD-' . strtoupper(uniqid());
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'Menunggu Konfirmasi',
            'confirmed'  => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'shipped'    => 'Dikirim',
            'delivered'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'warning',
            'confirmed'  => 'info',
            'processing' => 'primary',
            'shipped'    => 'secondary',
            'delivered'  => 'success',
            'cancelled'  => 'danger',
            default      => 'secondary',
        };
    }

    // Relations
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function umkm()
    {
        return $this->belongsTo(UmkmProfile::class, 'umkm_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
