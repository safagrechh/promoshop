<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product; // Don't forget to import the Product model

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $price = $request->input('price');
    
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
    
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $price, // Include the product price in the cart
            ];
        }
    
        session()->put('cart', $cart);
    
        return redirect()->back()->with('success', 'Product added to cart.');
    }
    
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
    
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
    
        // You can respond with a JSON success message
        return response()->json(['message' => 'Product removed from cart.']);
    }
    

    public function showCart()
    {
        $cart = session()->get('cart', []);
    
        // Prepare the cart data for Inertia
        $cartData = [];
        foreach ($cart as $productId => $cartItem) {
            $cartData[] = [
                'product' => $cartItem['product'],
                'quantity' => $cartItem['quantity'],
            ];
        }
    
        return inertia('Cart/Show', [
            'cart' => $cartData,
        ]);
    }
    
}
