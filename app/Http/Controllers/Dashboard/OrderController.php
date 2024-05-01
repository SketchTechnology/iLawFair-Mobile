<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;




class OrderController extends Controller
{
    public function index()
    
    {
        $user = Auth::user();

        $orders = Order::with('orderItems.book')->get();
        return view('dashboard.orders.index', compact('orders'));
    }

    public function destroy(Order $order)
    {
      
        // dd($order)  ;
        $order->delete() ;
 
        Alert::success('Success', "order Deleted Successfully");

        return redirect()->route('orders.index');
    }

}
