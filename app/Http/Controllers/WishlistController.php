<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Product $product)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Produk dihapus dari wishlist.');
        } else {
            Wishlist::create(['user_id' => auth()->id(), 'product_id' => $product->id]);
            return back()->with('success', 'Produk ditambahkan ke wishlist!');
        }
    }

    public function index()
    {
        $wishlists = auth()->user()->wishlists()->with('product.category')->latest()->get();
        return view('dashboard.wishlist', compact('wishlists'));
    }
}
