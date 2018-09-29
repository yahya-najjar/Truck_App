<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
	public function online(){
		$allTrucks = Truck::all();
		$trucks = array();
		foreach ($allTrucks as $key => $truck)
		{
			if($truck->IsOnline)
				if($truck->IsOnline->online)
					array_push($trucks,$truck);
		}
		return view('admin.trucks.online',compact('trucks'));
	}
}
