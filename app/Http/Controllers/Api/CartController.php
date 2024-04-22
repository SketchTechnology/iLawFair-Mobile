<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Book;
 use Illuminate\Support\Facades\Auth;
 use App\Helpers\ApiResponse;
use App\Http\Resources\CartItemResource;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function  __construct (){
        $this->middleware('auth:sanctum') ;
    }


    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart;
        $cartItems = $cart->cartItems()->with('book')->get();
        return ApiResponse::sendResponse(200, 'Cart retrieved successfully', CartItemResource::collection($cartItems));
    }

    /**
     * Show the form for creating a new resource.
     */
    
    /**
     * Store a newly created resource in storage.
     */
     
     public function store(Request $request)
{
    try {
        $user = Auth::user();
        $cart = $user->cart;

        if (!$cart) {
            // Create a new cart for the user if they don't have one
            $cart = new Cart();
            $cart->user()->associate($user);
            $cart->save();
        }

        $book = Book::findOrFail($request->book_id);

        $cartItem = new CartItem();
        $cartItem->cart()->associate($cart);
        $cartItem->book()->associate($book);
        $cartItem->save();

        return ApiResponse::sendResponse(201, 'Book added to cart successfully', $cartItem);
    } catch (\Exception $e) {
        // Handle any exceptions, such as book not found or database errors
        return ApiResponse::sendResponse('Error adding book to cart', $e->getMessage(), 500);
    }
}

    /**
     * Display the specified resource.
     */
   

    /**
     * Show the form for editing the specified resource.
     */
   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $cartItem->update($request->all());
        return ApiResponse::sendResponse(200, 'Cart item updated successfully', $cartItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();
        return ApiResponse::sendResponse(200, 'Cart item deleted successfully');
    }


    public function clear()
    {
        $user = Auth::user();
        $cart = $user->cart;
        $cart->cartItems()->delete();
        return ApiResponse::sendResponse(200, 'Cart cleared successfully');
    }
}
