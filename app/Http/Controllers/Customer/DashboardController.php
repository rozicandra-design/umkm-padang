<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_pesanan'     => $user->orders()->count(),
            'pesanan_aktif'     => $user->orders()->whereIn('status', ['pending', 'processing', 'shipped'])->count(),
            'pesanan_menunggu'  => $user->orders()->where('status', 'pending')->count(),
            'pesanan_selesai'   => $user->orders()->where('status', 'completed')->count(),
            'total_belanja'     => $user->orders()->where('status', 'completed')->sum('grand_total'),
            'wishlist'          => $user->wishlists()->count(),
        ];

        $pesananTerbaru = $user->orders()
            ->with('umkm')
            ->latest()
            ->take(5)
            ->get();

        $produkTerakhirDilihat = collect(); // isi jika ada fitur riwayat

        return view('customer.dashboard', compact('stats', 'pesananTerbaru', 'produkTerakhirDilihat'));
    }
}