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
        // $validator = Validator::make($request->all(),['plate_num' => 'required',]);
        // if ($validator->fails())
        // {
        //     $message = $validator->errors();
        //     $msg = $message->first();
        //     return Responses::respondError($msg);
        // // }
        // $user_id = \Auth::user()->id;
        // $driver = Customer::find($user_id);
        $driver =  JWTAuth::parseToken()->authenticate();

        // $plate_num = $request->plate_num;
        // $truck = Truck::where('user_id',$driver->id)->first();
        $truck_id = DB::table('customer_truck')
                            ->where('customer_id',$driver->id)
                            ->first()->truck_id;

        $truck = Truck::find($truck_id);

        if(!$truck){
            return Responses::respondError("You Don't have any truck yet");
        }

        $truck->status = 1;

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
        // if ($driver->truck) {
        //     $driver->truck()->dissociate();
        // }
        // $driver->truck_id = $truck->id;
        // $driver->save();
        // $driver->truck()->associate($truck);

        return Responses::respondSuccess([]);
    }

    public function offline(Request $request)
    {
        $validator = Validator::make($request->all(), ['plate_num' => 'required']);
        if ($validator->fails()) {
            $message = $validator->errors();
            $msg = $message->first();
            return Responses::respondError($msg);
        }
        $user_id = \Auth::user()->id;
        $driver = Customer::find($user_id);
        $plate_num = $request->plate_num;
        $truck = Truck::where('plate_num',$plate_num)->first();
        if(!$truck){
            return Responses::respondError("Please enter a valid plate number");
        }
        $truck->status = 0;
        $truck->save();

        $lat = $request['lat'];
        $lng = $request['lng'];

        $log = new Truck_log([
            'online' => 0,
            'truck_id' => $truck->id,
            'lat'=>$lat,
            'lng'=>$lng
        ]);

        $log->save();
        $log->truck()->associate($truck);
        return Responses::respondSuccess([]);
    }

    public function getOrders(Request $request)
    {
        $limit = $request->limit ? : 5 ;
        if($limit > 30 ) $limit =30 ;
        
        $driver =  JWTAuth::parseToken()->authenticate();
        $truck_id = DB::table('customer_truck')
                    ->where('customer_id',$driver->id)
                    ->first()->truck_id;
        $truck = Truck::find($truck_id);

        $orders = $truck->pendingOrders()->paginate($limit);
        // return Responses::respondSuccess($truck->ord);



        $paginator = [
            'total_count' => $orders->total(),
            'limit'       => $orders->perPage(),
            'total_page'  => ceil($orders->total() / $orders->perPage()),
            'current_page'=> $orders->currentPage()
        ];
        return Responses::respondSuccess($orders->all(),$paginator);
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

        $order->status = -1;
        $order->save();

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

        $order->status = 1;
        $order->save();

        $order_log = new Order_log([
            'status'=>1,
            'lat'=>$lat,
            'lng'=>$lng,
            'order_id'=>$order->id,
        ]);
        $order_log->save();
        $order_log->order()->associate($order);

        $truck = $order->truck;
        $truck->status = 2;
        $truck->save();

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

        $order->status = 2;
        $order->save();

        $order_log = new Order_log([
            'status'=>2,
            'lat'=>$lat,
            'lng'=>$lng,
            'order_id'=>$order->id,
        ]);
        $order_log->save();
        $order_log->order()->associate($order);

        $truck = $order->truck;
        $truck->status = 1;
        $truck->save();

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
}
