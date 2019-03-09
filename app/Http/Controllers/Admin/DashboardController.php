<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\Order;
use App\Models\Supplier;
use App\Customer;

class DashboardController extends Controller
{
    public function index()
    {
    	$total_trucks = Truck::all()->count();
    	$total_customers = Customer::where('type',Customer::CUSTOMER)->get()->count();
    	$total_drivers = Customer::where('type',Customer::DRIVER)->get()->count();
    	$total_orders = Order::all()->count();
    	$total_suppliers = Supplier::all()->count();
    	$on_going = Order::OngoingCount();
    	$done = Order::DoneCount();
    	$canceled = Order::CancelCount();
    	$rejected = Order::RejectCount();
    	

    	return view('admin.dashboard',compact('total_suppliers','total_orders','total_drivers','total_customers','total_trucks','on_going','done','canceled','rejected'));
    }
}
