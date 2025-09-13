<?php

namespace App\Repository\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;

class CartRepository implements CartRepositoryInterface
{
    protected function getCart()
    {
        return session()->get('cart', []);
    }

    public function add($request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = $this->getCart();

        $qty = max(1, (int)$request->input('quantity', 1));

        // check stock before adding
        if ($qty > $product->stock) {
            return redirect()->back()->with('toast_error', 'Only ' . $product->stock . ' pcs available in stock.');
        }

        if (isset($cart[$id])) {
            $newQty = $cart[$id]['quantity'] + $qty;

            if ($newQty > $product->stock) {
                return redirect()->back()->with('toast_error', 'Cannot add more than ' . $product->stock . ' pcs of this product.');
            }

            $cart[$id]['quantity'] = $newQty;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $qty,
                'image' => $product->main_image_url
            ];
        }

        session(['cart' => $cart]);

        return redirect()->back()->with('toast_success', 'Added to cart');
    }

    public function index()
    {
        $cart = $this->getCart();
        $total = array_reduce($cart, fn($sum, $i) => $sum + ($i['price'] * $i['quantity']), 0);
        return view('frontend.pages.cart', compact('cart', 'total'));
    }

    public function update($request, $id)
    {
        $cart = $this->getCart();
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
    
        $qty = (int) $request->input('quantity', 1);
    
        // remove item if quantity is 0 or less
        if ($qty <= 0) {
            unset($cart[$id]);
            session(['cart' => $cart]);
    
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'removed' => true
            ]);
        }
    
        // stock validation
        if ($qty > $product->stock) {
            $cart[$id]['quantity'] = $product->stock;
            session(['cart' => $cart]);
    
            return response()->json([
                'success' => false,
                'message' => 'Only ' . $product->stock . ' pcs available for ' . $product->name,
                'quantity' => $product->stock
            ], 400);
        }
    
        // update quantity
        $cart[$id]['quantity'] = $qty;
        session(['cart' => $cart]);
    
        // calculate totals
        $subtotal = $product->price * $qty;
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    
        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'quantity' => $qty,
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($total, 2)
        ]);
    }
    

    public function remove($id)
    {
        $cart = $this->getCart();
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        return response()->json(['success' => true, 'cart' => $cart]);
    }
}
