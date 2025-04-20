<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function inventory()
    {
        $products = Product::with('category')->get();
        $totalValue = $products->sum(function ($product) {
            return $product->price * $product->stock_quantity;
        });
    }


    public function sales(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();

        $orders = Order::whereBetween('order_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->with(['items.product'])
            ->get();

        $totalSales = $orders->sum('total_amount');
        $totalOrders = $orders->count();

        $salesByProduct = [];

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $productId = $item->product_id;

                if (!isset($salesByProduct[$productId])) {
                    $salesByProduct[$productId] = [
                        'name' => $item->product->name,
                        'quantity' => 0,
                        'revenue' => 0
                    ];
                }

                $salesByProduct[$productId]['quantity'] += $item->quantity;
                $salesByProduct[$productId]['revenue'] += $item->quantity * $item->unit_price;
            }
        }
    }


    public function exportInventory()
    {
        return Excel::download(new ProductsExport, 'inventory-report.xlsx');
    }

    public function exportSales(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now();


        return Excel::download(new SalesExport($startDate, $endDate), 'sales-report.xlsx');
    }
}
