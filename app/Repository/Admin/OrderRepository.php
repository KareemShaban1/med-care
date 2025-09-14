<?php

namespace App\Repository\Admin;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderRepository implements OrderRepositoryInterface
{
    /** ---------------------- PUBLIC METHODS ---------------------- */

    
    public function index()
    {
        return [];
    }



    public function data()
    {
        $orders = Order::with('orderItems.product');

        return datatables()->of($orders)
            ->editColumn('status', fn($item) => $this->orderStatusDropdown($item))
            ->addColumn('action', fn($item) => $this->orderActions($item))
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create()
    {
        return [];
    }

    public function store($request)
    {
        try {
            $order = Order::create($request->validated());

            // Optional: handle order items if provided
            $this->saveOrderItems($order, $request);

            return $this->jsonResponse('success', __('Order created successfully'), route('admin.orders.index'));
        } catch (\Throwable $e) {
            return $this->jsonResponse('error', $e->getMessage());
        }
    }

    public function show($uuid)
    {
        $order = Order::with('orderItems.product')->where('uuid', $uuid)->first();

        return response()->json([
            'id' => $order->id,
            'customer_name' => $order->customer_name,
            'customer_phone' => $order->customer_phone,
            'delivery_address' => $order->delivery_address,
            'status' => $order->status,
            'total' => $order->total,
            'orderItems' => $order->orderItems->map(fn($item) => [
                'product' => $item->product->name ?? 'N/A',
                'quantity' => $item->quantity,
                'price' => $item->unit_price,
                'subtotal' => $item->quantity * $item->unit_price,
            ])
        ]);
    }

    public function edit($uuid)
    {
        return Order::with('orderItems.product')->where('uuid', $uuid)->first();
    }

    public function update($request, $uuid)
    {
        $order = Order::with('orderItems.product')->where('uuid', $uuid)->first();
        try {
            $order->update($request->validated());

            $this->saveOrderItems($order, $request);

            return $this->jsonResponse('success', __('Order updated successfully'), route('admin.orders.index'));
        } catch (\Throwable $e) {
            return $this->jsonResponse('error', __('Failed to update order: ') . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        $order->delete();
        return $this->jsonResponse('success', __('Order deleted successfully'));
    }

    public function changeStatus($request, $id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return $this->jsonResponse('success', __('Order status updated successfully'));
    }


    /** ---------------------- PRIVATE HELPERS ---------------------- */

    private function orderStatusDropdown(Order $order): string
    {
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        $statusClass = match ($order->status) {
            'pending' => 'bg-warning',
            'processing' => 'bg-info',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary',
        };

        $badge = "<span class='badge $statusClass'>" . __($order->status) . "</span>";

        $options = '';
        foreach ($statuses as $status) {
            $selected = $order->status === $status ? 'selected' : '';
            $options .= "<option value='{$status}' {$selected}>" . __($status) . "</option>";
        }

        $select = "<select class='form-select form-select-sm change-status' data-id='{$order->id}'>$options</select>";

        return $badge . ' ' . $select;
    }

    private function orderActions(Order $order): string
    {
   
        return <<<HTML
        <div class="d-flex gap-2">
            <button data-id="{$order->uuid}" class="btn btn-sm btn-primary btn-show"><i class="fa fa-eye"></i></button>
            <button onclick="deleteOrder({$order->id})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
        </div>
        HTML;
    }

    private function saveOrderItems(Order $order, $request)
    {
        if ($request->has('items')) {
            foreach ($request->items as $itemId => $data) {
                $orderItem = $order->orderItems()->find($itemId);
                if ($orderItem) {
                    $orderItem->update([
                        'unit_price' => $data['price'],
                        'quantity' => $data['quantity'],
                        'subtotal' => $data['price'] * $data['quantity'],
                    ]);
                }
            }
        }
    }

    private function jsonResponse(string $status, string $message, string $redirect = null)
    {
        if (request()->ajax()) {
            return response()->json(['status' => $status, 'message' => $message]);
        }

        return $redirect
            ? redirect($redirect)->with($status, $message)
            : redirect()->back()->with($status, $message);
    }
}
