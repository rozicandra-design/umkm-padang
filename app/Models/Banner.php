<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Banner extends Model {
    protected $fillable = ['title','image','link','is_active','sort_order','expired_at'];
    protected $casts = ['is_active'=>'boolean','expired_at'=>'datetime'];
    public function scopeActive($q) { return $q->where('is_active',true)->where(function($q){ $q->whereNull('expired_at')->orWhere('expired_at','>',now()); })->orderBy('sort_order'); }
}
