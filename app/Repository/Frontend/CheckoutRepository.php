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
    public function show()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('home')->with('info', 'Cart is empty');
        $total = array_reduce($cart, fn($s, $i) => $s + $i['price'] * $i['quantity'], 0);
        return view('frontend.pages.checkout', compact('cart', 'total'));
    }

    public function process($request)
    {
        $data = $request->validated();

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('home')->with('info', 'Cart is empty');
        }

        DB::beginTransaction();
        try {
            // stock checks & reduce stock
            foreach ($cart as $id => $item) {
                $product = Product::lockForUpdate()->find($id);
                if (!$product) throw ValidationException::withMessages(['cart' => "Product {$item['name']} not found"]);
                if ($product->stock < $item['quantity']) {
                    throw ValidationException::withMessages(['cart' => "Not enough stock for {$item['name']} (available: {$product->stock})"]);
                }
            }

            // create order
            $total = array_reduce($cart, fn($s, $i) => $s + $i['price'] * $i['quantity'], 0);
            $order = Order::create(array_merge($data, ['total' => $total]));

            foreach ($cart as $id => $item) {
                $product = Product::find($id);
                // decrease stock
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

            DB::commit();
            session()->forget('cart');

            return redirect()->route('order.confirmation', $order->uuid);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('toast_error', $e->getMessage());
        }
    }

    public function confirmation($uuid)
    {
        $order = Order::with('orderItems.product')
        ->where('uuid', $uuid)->firstOrFail();
        return view('frontend.pages.order_confirmation', compact('order'));
    }
}
