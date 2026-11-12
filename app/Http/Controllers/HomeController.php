<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $latestProducts = Product::with(['category'])
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();
        $popularProducts = Product::with(['category'])
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->orderBy('views', 'desc')
            ->take(8)
            ->get();

        return view('home.index', compact('categories', 'latestProducts', 'popularProducts'));
    }
}
