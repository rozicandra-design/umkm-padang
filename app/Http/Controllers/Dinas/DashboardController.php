<?php

namespace App\Http\Controllers\Dinas;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UmkmProfile;
use App\Models\Product;
use App\Models\Order;
use App\Models\UmkmCategory;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_umkm'       => UmkmProfile::count(),
            'umkm_aktif'       => UmkmProfile::active()->count(),
            'umkm_pending'     => UmkmProfile::pending()->count(),
            'total_produk'     => Product::count(),
            'total_customer'   => User::where('role', 'customer')->count(),
            'total_pesanan'    => Order::count(),
            'omzet_total'      => Order::where('status', 'delivered')->sum('grand_total'),
            'omzet_bulan_ini'  => Order::where('status', 'delivered')
                                       ->whereMonth('created_at', now()->month)
                                       ->sum('grand_total'),
        ];

        $umkmPerKecamatan = UmkmProfile::active()
            ->selectRaw('kecamatan, COUNT(*) as total')
            ->groupBy('kecamatan')
            ->orderByDesc('total')
            ->get();

        $umkmPerKategori = UmkmProfile::active()
            ->join('umkm_categories', 'umkm_profiles.category_id', '=', 'umkm_categories.id')
            ->selectRaw('umkm_categories.name as kategori, COUNT(*) as total')
            ->groupBy('umkm_categories.name')
            ->orderByDesc('total')
            ->get();

        $umkmTerbaru = UmkmProfile::active()
            ->with('user', 'category')
            ->latest()
            ->take(6)
            ->get();

        $omzetPerBulan = Order::where('status', 'delivered')
            ->selectRaw('MONTH(created_at) as bulan, SUM(grand_total) as omzet')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('omzet', 'bulan');

        return view('dinas.dashboard', compact(
            'stats',
            'umkmPerKecamatan',
            'umkmPerKategori',
            'umkmTerbaru',
            'omzetPerBulan'
        ));
    }

    public function statistik()
    {
        $umkmPerKategori = DB::table('umkm_profiles')
            ->join('umkm_categories', 'umkm_profiles.category_id', '=', 'umkm_categories.id')
            ->selectRaw('umkm_categories.name as kategori, COUNT(*) as total')
            ->where('umkm_profiles.status', 'active')
            ->groupBy('umkm_categories.name')
            ->get();

        $umkmPerKecamatan = DB::table('umkm_profiles')
            ->selectRaw('kecamatan, COUNT(*) as total')
            ->where('status', 'active')
            ->groupBy('kecamatan')
            ->orderByDesc('total')
            ->get();

        $totalUmkm    = DB::table('umkm_profiles')->where('status', 'active')->count();
        $totalProduk  = DB::table('products')->where('is_available', true)->count();
        $totalPesanan = DB::table('orders')->count();
        $totalOmzet   = DB::table('orders')->where('status', 'delivered')->sum('grand_total');

        return view('dinas.statistik', compact(
            'umkmPerKategori',
            'umkmPerKecamatan',
            'totalUmkm',
            'totalProduk',
            'totalPesanan',
            'totalOmzet'
        ));
    }

    public function peta()
    {
        $umkmList = DB::table('umkm_profiles')
            ->where('status', 'active')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('dinas.peta', compact('umkmList'));
    }

    public function laporan()
    {
        $omzetBulanan = DB::table('orders')
            ->selectRaw('MONTH(created_at) as bulan, SUM(grand_total) as omzet, COUNT(*) as total_pesanan')
            ->where('status', 'delivered')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $umkmBaru = DB::table('umkm_profiles')
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $umkmPerKategori = DB::table('umkm_profiles')
            ->join('umkm_categories', 'umkm_profiles.category_id', '=', 'umkm_categories.id')
            ->selectRaw('umkm_categories.name as kategori, COUNT(*) as total')
            ->where('umkm_profiles.status', 'active')
            ->groupBy('umkm_categories.name')
            ->get();

        return view('dinas.laporan', compact('omzetBulanan', 'umkmBaru', 'umkmPerKategori'));
    }

    public function export()
    {
        $umkmList = DB::table('umkm_profiles')
            ->join('umkm_categories', 'umkm_profiles.category_id', '=', 'umkm_categories.id')
            ->join('users', 'umkm_profiles.user_id', '=', 'users.id')
            ->select(
                'umkm_profiles.name',
                'umkm_categories.name as kategori',
                'umkm_profiles.kecamatan',
                'umkm_profiles.address',
                'umkm_profiles.whatsapp',
                'umkm_profiles.status',
                'users.name as pemilik',
                'umkm_profiles.created_at'
            )
            ->get();

        $csvHeader = ['Nama UMKM', 'Kategori', 'Kecamatan', 'Alamat', 'WhatsApp', 'Status', 'Pemilik', 'Terdaftar'];
        $filename  = 'laporan-umkm-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($umkmList, $csvHeader) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);
            foreach ($umkmList as $row) {
                fputcsv($file, (array) $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}