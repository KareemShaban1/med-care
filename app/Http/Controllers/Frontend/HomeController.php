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
    //
    protected $homeRepositoryInterface;

    public function __construct(HomeRepositoryInterface $homeRepositoryInterface)
    {
        $this->homeRepositoryInterface = $homeRepositoryInterface;
    }

    public function index(Request $request)
    {
        return $this->homeRepositoryInterface->index($request);
    }

    public function showProduct($slug)
    {
        return $this->homeRepositoryInterface->showProduct($slug);
    }

    public function allProducts(Request $request)
    {
        return $this->homeRepositoryInterface->allProducts($request);
    }

    public function policy()
    {
        return $this->homeRepositoryInterface->policy();
    } 

    public function contact()
    {
        return $this->homeRepositoryInterface->contact();
    } 


}
