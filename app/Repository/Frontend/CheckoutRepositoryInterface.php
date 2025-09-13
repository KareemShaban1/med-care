<?php 
namespace App\Repository\Frontend;
interface CheckoutRepositoryInterface {

    public function show();

    public function process($request);

    public function confirmation($orderId);

}