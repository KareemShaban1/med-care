<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Repository\Frontend\HomeRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected HomeRepositoryInterface $homeRepo;

    public function __construct(HomeRepositoryInterface $homeRepo)
    {
        $this->homeRepo = $homeRepo;
    }

    public function index(Request $request)
    {
        $data = $this->homeRepo->getHomeData($request);

        if ($request->ajax()) {
            return view('frontend.pages.partials.products', $data)->render();
        }

        return view('frontend.pages.home', $data);
    }

    public function showProduct(string $slug)
    {
        $product = $this->homeRepo->getProductBySlug($slug);
        return view('frontend.pages.product_show', compact('product'));
    }

    public function getAllProducts(Request $request)
    {
        $data = $this->homeRepo->getAllProducts($request);

        if ($request->ajax()) {
            return view('frontend.pages.partials.products', $data)->render();
        }

        return view('frontend.pages.all_products', $data);
    }

    public function policy()
    {
        return view('frontend.pages.policy');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }
}
