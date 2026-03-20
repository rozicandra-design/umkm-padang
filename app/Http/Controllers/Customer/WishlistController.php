<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = auth()->user()
            ->wishlists()
            ->with(['product.images', 'product.umkm'])
            ->latest()
            ->paginate(12);

        return view('customer.wishlist.index', compact('wishlists'));
    }

    public function toggle(Product $product)
    {
        $user = auth()->user();

        $wishlist = Wishlist::where('customer_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            // Sudah ada → hapus
            $wishlist->delete();
            $message = 'Produk dihapus dari wishlist.';
            $status  = 'removed';
        } else {
            // Belum ada → tambah
            Wishlist::create([
                'customer_id' => $user->id,
                'product_id'  => $product->id,
            ]);
            $message = 'Produk ditambahkan ke wishlist!';
            $status  = 'added';
        }

        // Kalau request AJAX (dari tombol di homepage)
        if (request()->expectsJson()) {
            return response()->json([
                'status'  => $status,
                'message' => $message,
                'count'   => Wishlist::where('customer_id', $user->id)->count(),
            ]);
        }

        return back()->with('success', $message);
    }
}