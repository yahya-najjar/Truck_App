<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Models\Order;
use App\Models\Order_log;
use App\Models\Truck;
use App\Models\Truck_log;
use App\Http\Responses\Responses;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Validator,DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Carbon\Carbon;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ? : 5 ;
        if($limit > 30 ) $limit =30 ;
        $drivers = Customer::drivers()->paginate($limit);

        $paginator = [
            'total_count' => $drivers->total(),
            'limit'       => $drivers->perPage(),
            'total_page'  => ceil($drivers->total() / $drivers->perPage()),
            'current_page'=> $drivers->currentPage()
        ];

        return Responses::respondSuccess($drivers->all(),$paginator);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $driver = Customer::drivers()->where('id',$request->id);
        if ($driver) 
            return Responses::respondSuccess($driver);
        $msg = 'there is no driver found with this id';
        return Responses::respondError($msg);   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function truck(Request $request)
    {
        $driver = Customer::drivers()->where('id',$request->id);
        if ($driver) {
            $truck = $driver->truck;
            if ($truck) {
                return Responses::respondSuccess($truck);
            }
            return Responses::respondError('there is no truck found with this driver'); 
        }
        return Responses::respondError('there is no driver found with this id');
    }

    public function search(Request $request){
        $limit = $request->limit ? : 5 ;
        if($limit > 30 ) $limit =30 ;
        
        $data = $request->get('word');

        $drivers = Customer::drivers()->where('first_name', 'like', "%{$data}%")
        ->orWhere('last_name', 'like', "%{$data}%")
        ->orWhere('email', 'like', "%{$data}%")
        ->orWhere('model', 'like', "%{$data}%")
        ->orWhere('phone', 'like', "%{$data}%")
        ->paginate($limit);
        $paginator = [
            'total_count' => $drivers->total(),
            'limit'       => $drivers->perPage(),
            'total_page'  => ceil($drivers->total() / $drivers->perPage()),
            'current_page'=> $drivers->currentPage()
        ];

        if (count($drivers)) {
            return Responses::respondSuccess($drivers->all(),$paginator);
        }
        $msg = 'there is no drivers found with this name, email, phone or contain this word in model';
        return Responses::respondError($msg);  
    }

    public function online(Request $request)
    {
        $driver =  JWTAuth::parseToken()->authenticate();
        $shifts = DB::table('customer_truck')
                            ->where('customer_id',$driver->id)
                            ->get();
        if (!isset($shifts)) 
            return Responses::respondError("You Don't have any shift yet");

        $my_shift =null;
        foreach ($shifts as $key => $shift) {
            $now = Carbon::now('Asia/Damascus')->hour;
            $from = Carbon::parse($shift->from)->hour;
            $to = Carbon::parse($shift->to)->hour;
            if ($from <= $now && $now < $to) {
                $my_shift = $shift; 
                continue;
            }
        }

        if ($my_shift == null)
            return Responses::respondError("Please check your shift time");

        $truck = Truck::find($my_shift->truck_id);
        if(!$truck)
            return Responses::respondError("You Don't have any truck yet");

        $truck->status = Truck::ONLINE;
        $truck->driver_name = $driver->FullName;
        $truck->save();

        $lat = $request['lat'];
        $lng = $request['lng'];

        $log = new Truck_log([
            'online' => 1,
            'truck_id' => $truck->id,
            'lat'=>$lat,
            'lng'=>$lng
        ]);
        $log->save();
        $log->truck()->associate($truck);
        return Responses::respondSuccess([]);
    }

    public function offline(Request $request)
    {
       $driver =  JWTAuth::parseToken()->authenticate();
        $shifts = DB::table('customer_truck')
                            ->where('customer_id',$driver->id)
                            ->get();
        if (!isset($shifts)) 
            return Responses::respondError("You Don't have any shift yet");

        $my_shift =null;
        foreach ($shifts as $key => $shift) {
            $now = Carbon::now('Asia/Damascus')->hour;
            $from = Carbon::parse($shift->from)->hour;
            $to = Carbon::parse($shift->to)->hour;
            if ($from <= $now && $now < $to) {
                $my_shift = $shift; 
                continue;
            }
        }

        if ($my_shift == null)
            return Responses::respondError("Please check your shift time");

        $truck = Truck::find($my_shift->truck_id);
        if(!$truck)
            return Responses::respondError("You Don't have any truck yet");

        $truck->status = Truck::OFFLINE;
        $truck->driver_name = $driver->FullName;
        $truck->save();

        $lat = $request['lat'];
        $lng = $request['lng'];

        $log = new Truck_log([
            'online' => Truck::OFFLINE,
            'truck_id' => $truck->id,
            'lat'=>$lat,
            'lng'=>$lng
        ]);
        $log->save();
        $log->truck()->associate($truck);
        return Responses::respondSuccess([]);
    }

    public function getOrder(Request $request)
    {
        $limit = $request->limit ? : 5 ;
        if($limit > 30 ) $limit =30 ;
        
        $driver =  JWTAuth::parseToken()->authenticate();
        $truck = DB::table('customer_truck')
                    ->where('customer_id',$driver->id)
                    ->first();
        if (!isset($truck)) {
            return Responses::respondSuccess([]);
        }

        $truck = Truck::find($truck->truck_id);
        $order = $truck->pendingOrder();
        // return Responses::respondSuccess($truck->ord);

        return Responses::respondSuccess($order);
    }

    public function reject(Request $request)
    {
        $validator = Validator::make($request->all(), ['order_id' => 'required']);
        if ($validator->fails()) {
            $message = $validator->errors();
            $msg = $message->first();
            return Responses::respondError($msg);
        }
        $lat = $request['lat'];
        $lng = $request['lng'];

        $order = Order::find($request->order_id);
        if(!$order){
            return Responses::respondError("order not exist any more !");
        }
        if ($order->status != Order::PENDING) {
            return Responses::respondError("The Order is not pending any more");
        }

        $order->status = Order::REJECTED;
        $order->save();

        $truck = $order->truck;
        $truck->status = Truck::ONLINE;
        $truck->save();

        $order_log = new Order_log([
            'status'=>-1,
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

    public function accept(Request $request)
    {
        $validator = Validator::make($request->all(), ['order_id' => 'required']);
        if ($validator->fails()) {
            $message = $validator->errors();
            $msg = $message->first();
            return Responses::respondError($msg);
        }
        $lat = $request['lat'];
        $lng = $request['lng'];

        $order = Order::find($request->order_id);
        if(!$order){
            return Responses::respondError("order not exist any more !");
        }
        if ($order->status != Order::PENDING) {
            return Responses::respondError("The Order is not pending any more");
        }

        $order->status = Order::ACCEPTED;
        $order->save();

        $truck = $order->truck;
        $truck->status = Truck::BUSY;
        $truck->save();

        $order_log = new Order_log([
            'status'=>1, // log status const
            'lat'=>$lat,
            'lng'=>$lng,
            'order_id'=>$order->id,
        ]);
        $order_log->save();
        $order_log->order()->associate($order);

        $truck_log = new Truck_log([
            'online'=>2,
            'lat'=>$lat,
            'lng'=>$lng,
            'truck_id'=>$truck->id, 
        ]);
        $truck_log->save();
        $truck_log->truck()->associate($truck);

        if ($order && $order_log && $truck && $truck_log) {
            return Responses::respondSuccess([]);
        }
    }

    public function arrived(Request $request)
    {
        $validator = Validator::make($request->all(), ['order_id' => 'required']);
        if ($validator->fails()) {
            $message = $validator->errors();
            $msg = $message->first();
            return Responses::respondError($msg);
        }
        $lat = $request['lat'];
        $lng = $request['lng'];

        $order = Order::find($request->order_id);
        if(!$order){
            return Responses::respondError("order not exist any more !");
        }
        if ($order->status != Order::ACCEPTED) {
            return Responses::respondError("You should accept the order then set it as arrived");
        }

        $order->status = Order::ARRIVED;
        $order->save();

        $truck = $order->truck;
        $truck->status = Truck::BUSY;
        $truck->save();

        $order_log = new Order_log([
            'status'=>1, // log status const
            'lat'=>$lat,
            'lng'=>$lng,
            'order_id'=>$order->id,
        ]);
        $order_log->save();
        $order_log->order()->associate($order);

        $truck_log = new Truck_log([
            'online'=>2,
            'lat'=>$lat,
            'lng'=>$lng,
            'truck_id'=>$truck->id, 
        ]);
        $truck_log->save();
        $truck_log->truck()->associate($truck);

        if ($order && $order_log && $truck && $truck_log) {
            return Responses::respondSuccess([]);
        }
    }

    public function done(Request $request)
    {
        $validator = Validator::make($request->all(), ['order_id' => 'required']);
        if ($validator->fails()) {
            $message = $validator->errors();
            $msg = $message->first();
            return Responses::respondError($msg);
        }
        $lat = $request['lat'];
        $lng = $request['lng'];

        $order = Order::find($request->order_id);
        if(!$order){
            return Responses::respondError("order not exist any more !");
        }
        if ($order->status != Order::ARRIVED) {
            return Responses::respondError("The Order is not arrived yet");
        }

        $order->status = Order::DONE;
        $order->save();

        $truck = $order->truck;
        $truck->status = Truck::ONLINE;
        $truck->save();

        $order_log = new Order_log([
            'status'=>2,
            'lat'=>$lat,
            'lng'=>$lng,
            'order_id'=>$order->id,
        ]);
        $order_log->save();
        $order_log->order()->associate($order);


        $truck_log = new Truck_log([
            'online'=>1,
            'lat'=>$lat,
            'lng'=>$lng,
            'truck_id'=>$truck->id, 
        ]);
        $truck_log->save();
        $truck_log->truck()->associate($truck);

        if ($order && $order_log && $truck && $truck_log) {
            return Responses::respondSuccess([]);
        }
    }

    public function updateStatus(Request $request)
    {
        $driver =  JWTAuth::parseToken()->authenticate();
        $shifts = DB::table('customer_truck')
                            ->where('customer_id',$driver->id)
                            ->get();
        if (!isset($shifts)) 
            return Responses::respondError("You Don't have any shift yet");

        $my_shift =null;
        foreach ($shifts as $key => $shift) {
            $now = Carbon::now('Asia/Damascus')->hour;
            $from = Carbon::parse($shift->from)->hour;
            $to = Carbon::parse($shift->to)->hour;
            if ($from <= $now && $now < $to) {
                $my_shift = $shift; 
                continue;
            }
        }

        if ($my_shift == null)
            return Responses::respondError("Please check your shift time");

        $truck = Truck::find($my_shift->truck_id);
        $truck->lat = $request['lat'];
        $truck->lng = $request['lng'];
        // $truck->status = Truck::ONLINE;
        $truck->updated_at = Carbon::now('Asia/Damascus');
        $truck->save();
        return Responses::respondSuccess($truck->pendingOrder());
    }

    public function driver_orders(Request $request)
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

        // return Responses::respondSuccess($customer->all_orders($status));
        $orders = $customer->all_orders($status)->paginate($limit);
        $paginator = [
            'total_count' => $orders->total(),
            'limit'       => $orders->perPage(),
            'total_page'  => ceil($orders->total() / $orders->perPage()),
            'current_page'=> $orders->currentPage()
        ];

        

        return Responses::respondSuccess($orders->all(),$paginator);
    }
}
