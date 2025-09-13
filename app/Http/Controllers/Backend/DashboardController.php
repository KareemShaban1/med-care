<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
{
    return view('backend.pages.dashboard.index', [
        'bannersCount' => \App\Models\Banner::count(),
        'categoriesCount' => \App\Models\Category::count(),
        'productsCount' => \App\Models\Product::count(),
        'ordersCount' => \App\Models\Order::count(),
        'ordersPending' => \App\Models\Order::where('status', 'pending')->count(),
        'ordersCompleted' => \App\Models\Order::where('status', 'completed')->count(),
        'ordersCancelled' => \App\Models\Order::where('status', 'cancelled')->count(),
        'ordersRevenue' => \App\Models\Order::where('status', 'completed')->sum('total'),
        'recentOrders' => \App\Models\Order::latest()->take(5)->get(),
    ]);
}

}
