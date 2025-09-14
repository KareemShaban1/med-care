<?php 

namespace App\Repository\Frontend;

interface HomeRepositoryInterface {

    public function getHomeData($request);

    public function getProductBySlug($slug);

    public function getAllProducts($request);

    public function getPolicyData();

    public function getContactData();

}