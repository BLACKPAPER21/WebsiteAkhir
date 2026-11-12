<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = auth()->user()->cart()->with(['items.product'])->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        return view('orders.checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_name'    => 'required|string|max:255',
            'recipient_phone'   => 'required|string|max:20',
            'shipping_address'  => 'required|string',
            'payment_method'    => 'required|in:bank_transfer,cod,e_wallet',
        ]);

        $cart = auth()->user()->cart()->with(['items.product'])->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $totalPrice = $cart->items->sum(fn($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => 'TF-' . strtoupper(Str::random(8)),
            'total_price'      => $totalPrice,
            'status'           => 'pending',
            'payment_method'   => $request->payment_method,
            'payment_status'   => 'unpaid',
            'shipping_address' => $request->shipping_address,
            'recipient_name'   => $request->recipient_name,
            'recipient_phone'  => $request->recipient_phone,
            'notes'            => $request->notes,
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);

            // Reduce stock
            $item->product->decrement('stock', $item->quantity);
        }

        // Clear cart
        $cart->items()->delete();

        return redirect()->route('orders.success', $order)->with('success', 'Pesanan berhasil dibuat!');
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.success', compact('order'));
    }

    public function index()
    {
        $orders = auth()->user()->orders()->with(['items.product'])->latest()->paginate(10);
        return view('dashboard.index', compact('orders'));
    }
}
