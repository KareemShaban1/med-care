<?php

namespace App\Repository\Frontend;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeRepository implements HomeRepositoryInterface
{
    /**
     * Home page data
     */
    public function getHomeData($request): array
    {
        $productsQuery = Product::with('category');
        $this->applyFilters($productsQuery, $request);
        $products = $productsQuery->paginate(12);

        return [
            'products' => $products,
            'categories' => Category::all(),
            'banners' => Banner::all(),
            'newArrivals' => Product::where('type', 'new_arrival')->latest()->take(10)->get(),
            'bestSellers' => Product::where('type', 'best_seller')->latest()->take(10)->get(),
            'popular' => Product::where('type', 'popular')->latest()->take(10)->get(),
        ];
    }

    /**
     * Single product by slug
     */
    public function getProductBySlug($slug)
    {
        return Product::with('category')->where('slug', $slug)->firstOrFail();
    }

    /**
     * All products page
     */
    public function getAllProducts($request): array
    {
        $productsQuery = Product::with('category');
        $this->applyFilters($productsQuery, $request);
        $products = $productsQuery->paginate(12);

        return [
            'products' => $products,
            'categories' => Category::all(),
        ];
    }

    /**
     * Static page: policy
     */
    public function getPolicyData(): array
    {
        return []; // No dynamic data needed, controller will return view
    }

    /**
     * Static page: contact
     */
    public function getContactData(): array
    {
        return []; // No dynamic data needed
    }

    /**
     * Apply filters and sorting to product query
     */
    private function applyFilters($query, Request $request)
    {
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
    }
}
