<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\UmkmProfile;
use App\Models\UmkmCategory;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $banners       = Banner::active()->get();
        $categories    = UmkmCategory::where('is_active', true)->withCount('umkmProfiles')->get();
        $featuredUmkm  = UmkmProfile::active()->with('category')->withCount('products')->latest()->take(6)->get();
        $latestProducts= Product::available()->with('umkm','images')->latest()->take(8)->get();
        $stats = [
            'total_umkm'    => UmkmProfile::active()->count(),
            'total_produk'  => Product::available()->count(),
            'total_customer'=> \App\Models\User::where('role','customer')->count(),
        ];

        return view('public.home', compact('banners','categories','featuredUmkm','latestProducts','stats'));
    }

    public function peta()
    {
        $umkmList = UmkmProfile::active()
            ->with('category')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id','name','slug','latitude','longitude','address','kecamatan']);

        return view('public.peta', compact('umkmList'));
    }

    public function tentang()
    {
        return view('public.tentang');
    }
}
