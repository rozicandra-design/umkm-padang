<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    private function getUmkm()
    {
        return Auth::user()->umkmProfile;
    }

    public function index(Request $request)
    {
        $umkm = $this->getUmkm();

        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $orders = Order::where('umkm_id', $umkm->id)
            ->with('items.product', 'customer')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        $totalPendapatan = $orders->whereIn('status', ['delivered'])->sum('grand_total');
        $totalPesanan    = $orders->count();
        $pesananSelesai  = $orders->where('status', 'delivered')->count();
        $pesananBatal    = $orders->where('status', 'cancelled')->count();

        return view('umkm.laporan.index', compact(
            'orders',
            'totalPendapatan',
            'totalPesanan',
            'pesananSelesai',
            'pesananBatal',
            'bulan',
            'tahun'
        ));
    }
}