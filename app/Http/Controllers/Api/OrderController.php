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
use App\Models\Order_log;
use App\User;
use App\Customer;
use App\Http\Responses\Responses;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Validator,DB;

class OrderController extends Controller
{

	public function myOrders(Request $request)
	{
		$limit = $request->limit ? : 5 ;
		if($limit > 30 ) $limit =30 ;
		$validator = Validator::make($request->all(), [
			'status' => 'required',
		]);

		if ($validator->fails()) {
			$message = $validator->errors();
			$msg = $message->first();
			return Responses::respondError($msg);
		}

		$customer = JWTAuth::parseToken()->authenticate();
		$status = $request['status'];
        $orders = $customer->customer_orders($status)->paginate($limit);
		$paginator = [
			'total_count' => $orders->total(),
			'limit'       => $orders->perPage(),
			'total_page'  => ceil($orders->total() / $orders->perPage()),
			'current_page'=> $orders->currentPage()
		];	

		return Responses::respondSuccess($orders->all(),$paginator);

	}

	public function order(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'lst' => 'required',
			'lng' => 'required',
			'comment' => 'required',
			'location' => 'required',
		]);

		if ($validator->fails()) {
			$message = $validator->errors();
			$msg = $message->first();
			return Responses::respondError($msg);
		}
		$lat = $request['lat'];
		$lng = $request['lng'];
		$comment = $request['comment'];
		$location = $request['location'];

		$customer =  JWTAuth::parseToken()->authenticate();
		$truck = Truck::find($request['truck_id']);

		if(!isset($truck))
			return Responses::respondError('truck not found');

		if($truck->status != Truck::ONLINE or isset($truck->pendingOrder()->id)){
			return Responses::respondError('truck already requested');			
		}


		$order = new Order([
			'status'=>0,
			'rating'=>0,
			'customer_id'=>$customer->id,
			'truck_id'=>$truck->id,
			'lat'=>$lat,
			'lng'=>$lng,
			'comment'=>$comment,
			'location'=>$location
		]);

		$driver = $truck->currentDriver ;
		$order->driver()->associate($driver);
		$order->customer()->associate($customer);
		$order->truck()->associate($truck);
		$order->save();

		$truck->status = Truck::ONREQUEST;
		$truck->save();

		$order_log = new Order_log([
			'status'=>Order::PENDING,
			'lat'=>$lat,
			'lng'=>$lng,
			'location'=>$location,
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
		$validator = Validator::make($request->all(), [
			'order_id' => 'required',
			'rating' => 'required',
		]);

		if ($validator->fails()) {
			$message = $validator->errors();
			$msg = $message->first();
			return Responses::respondError($msg);
		}
		$customer =  JWTAuth::parseToken()->authenticate();
		$order = Order::find($request['order_id']);
		$rating = $request['rating'];

		if(!isset($order))        
			return Responses::respondError('order not found');
		$truck = $order->truck;

		if(isset($order)){
			$order->rating = $rating;
			$order->save();
			$truck->rating = $truck->RatingAvg;
			$truck->save();
			return Responses::respondSuccess([]);
		} 

	}


	// get the nearest online trucks
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

		$lat = $request['lat'];
		$lng = $request['lng'];
		$customer = JWTAuth::parseToken()->authenticate();
		$user_id = $customer->id;
		$type = $customer->type;

		$date = Carbon::Now()->addSeconds(-60);
		$trucks = Truck::where('updated_at','>=',$date)->where('status',Truck::ONLINE);

		foreach ($trucks->get() as $key => $truck) {
			$d = $truck->distance($lat,$lng,'K');
			$truck->distances = $d;
		}
		if(isset($request['distance']))
			$trucks =  $trucks->where('distances','<',$request['distance'])->orderBy('distances', 'asc')->paginate($limit);
		else
			$trucks =  $trucks->orderBy('distances', 'asc')->paginate($limit);
		foreach ($trucks as $key => $truck) {
			$d = $truck->distance($lat,$lng,'K');
			$truck->distances = $d;
		}

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
		$customer = JWTAuth::parseToken()->authenticate();
		$customer->payment_type = $request->payment_type;
		return Responses::respondSuccess();
	}

	public function getOrderById(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'order_id' => 'required',
		]);

		if ($validator->fails()) {
			$message = $validator->errors();
			$msg = $message->first();
			return Responses::respondError($msg);
		}
		// $order = Order::with('truck','order_logs')->find($request->order_id);
		$order = DB::table('orders')->where('orders.id',$request->order_id)
					->join('order_logs',function ($join){
						$join->on('order_logs.order_id','=','orders.id')
						->where('order_logs.status',Order::ACCEPTED);
					})
					->join('trucks',function ($query)
					{
						$query->on('orders.truck_id','=','trucks.id');
					})
					->select('orders.*','order_logs.location as location_from','orders.location as location_to','trucks.location as location_current','order_logs.lat as lat_from','order_logs.lng as lng_from','orders.lat as lat_to','orders.lng as lng_to','trucks.lat as lat_current','trucks.lng as lng_current','trucks.driver_name as current_driver','trucks.plate_num','trucks.desc','trucks.lat as truck_lat','trucks.lng as truck_lng','trucks.status as truck_status','trucks.image','orders.status as order_status')
					->get();
		return Responses::respondSuccess($order);
	}

	public function cancelOrder(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'order_id' => 'required',
			'lat' => 'required',
			'lng' => 'required',
			'location' =>'required'
		]);
		if ($validator->fails()) {
		    $message = $validator->errors();
		    $msg = $message->first();
		    return Responses::respondError($msg);
		}
		$lat = $request['lat'];
		$lng = $request['lng'];
		$location = $request['location'];

		$order = Order::find($request->order_id);
		if(!$order){
		    return Responses::respondError("order not exist any more !");
		}
		if ($order->status == Order::CANCELED) {
		    return Responses::respondError("The order is already set as CANCELED");
		}
		if ($order->status != Order::PENDING) {
		    return Responses::respondError("The Order is not pending any more");
		}

		$order->status = Order::CANCELED;
		$order->save();

		$truck = $order->truck;
		$truck->status = Truck::ONLINE;
		$truck->save();

		$order_log = new Order_log([
		    'status'=> Order::CANCELED,
		    'lat'=>$lat,
		    'lng'=>$lng,
		    'location' => $location,
		    'order_id'=>$order->id,
		]);
		$order_log->save();
		$order_log->order()->associate($order);
		if ($order) {
		    return Responses::respondSuccess([]);
		}
	}

}