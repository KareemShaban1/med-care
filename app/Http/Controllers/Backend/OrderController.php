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

    protected $order;

    public function __construct(OrderRepositoryInterface $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        return $this->order->index();
    }

    public function data()
    {
        return $this->order->data();
    }

    public function create()
    {
        return $this->order->create();
    }

    public function store(StoreOrderRequest $request)
    {
        return $this->order->store($request);
    }

    public function show(Order $order)
    {
        return $this->order->show($order);
    }

    public function edit(Order $order)
    {
        return $this->order->edit($order);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        return $this->order->update($request, $order);
    }

    public function destroy(Order $order)
    {
        return $this->order->destroy($order);
    }

    public function changeStatus(Request $request, Order $order)
    {
        return $this->order->changeStatus($request, $order);
    }
   
}
