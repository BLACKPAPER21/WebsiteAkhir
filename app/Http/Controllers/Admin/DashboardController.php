<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders'   => Order::count(),
            'total_users'    => User::where('role', 'user')->count(),
            'total_revenue'  => Order::where('payment_status', 'paid')->sum('total_price'),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with(['user', 'items'])->latest()->take(10)->get();
        $topProducts = Product::withCount('orderItems')->orderBy('order_items_count', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts'));
    }
}
