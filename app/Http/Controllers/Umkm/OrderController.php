<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private function getUmkm()
    {
        return Auth::user()->umkmProfile;
    }

    public function index()
    {
        $orders = Order::where('umkm_id', $this->getUmkm()->id)
            ->with('customer', 'items.product')
            ->latest()
            ->paginate(15);

        return view('umkm.pesanan.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('umkm_id', $this->getUmkm()->id)
            ->with('customer', 'items.product')
            ->findOrFail($id);

        return view('umkm.pesanan.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::where('umkm_id', $this->getUmkm()->id)->findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
