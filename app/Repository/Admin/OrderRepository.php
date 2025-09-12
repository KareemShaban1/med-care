<?php

namespace App\Repository\Admin;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;

class OrderRepository implements OrderRepositoryInterface
{
    public function index()
    {
        return view('backend.pages.orders.index');
    }

    public function data()
    {
        $orders = Order::query();

        return datatables()->of($orders)
            ->editColumn('status', function ($item) {
                $statuses = ['pending', 'processing', 'completed', 'cancelled'];
                $statusClass = match ($item->status) {
                    'pending' => 'bg-warning',
                    'processing' => 'bg-info',
                    'completed' => 'bg-success',
                    'cancelled' => 'bg-danger',
                };
                $options = '';
                foreach ($statuses as $status) {
                    $selected = $item->status === $status ? 'selected' : '';
                    $options .= "<option value='$status' $selected>$status</option>";
                }
                return "
                <span class='badge $statusClass'>{$item->status}</span>
                <select class='form-select form-select-sm change-status' data-id='$item->id'>$options</select>";
            })
            ->addColumn('action', function ($item) {
                return view('backend.pages.orders.partials.actions', compact('item'))->render();
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('backend.pages.orders.create');
    }

    public function store($request)
    {
        $order = Order::create($request->validated());

        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully');
    }

    public function show($order)
    {
        // Load order items if you have relation like $order->items
        $order->load('orderItems.product');

        return response()->json([
            'id' => $order->id,
            'customer_name' => $order->customer_name,
            'customer_phone' => $order->customer_phone,
            'delivery_address' => $order->delivery_address,
            'status' => $order->status,
            'total' => $order->total,
            'orderItems' => $order->orderItems->map(function ($item) {
                return [
                    'product' => $item->product->name ?? 'N/A',
                    'quantity' => $item->quantity,
                    'price' => $item->unit_price,
                    'subtotal' => $item->quantity * $item->unit_price
                ];
            })
        ]);
    }

    public function edit($order)
    {
        return view('backend.pages.orders.edit', compact('order'));
    }

    public function update($request, $order)
    {
      try {
        // Update order main info
        $order->update([
            'customer_name'    => $request->customer_name,
            'customer_phone'   => $request->customer_phone,
            'delivery_address' => $request->delivery_address,
            'total'            => $request->total, // recalculated on frontend JS
        ]);
    
        // Handle items
        if ($request->has('items')) {
            foreach ($request->items as $itemId => $data) {
                $orderItem = $order->orderItems()->find($itemId);
                if ($orderItem) {
                    $orderItem->update([
                        'unit_price' => $data['price'],
                        'quantity'   => $data['quantity'],
                        'subtotal'   => $data['price'] * $data['quantity'],
                    ]);
                }
            }
        }
    
        return redirect()->route('admin.orders.index')->with('toast_success', 'Order updated successfully');
      } catch (\Exception $e) {
        return redirect()->back()->with('toast_error', 'Failed to update order: ' . $e->getMessage());
      }
    }
    

    public function destroy($order)
    {
        $order->delete();
        return response()->json(['success' => true]);
    }

    public function changeStatus($request, $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return response()->json(['success' => true, 'status' => $request->status, 'toast_success' => 'Order status updated successfully']);
    }   
}