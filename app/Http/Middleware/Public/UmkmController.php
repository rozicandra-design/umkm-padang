<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;
use App\Models\UmkmCategory;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $query = UmkmProfile::active()->with('category')->withCount('products');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        $umkmList   = $query->paginate(12)->withQueryString();
        $categories = UmkmCategory::where('is_active', true)->get();
        $kecamatans = UmkmProfile::active()->distinct()->pluck('kecamatan')->sort()->values();

        return view('public.umkm-list', compact('umkmList', 'categories', 'kecamatans'));
    }

    public function show(string $slug)
    {
        $umkm     = UmkmProfile::where('slug', $slug)->where('status','active')
                        ->with('category','user','products.images')->firstOrFail();
        $products = $umkm->products()->available()->with('images')->paginate(8);

        return view('public.umkm-detail', compact('umkm','products'));
    }
}
