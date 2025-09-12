<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected function getCart()
    {
        return session()->get('cart', []);
    }
    
    public function add(Request $request, $id)
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

    public function update(Request $request)
    {
        $cart = $this->getCart();

        foreach ($request->input('quantity', []) as $id => $qty) {
            $product = Product::find($id);

            if (!$product) continue; // skip if product not found

            if ($qty <= 0) {
                unset($cart[$id]);
                continue;
            }

            if ($qty > $product->stock) {
                // cap the quantity at stock limit
                $cart[$id]['quantity'] = $product->stock;
                session(['cart' => $cart]);
                return redirect()->route('cart.index')->with('toast_error', 'Only ' . $product->stock . ' pcs available for ' . $product->name);
            }

            $cart[$id]['quantity'] = (int)$qty;
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('toast_success', 'Cart updated');
    }

    public function remove(Request $request, $id)
    {
        $cart = $this->getCart();
    if (isset($cart[$id])) {
        unset($cart[$id]);
        session(['cart' => $cart]);
    }

    return response()->json(['success' => true, 'cart' => $cart]);
    }
}
