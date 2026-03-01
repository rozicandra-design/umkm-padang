<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UmkmProfile;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_umkm'      => UmkmProfile::count(),
            'umkm_aktif'      => UmkmProfile::active()->count(),
            'umkm_pending'    => UmkmProfile::pending()->count(),
            'total_produk'    => Product::count(),
            'total_customer'  => User::where('role','customer')->count(),
            'total_pesanan'   => Order::count(),
            'pesanan_hari_ini'=> Order::whereDate('created_at', today())->count(),
            'omzet_bulan_ini' => Order::where('status','delivered')
                                     ->whereMonth('created_at', now()->month)
                                     ->sum('grand_total'),
        ];

        $umkmPending    = UmkmProfile::pending()->with('user','category')->latest()->take(5)->get();
        $pesananTerbaru = Order::with('customer','umkm')->latest()->take(8)->get();

        // Chart data: pesanan per bulan (12 bulan terakhir)
        $chartData = Order::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
                         ->whereYear('created_at', now()->year)
                         ->groupBy('bulan')
                         ->orderBy('bulan')
                         ->pluck('total', 'bulan');

        return view('admin.dashboard', compact('stats','umkmPending','pesananTerbaru','chartData'));
    }

    public function laporan()
{
    $umkmPerKategori = DB::table('umkm_profiles')
        ->join('umkm_categories', 'umkm_profiles.category_id', '=', 'umkm_categories.id')
        ->selectRaw('umkm_categories.name as kategori, COUNT(*) as total')
        ->where('status', 'active')
        ->groupBy('umkm_categories.name')
        ->get();

    $omzetBulanan = DB::table('orders')
        ->selectRaw('MONTH(created_at) as bulan, SUM(grand_total) as omzet')
        ->where('status', 'delivered')
        ->whereYear('created_at', now()->year)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    return view('admin.laporan', compact('umkmPerKategori', 'omzetBulanan'));
}
}
