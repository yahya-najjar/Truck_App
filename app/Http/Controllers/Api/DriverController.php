<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Models\Truck;
use App\Models\Truck_log;
use App\Http\Responses\Responses;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Validator;
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
         $validator = Validator::make($request->all(), [
                    'plate_num' => 'required',
        ]);
        if ($validator->fails()) {
            $message = $validator->errors();
            $msg = $message->first();
            return Responses::respondError($msg);
        }
        $user_id = \Auth::user()->id;
        $customer = Customer::find($user_id);
        $plate_num = $request->plate_num;
        $truck = Truck::where('plate_num',$plate_num)->first();
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
         $validator = Validator::make($request->all(), [
                    'plate_num' => 'required',
        ]);
        if ($validator->fails()) {
            $message = $validator->errors();
            $msg = $message->first();
            return Responses::respondError($msg);
        }
        $user_id = \Auth::user()->id;
        $customer = Customer::find($user_id);
        $plate_num = $request->plate_num;
        $truck = Truck::where('plate_num',$plate_num);
        $lat = $request['lat'];
        $lng = $request['lng'];

        $log = new Truck_log([
            'online' => 0,
            'truck_id' => $truck->id,
            'lat'=>$lat,
            'lng'=>$lng
        ]);

        return Responses::respondSuccess([]);
    }
}
