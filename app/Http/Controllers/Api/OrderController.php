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
use App\Models\Order_logs;
use App\User;
use App\Customer;
use App\Http\Responses\Responses;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Validator;

class OrderController extends Controller
{

	public function order(Request $request)
	{
		$lat = $request['lat'];
		$lng = $request['lng'];

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

		$order_log = new Order_log([
			'status'=>0,
			'lat'=>$lat,
			'lng'=>$lng,
			'order_id'=>$order->id,
		]);
		$order_log->save();
		$order_log->order()->associate($order);
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
			$truck->rating = $truck->RatingAvg;
			$truck->save();
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
		$validator = Validator::make($request->all(), [
			'lat' => 'required',
			'lng' => 'required',
		]);

		if ($validator->fails()) {
			$message = $validator->errors();
			$msg = $message->first();
			return Responses::respondError($msg);
		}

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

		$lat = $request['lat'];
		$lng = $request['lng'];
		$user_id = \Auth::user()->id;
		$customer = Customer::find($user_id);
		$type = $customer->type;

		$trucks = Truck::select('*')
				->join('customers','trucks.id','=','customers.truck_id')->get();
		return $trucks;
		$trucks = Truck::where('status',1)
		->where('type',$type);
		foreach ($trucks->get() as $key => $truck) {
			$d = $truck->distance($lat,$lng,'K');
			$truck->distances = $d;
			$truck->save();
		}
		$trucks =  $trucks->orderBy('distances', 'asc')->paginate($limit);

		$paginator = [
			'total_count' => $trucks->total(),
			'limit'       => $trucks->perPage(),
			'total_page'  => ceil($trucks->total() / $trucks->perPage()),
			'current_page'=> $trucks->currentPage()
		];

		return Responses::respondSuccess($trucks->all(),$paginator);
	}

	public function Payment_type(Request $request)
	{
		$customer = Customer::find(\Auth::user()->id);
		$customer->payment_type = $request->payment_type;
		return Responses::respondSuccess();
	}
}