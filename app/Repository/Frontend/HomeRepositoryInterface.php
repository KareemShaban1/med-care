<?php 

namespace App\Repository\Frontend;

interface HomeRepositoryInterface {

    public function index($request);

    public function showProduct($slug);

    public function allProducts($request);

    public function policy();

    public function contact();

}