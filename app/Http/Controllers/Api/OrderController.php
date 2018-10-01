<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Truck_log;
use App\Models\Truck;
use App\Models\Order;
use App\User;
use App\Http\Responses\Responses;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;


class OrderController extends Controller
{

	public function order(Request $request)
	{
		$lat = 0;
		$lng = 0;

		$location = 0;

		$customer =  \Auth::user();
		$truck = Truck::find($request['truck_id']);

		if(!isset($truck))        
			return Responses::respondError('truck not found');

		$ord = Order::where('user_id',$customer->id)
		->where('truck_id',$truck->id)
		->first();
		if(isset($ord))        
			return Responses::respondSuccess($ord);

		$order = new Order([
			'status'=>0,
			'rating'=>0,
			'user_id'=>$customer->id,
			'truck_id'=>$truck->id,
			'lat'=>$lat,
			'lng'=>$lng,
			'location'=>$location
		]);
		$order->save();
		$order->user()->associate($customer);
		$order->truck()->associate($truck);

		if ($order) {
			return Responses::respondSuccess([]);
		}

	}

	public function rating(Request $request)
	{
		$customer =  \Auth::user();
		$truck = Truck::find($request['truck_id']);
		$rating = $request['rating'];

		if(!isset($truck))        
			return Responses::respondError('truck not found');

		$ord = Order::where('user_id',$customer->id)
		->where('truck_id',$truck->id)
		->first();
		if(isset($ord)){
			$ord->rating = $rating;
			$ord->save();
			return Responses::respondSuccess([]);
		} 

		return Responses::respondError('order not found');      
	}

	public function accept(Request $request)
	{

	}

	public function online(Request $request){

		$limit = $request->limit ? : 5 ;
		if($limit > 30 ) $limit =30 ;

		// $allTrucks = Truck::all();
		// $trucks = array();
		// foreach ($allTrucks as $key => $truck)
		// {
		// 	if($truck->IsOnline)
		// 		if($truck->IsOnline->online)
		// 			array_push($trucks,$truck);
		// 	}

		// 	$trucks = Collection::make($trucks)->first();
		// 	$trucks = $trucks->paginate($limit);

		$trucks = Truck::where('status',1)->paginate($limit);

			$paginator = [
				'total_count' => $trucks->total(),
				'limit'       => $trucks->perPage(),
				'total_page'  => ceil($trucks->total() / $trucks->perPage()),
				'current_page'=> $trucks->currentPage()
			];

			return Responses::respondSuccess($trucks->all(),$paginator);
		}
	}