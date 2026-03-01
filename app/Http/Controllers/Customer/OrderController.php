<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('umkm')->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = auth()->user()->orders()->with('umkm', 'items.product')->findOrFail($id);
        return view('customer.orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'       => 'required|exists:products,id',
            'quantity'         => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'notes'            => 'nullable|string|max:500',
        ]);

        $product  = Product::findOrFail($request->product_id);
        $subtotal = $product->price * $request->quantity;

        $order = Order::create([
            'customer_id'      => auth()->id(),
            'umkm_id'          => $product->umkm_id,
            'order_number'     => 'ORD-' . strtoupper(Str::random(8)),
            'status'           => 'pending',
            'payment_status'   => 'unpaid',
            'total_price'      => $subtotal,
            'shipping_cost'    => 0,
            'grand_total'      => $subtotal,
            'shipping_address' => $request->shipping_address,
            'notes'            => $request->notes,
        ]);

        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'quantity'   => $request->quantity,
            'price'      => $product->price,
            'subtotal'   => $subtotal,
        ]);

        return redirect()->route('customer.pesanan.index')
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}