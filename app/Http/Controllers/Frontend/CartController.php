<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repository\Frontend\CartRepositoryInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartRepositoryInterface $cartRepo;

    public function __construct(CartRepositoryInterface $cartRepo)
    {
        $this->cartRepo = $cartRepo;
    }

    public function add(Request $request, $id)
    {
        $response = $this->cartRepo->add($request, $id);

        return redirect()->back()->with(
            $response['success'] ? 'toast_success' : 'toast_error',
            $response['message']
        );
    }

    public function index()
    {
        $data = $this->cartRepo->index();
        return view('frontend.pages.cart', $data);
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->cartRepo->update($request, $id));
    }

    public function remove($id)
    {
        return response()->json($this->cartRepo->remove($id));
    }
}
