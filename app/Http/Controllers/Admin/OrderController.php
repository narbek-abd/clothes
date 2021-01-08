<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', 1)->get();
        return view('admin/orders/index', compact('orders'));
    }

    public function show($order_id)
    {
        $order = Order::find($order_id);
        return view('admin/orders/show', compact('order'));
    }
}