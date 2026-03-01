<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class UmkmCategory extends Model {
    protected $fillable = ['name','slug','icon','description','is_active'];
    protected $casts = ['is_active'=>'boolean'];
    public function umkmProfiles() { return $this->hasMany(UmkmProfile::class,'category_id'); }
}
