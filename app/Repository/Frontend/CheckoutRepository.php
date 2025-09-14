<?php

namespace App\Repository\Frontend;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutRepository implements CheckoutRepositoryInterface
{
/**
     * Get checkout page data
     * steps:
     * 1. get cart
     * 2. check if cart is empty
     * 3. calculate total
     * 4. return cart and total
     */
    public function getCheckoutData(): array
    {
        $cart = session()->get('cart', []);

        // if cart is empty, redirect to home page
        if (empty($cart)) {
            return ['redirect' => route('home'), 'message' => 'Cart is empty'];
        }

        $total = array_reduce($cart, fn($sum, $item) => $sum + $item['price'] * $item['quantity'], 0);

        return ['cart' => $cart, 'total' => $total];
    }

    /**
     * Process the checkout
     * steps:
     * 1. get cart
     * 2. check if cart is empty
     * 3. validate stock
     * 4. create order
     * 5. reduce stock
     * 6. return order uuid
     */
    public function processCheckout($data): string
    {
        $cart = session()->get('cart', []);

        // if cart is empty, throw validation exception
        if (empty($cart)) {
            throw ValidationException::withMessages(['cart' => 'Cart is empty']);
        }

        DB::beginTransaction();
        try {
            $this->validateStock($cart);
            $order = $this->createOrder($cart, $data);
            DB::commit();

            session()->forget('cart');

            return $order->uuid;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e; // Let controller handle the error display
        }
    }

    /**
     * Get order confirmation data
     * steps:
     * 1. get order
     * 2. return order
     */
    public function getOrderConfirmation($uuid)
    {
        return Order::with('orderItems.product')
            ->where('uuid', $uuid)
            ->firstOrFail();
    }

    /**
     * Validate stock for all cart items
     */
    private function validateStock(array $cart): void
    {
        foreach ($cart as $id => $item) {
            // lock for update to prevent race condition when multiple users try to checkout at the same time
            $product = Product::lockForUpdate()->find($id);
            if (!$product) {
                throw ValidationException::withMessages(['cart' => "Product {$item['name']} not found"]);
            }

            if ($product->stock < $item['quantity']) {
                throw ValidationException::withMessages(['cart' => "Not enough stock for {$item['name']} (available: {$product->stock})"]);
            }
        }
    }

    /**
     * Create order and reduce stock
     */
    private function createOrder(array $cart, array $data): Order
    {
        $total = array_reduce($cart, fn($sum, $item) => $sum + $item['price'] * $item['quantity'], 0);

        $order = Order::create(array_merge($data, ['total' => $total]));

        foreach ($cart as $id => $item) {
            // lock for update to prevent race condition when multiple users try to checkout at the same time
            $product = Product::lockForUpdate()->find($id);
            $product->decrement('stock', $item['quantity']);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $product->price,
                'quantity' => $item['quantity'],
                'subtotal' => $product->price * $item['quantity'],
            ]);
        }

        return $order;
    }
}
