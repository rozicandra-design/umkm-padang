<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $umkm = Auth::user()->umkmProfile;

        if (!$umkm) {
            return redirect()->route('umkm.profil.edit')->with('warning', 'Lengkapi profil UMKM Anda terlebih dahulu.');
        }

        $stats = [
            'total_produk'   => $umkm->products()->count(),
            'produk_aktif'   => $umkm->products()->where('is_available', true)->count(),
            'total_pesanan'  => $umkm->orders()->count(),
            'pesanan_baru'   => $umkm->orders()->where('status', 'pending')->count(),
            'omzet_bulan_ini'=> $umkm->orders()->where('status','delivered')
                                    ->whereMonth('created_at', now()->month)
                                    ->sum('grand_total'),
            'omzet_total'    => $umkm->orders()->where('status','delivered')->sum('grand_total'),
        ];

        $pesananTerbaru = $umkm->orders()->with('customer','items.product')
                              ->latest()->take(5)->get();

        $produkTerlaris = $umkm->products()
                              ->withCount('orderItems')
                              ->orderByDesc('order_items_count')
                              ->take(5)->get();

        return view('umkm.dashboard', compact('umkm', 'stats', 'pesananTerbaru', 'produkTerlaris'));
    }
}
