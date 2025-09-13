<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessCheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Repository\Frontend\CheckoutRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    //

    protected $checkoutRepositoryInterface;

    public function __construct(CheckoutRepositoryInterface $checkoutRepositoryInterface)
    {
        $this->checkoutRepositoryInterface = $checkoutRepositoryInterface;
    }
    public function show()
    {
        return $this->checkoutRepositoryInterface->show();
    }

    public function process(ProcessCheckoutRequest $request)
    {
        return $this->checkoutRepositoryInterface->process($request);
    }

    public function confirmation($orderId)
    {
        return $this->checkoutRepositoryInterface->confirmation($orderId);
    }
}
