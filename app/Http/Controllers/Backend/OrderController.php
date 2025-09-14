<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Admin\OrderRepositoryInterface;

class OrderController extends Controller
{

    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        return view('backend.pages.orders.index');
    }

    public function data()
    {
        return $this->orderRepo->data();
    }

    public function create()
    {
        return view('backend.pages.orders.create');
    }

    public function store(StoreOrderRequest $request)
    {
        return $this->orderRepo->store($request);
    }

    public function show($uuid)
    {
        return $this->orderRepo->show($uuid);
    }

    public function edit($uuid)
    {
        $order = $this->orderRepo->edit($uuid);
        return view('backend.pages.orders.edit', compact('order'));
    }

    public function update(UpdateOrderRequest $request, $uuid)
    {
        return $this->orderRepo->update($request, $uuid);
    }

    public function destroy($uuid)
    {
        return $this->orderRepo->destroy($uuid);
    }

    public function changeStatus(Request $request, $uuid)
    {
        return $this->orderRepo->changeStatus($request, $uuid);
    }
   
}
