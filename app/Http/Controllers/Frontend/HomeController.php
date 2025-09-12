<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        }

        $products = $query->paginate(12);

        $categories = Category::all();

        if ($request->ajax()) {

            // Return only the product grid (no layout)
            return view('frontend.pages.partials.products', compact('products', 'categories'))->render();
        }

        $banners = Banner::all();

        // Custom groups
        $newArrivals = Product::where('type', 'new_arrival')->latest()->take(10)->get();
        $bestSellers = Product::where('type', 'best_seller')->latest()->take(10)->get();
        $popular = Product::where('type', 'popular')->latest()->take(10)->get();

        return view('frontend.pages.home', compact('products', 'categories', 'banners', 'newArrivals', 'bestSellers', 'popular'));
    }


    public function showProduct($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('frontend.pages.product_show', compact('product'));
    }

    public function allProducts(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        }

        $products = $query->paginate(12);

        $categories = Category::all();

        if ($request->ajax()) {

            // Return only the product grid (no layout)
            return view('frontend.pages.partials.products', compact('products', 'categories'))->render();
        }

        return view('frontend.pages.all_products', compact('products', 'categories'));
    }
}
