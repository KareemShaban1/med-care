<?php 
namespace App\Repository\Frontend;
interface CheckoutRepositoryInterface {

    public function getCheckoutData(): array;

    public function processCheckout($data): string;

    public function getOrderConfirmation($uuid);

}