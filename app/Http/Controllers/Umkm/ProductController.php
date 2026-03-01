<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private function getUmkm()
    {
        return Auth::user()->umkmProfile;
    }

    private function checkOwner(Product $product)
    {
        if ($product->umkm_id !== $this->getUmkm()->id) {
            abort(403, 'Akses ditolak.');
        }
    }

    public function index()
    {
        $products = $this->getUmkm()->products()->with('category', 'images')->latest()->paginate(12);
        return view('umkm.produk.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::where('is_active', true)->get();
        return view('umkm.produk.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'unit'        => 'nullable|string|max:50',
            'min_order'   => 'nullable|integer|min:1',
            'weight'      => 'nullable|numeric|min:0',
            'images.*'    => 'nullable|image|max:2048',
        ]);

        $data['umkm_id']      = $this->getUmkm()->id;
        $data['slug']         = Str::slug($data['name']) . '-' . uniqid();
        $data['is_available'] = true;

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $i === 0,
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('umkm.produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $this->checkOwner($product);
        $categories = ProductCategory::where('is_active', true)->get();
        return view('umkm.produk.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->checkOwner($product);

        $data = $request->validate([
            'name'        => 'required|string|max:200',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'unit'        => 'nullable|string|max:50',
            'min_order'   => 'nullable|integer|min:1',
            'weight'      => 'nullable|numeric|min:0',
        ]);

        $product->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => false,
                    'sort_order' => $product->images()->count() + $i,
                ]);
            }
        }

        return redirect()->route('umkm.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $this->checkOwner($product);
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        $product->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function toggleAvailable(Product $product)
    {
        $this->checkOwner($product);
        $product->update(['is_available' => !$product->is_available]);
        $status = $product->is_available ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Produk berhasil $status.");
    }
}