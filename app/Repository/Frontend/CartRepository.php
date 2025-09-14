<?php

namespace App\Repository\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;

class CartRepository implements CartRepositoryInterface
{
    /**
     * Get the cart from session
     */
    protected function getCart(): array
    {
        return session()->get('cart', []);
    }

    /**
     * Save cart to session
     */
    protected function saveCart(array $cart): void
    {
        session(['cart' => $cart]);
    }

    /**
     * Calculate total of cart
     */
    protected function calculateTotal(array $cart): float
    {
        return array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);
    }

    /**
     * Add product to cart
     * steps:
     * 1. get product
     * 2. get cart
     * 3. check stock
     * 4. check if product is already in cart
     * 5. add product to cart
     */
    public function add($request, $id): array
    {
        $product = Product::findOrFail($id);
        $cart = $this->getCart();
        $qty = max(1, (int)$request->input('quantity', 1));

        // check stock
        if ($qty > $product->stock) {
            return ['success' => false, 'message' => 'Only ' . $product->stock . ' pcs available in stock.'];
        }

        // check if product is already in cart
        if (isset($cart[$id])) {
            $newQty = $cart[$id]['quantity'] + $qty;
            if ($newQty > $product->stock) {
                return ['success' => false, 'message' => 'Cannot add more than ' . $product->stock . ' pcs of this product.'];
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

        $this->saveCart($cart);

        return ['success' => true, 'message' => 'Added to cart', 'cart' => $cart];
    }

    /**
     * Get cart contents
     */
    public function index(): array
    {
        $cart = $this->getCart();
        $total = $this->calculateTotal($cart);

        return ['cart' => $cart, 'total' => $total];
    }

    /**
     * Update cart item
     * steps:
     * 1. get cart
     * 2. get product
     * 3. check if product exists
     * 4. check quantity
     * 5. remove item if quantity is 0
     * 6. check stock
     * 7. update cart
     */
    public function update($request, $id): array
    {
        $cart = $this->getCart();
        $product = Product::find($id);

        // check if product exists
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }

        // check quantity
        $qty = max(0, (int)$request->input('quantity', 1));

        // remove item if quantity is 0
        if ($qty === 0) {
            unset($cart[$id]);
            $this->saveCart($cart);

            return ['success' => true, 'message' => 'Item removed from cart', 'removed' => true, 'cart' => $cart];
        }

        // check stock
        if ($qty > $product->stock) {
            $cart[$id]['quantity'] = $product->stock;
            $this->saveCart($cart);

            return [
                'success' => false,
                'message' => 'Only ' . $product->stock . ' pcs available for ' . $product->name,
                'quantity' => $product->stock,
                'cart' => $cart
            ];
        }

        $cart[$id]['quantity'] = $qty;
        $this->saveCart($cart);

        return [
            'success' => true,
            'message' => 'Cart updated',
            'quantity' => $qty,
            'subtotal' => number_format($product->price * $qty, 2),
            'total' => number_format($this->calculateTotal($cart), 2),
            'cart' => $cart
        ];
    }

    /**
     * Remove item from cart
     * steps:
     * 1. get cart
     * 2. check if product exists
     * 3. remove item
     * 4. save cart
     */
    public function remove($id): array
    {
        $cart = $this->getCart();
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->saveCart($cart);
        }

        return ['success' => true, 'cart' => $cart];
    }
}
