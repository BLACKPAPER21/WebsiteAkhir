<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category'])
            ->where('is_active', true)
            ->where('stock', '>', 0);

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Filter by condition
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Filter by size
        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }

        // Sort
        match($request->sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'newest'     => $query->latest(),
            'popular'    => $query->orderBy('views', 'desc'),
            default      => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'seller'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment views
        $product->increment('views');

        // Related products
        $related = Product::with(['category'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        // Check if in wishlist
        $inWishlist = false;
        if (auth()->check()) {
            $inWishlist = $product->wishlists()->where('user_id', auth()->id())->exists();
        }

        return view('products.show', compact('product', 'related', 'inWishlist'));
    }
}
