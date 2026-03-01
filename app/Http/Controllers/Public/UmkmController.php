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
        $query = UmkmProfile::with('category', 'user')
            ->where('status', 'active');

        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        $umkmList   = $query->paginate(12)->withQueryString();
        $categories = UmkmCategory::where('is_active', true)->get();
        $kecamatans = UmkmProfile::where('status', 'active')
                        ->whereNotNull('kecamatan')
                        ->distinct()
                        ->pluck('kecamatan')
                        ->sort()
                        ->values();

        return view('public.umkm-list', compact('umkmList', 'categories', 'kecamatans'));
    }

    public function show(string $slug)
    {
        $umkm = UmkmProfile::with('category', 'user')
            ->where('slug', $slug)
            ->firstOrFail();

        $products = $umkm->products()->with('images')->paginate(12);

        return view('public.umkm-detail', compact('umkm', 'products'));
    }
}