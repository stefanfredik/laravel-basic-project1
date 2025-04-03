<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        $categoryCount = Category::count();
        $lowStockCount = Product::where('stock_quantity', '<', 10)->count();
        $pendingOrderCount = Order::where('status', 'pending')->count();

        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();


        $chartData = [
            'labels' => [],
            'data' => []
        ];

        for($i =0; $i < 7; $i++){
            $date = Carbon::now()->subDays()
        }
    }
}
