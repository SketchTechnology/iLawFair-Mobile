<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
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
        $orders = $user->orders()->with('orderItems.book')->get();
        return ApiResponse::sendResponse(200, 'Orders retrieved successfully', OrderResource::collection($orders));
    }

    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
    $cart = $user->cart;
    $cartItems = $cart->cartItems()->with('book')->get();
    $totalPrice = $cartItems->sum(function($cartItem) {
        return $cartItem->book->price;
    });

    $order = new Order();
    $order->user()->associate($user);
    $order->cart()->associate($cart);
    $order->total_price = $totalPrice;
    $order->save();

    foreach ($cartItems as $cartItem) {
        $orderItem = new OrderItem();
        $orderItem->order()->associate($order);
        $orderItem->book()->associate($cartItem->book);
        // $orderItem->price = $cartItem->book->price;
        $orderItem->save();
    }

    $cart->cartItems()->delete();

    return ApiResponse::sendResponse(201, 'Order placed successfully', $order);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('orderItems.book');
        return ApiResponse::sendResponse(200, 'Order retrieved successfully', $order);
    }

    
    public function destroy(Order $order)
    {
        $order->delete();
        return ApiResponse::sendResponse(200, 'Order deleted successfully');
    }
}
