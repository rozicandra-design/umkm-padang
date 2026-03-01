<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Review extends Model {
    protected $fillable = ['order_item_id','customer_id','product_id','rating','comment','image','is_approved'];
    protected $casts = ['is_approved'=>'boolean'];
    public function customer() { return $this->belongsTo(User::class,'customer_id'); }
    public function product()  { return $this->belongsTo(Product::class); }
    public function orderItem(){ return $this->belongsTo(OrderItem::class); }
}
