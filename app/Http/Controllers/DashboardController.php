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


        $startDate = Carbon::now()->now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();


        $salesData = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->selectRaw('DATE(created_at) as date,SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $endData = Carbon::now()->endOfDay();



        $chartData = [
            'labels' => [],
            'data' => []
        ];

        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays(6 - $i)->format('Y-m-d');
            $chartData['labels'][] = Carbon::parse($date)->format('d/m');


            $total = $salesData->firstWhere('date', $date);
            $chartData['data'][] = $total ? $total->total : 0;
        }

        return view('dashboard', compact(
            'productCount',
            'categoryCount',
            'lowStockCount',
            'pendingOrderCount',
            'recentOrders',
            'chartData'
        ));
    }
}
