<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart; // Import the Cart facade

class CartController extends Controller
{
    public function store(Request $request)
    {
        // Find the product by its ID
        $product = Product::findOrFail($request->input('product_id'));

        // Get the quantity from the form, default to 1
        $quantity = $request->input('quantity', 1);

        // Check if there is enough stock
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Not enough stock available!');
        }

        // Add the product to the cart
        Cart::add(
            $product->id,
            $product->name,
            $quantity,
            $product->price,
            // Add any options, like size or color, or a product image
            ['image' => 'default.jpg'] // We'll add real images in Module 8
        );

        // Redirect back to the shop page with a success message
        return redirect()->route('shop.index')->with('success', 'Product added to cart!');
    }

        // --- NEW METHOD ---
    public function index()
    {
        // The package automatically gets the cart from the session
        // $cartItems = Cart::content(); // This is a Collection
        // $cartTotal = Cart::total();
        // $cartCount = Cart::count();

        // No logic needed, just return the view.
        // We can access Cart::content() directly in Blade.
        return view('cart.index');
    }

        public function destroy($rowId)
    {
        // Remove the item from the cart
        Cart::remove($rowId);

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }

    public function clear()
    {
        // Destroy the entire cart
        Cart::destroy();

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

}