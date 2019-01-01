<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
		$orders = Order::all();
		return view('admin.orders.index',compact('orders'));    	
    }

        public function destroy(Order $order)
    {

        $order->delete();
        return back()->with('danger','Item Deleted');
    }
}
