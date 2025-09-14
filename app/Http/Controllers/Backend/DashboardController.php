<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    //
    public function index()
{
    return view('backend.pages.dashboard.index', [
        'bannersCount' => Banner::count(),
        'categoriesCount' => Category::count(),
        'productsCount' => Product::count(),
        'ordersCount' => Order::count(),
        'usersCount' => User::count(),
        'ordersPending' => Order::where('status', 'pending')->count(),
        'ordersCompleted' => Order::where('status', 'completed')->count(),
        'ordersCancelled' => Order::where('status', 'cancelled')->count(),
        'ordersRevenue' => Order::where('status', 'completed')->sum('total'),
        'recentOrders' => Order::latest()->take(5)->get(),
    ]);
}

}
