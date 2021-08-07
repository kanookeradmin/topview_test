<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function getOrders()
    {
        return response()->json(Order::with('getOrderPackage.getPackage')->get());
    }
    public function createOrder(Request $request)
    {
        $order = new Order();
        return response()->json($order->createOrder($request));
    }

}
