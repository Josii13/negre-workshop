<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'products_count' => Product::count(),
            'orders_count' => Order::count(),
            'activities_count' => Activity::count(),
            'users_count' => User::count(),
        ];

        $recent_orders = Order::with('product')
            ->latest()
            ->take(10)
            ->get();

        $recent_activities = Activity::latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'recent_activities'));
    }
}

