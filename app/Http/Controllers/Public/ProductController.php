<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::available()->with('umkm', 'images', 'category');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('kecamatan')) {
            $query->whereHas('umkm', fn($q) => $q->where('kecamatan', $request->kecamatan));
        }
        if ($request->filled('sort')) {
            match($request->sort) {
                'termurah' => $query->orderBy('price', 'asc'),
                'termahal' => $query->orderBy('price', 'desc'),
                'terlaris' => $query->withCount('orderItems')->orderByDesc('order_items_count'),
                default    => $query->latest(),
            };
        } else {
            $query->latest();
        }

        $products   = $query->paginate(16)->withQueryString();
        $categories = ProductCategory::where('is_active', true)->get();

        return view('public.katalog', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
                    ->with('umkm.category', 'images', 'reviews.customer', 'category')
                    ->firstOrFail();

        $product->increment('view_count');

        $related = Product::available()
                    ->where('id', '!=', $product->id)
                    ->where('category_id', $product->category_id)
                    ->take(4)
                    ->get();

        return view('public.produk-detail', compact('product', 'related'));
    }
}