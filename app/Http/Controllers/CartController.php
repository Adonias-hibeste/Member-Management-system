<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function show(Request $request)
    {
        $userId = Auth::id(); // Ensure user is authenticated
        $cart = Cart::where('user_id', $userId)->with('product')->get();

        $cartItems = $cart->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->product->name,
                'unit_price' => $item->product->unit_price,
                'quantity' => $item->quantity,
                'available_quantity' => $item->product->quantity,
                'image' => $item->product->images->first()->image ?? 'default_image.jpg'
            ];
        });

        // Return the correct mapped cart items
        return response()->json(['cart' => $cartItems]);
    }


    // Add a product to the cart
    public function add(Request $request)
    { try {
        Log::info('Add to cart request received: ', $request->all());

        if (!Auth::check()) {
            Log::error('User not authenticated');
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $product = Product::find($request->product_id);
        if (!$product) {
            Log::error('Product not found: ' . $request->product_id);
            return response()->json(['message' => 'Product not found'], 404);
        }

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            if ($cartItem->quantity < $product->quantity) {
                $cartItem->quantity += 1;
                $cartItem->save();
                Log::info('Cart updated: ', $cartItem->toArray());
            } else {
                return response()->json(['message' => 'Not enough stock'], 400);
            }
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => 1,
                'unit_price' => $product->unit_price
            ]);
            Log::info('New cart item created for user: ' . Auth::id());
        }

        $cartCount = Cart::where('user_id', Auth::id())->count();
        return response()->json(['message' => 'Product added to cart', 'cartCount' => $cartCount]);
    } catch (\Exception $e) {
        Log::error('Error in addToCart: ' . $e->getMessage());
        return response()->json(['error' => 'Something went wrong'], 500);
    }
    }

    // Update the quantity of a cart item
    public function update(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->input('product_id');
        $newQuantity = $request->input('quantity');

        // Ensure the cart item exists and the new quantity is valid
        $cartItem = Cart::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($cartItem && $newQuantity > 0 && $newQuantity <= $cartItem->product->quantity) {
            $cartItem->update(['quantity' => $newQuantity]);
            return response()->json(['message' => 'Cart updated successfully']);
        }

        return response()->json(['error' => 'Invalid quantity or product not found'], 400);
    }


    // Remove a product from the cart
    public function remove(Request $request)
    {
        $userId =Auth::id(); // Ensure user is authenticated
        $productId = $request->input('product_id');

        Cart::where('user_id', $userId)->where('product_id', $productId)->delete();

        $cartCount = Cart::where('user_id', $userId)->count();
        return response()->json(['message' => 'Item removed from cart', 'cartCount' => $cartCount]);
    }


}
