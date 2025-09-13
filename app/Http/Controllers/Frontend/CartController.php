<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repository\Frontend\CartRepositoryInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{

    protected $cartRepositoryInterface;

    public function __construct(CartRepositoryInterface $cartRepositoryInterface)
    {
        $this->cartRepositoryInterface = $cartRepositoryInterface;
    }

    public function add(Request $request, $id)
    {
        return $this->cartRepositoryInterface->add($request, $id);
    }

    public function index()
    {
        return $this->cartRepositoryInterface->index();
    }

    public function update(Request $request)
    {
        return $this->cartRepositoryInterface->update($request);
    }

    public function remove($id)
    {
        return $this->cartRepositoryInterface->remove($id);
    }
}
