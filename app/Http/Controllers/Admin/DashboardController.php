<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'low_stock_products' => Product::where('stock', '<=', 10)->count(),
        ];

        $recent_orders = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $monthly_revenue = Order::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'recent_orders' => $recent_orders,
                'monthly_revenue' => $monthly_revenue,
            ]
        ]);
    }
}
