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

    protected $checkoutRepo;

    public function __construct(CheckoutRepositoryInterface $checkoutRepo)
    {
        $this->checkoutRepo = $checkoutRepo;
    }
    public function show()
    {
        $data = $this->checkoutRepo->getCheckoutData();

        if (isset($data['redirect'])) {
            return redirect($data['redirect'])->with('info', $data['message']);
        }

        return view('frontend.pages.checkout', $data);
    }

    public function process(ProcessCheckoutRequest $request)
    {
        try {
            $uuid = $this->checkoutRepo->processCheckout($request->validated());
            return redirect()->route('order.confirmation', $uuid);
        } catch (\Throwable $e) {
            return redirect()->back()->with('toast_error', $e->getMessage());
        }
    }

    public function confirmation($uuid)
    {
        $order = $this->checkoutRepo->getOrderConfirmation($uuid);
        return view('frontend.pages.order_confirmation', compact('order'));
    }
}
