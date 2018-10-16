<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Http\Responses\Responses;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TruckController extends Controller
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
        $trucks = Truck::paginate($limit);

        $paginator = [
            'total_count' => $trucks->total(),
            'limit'       => $trucks->perPage(),
            'total_page'  => ceil($trucks->total() / $trucks->perPage()),
            'current_page'=> $trucks->currentPage()
        ];

        return Responses::respondSuccess($trucks->all(),$paginator);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $truck = Truck::find($request->id);
        if ($truck) 
            return Responses::respondSuccess($truck);
        $msg = 'there is no truck found with this id';
        return Responses::respondError($msg);   
    }


    public function supplier(Request $request)
    {
        $truck = Truck::find($request->id);
        if ($truck) {
            $supplier = $truck->supplier;
            if ($supplier) {
                return Responses::respondSuccess($supplier);
            }
            return Responses::respondError('there is no supplier found with this truck'); 
        }
        return Responses::respondError('there is no truck found with this id'); 
    }

    public function search(Request $request){
        $limit = $request->limit ? : 5 ;
        if($limit > 30 ) $limit =30 ;
        
        $data = $request->get('word');

        $trucks = Truck::where('driver_name', 'like', "%{$data}%")
        ->orWhere('plate_num', 'like', "%{$data}%")
        ->orWhere('location', 'like', "%{$data}%")
        ->orWhere('model', 'like', "%{$data}%")
        ->orWhere('driver_phone', 'like', "%{$data}%")
        ->orWhere('company_phone', 'like', "%{$data}%")
        ->paginate($limit);
        $paginator = [
            'total_count' => $trucks->total(),
            'limit'       => $trucks->perPage(),
            'total_page'  => ceil($trucks->total() / $trucks->perPage()),
            'current_page'=> $trucks->currentPage()
        ];

        if (count($trucks)) {
            return Responses::respondSuccess($trucks->all(),$paginator);
        }
        $msg = 'there is no truck found with this driver name, plate number, phone or contain this word in location or model';
        return Responses::respondError($msg);  
    }
}
