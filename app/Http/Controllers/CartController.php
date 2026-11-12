<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart()->with(['items.product.category'])->first();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < 1) {
            return back()->with('error', 'Produk ini sudah habis.');
        }

        $cart = auth()->user()->cart()->firstOrCreate([]);
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->items()->create(['product_id' => $product->id, 'quantity' => 1]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($item->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $item->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(CartItem $item)
    {
        if ($item->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $item->delete();
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
