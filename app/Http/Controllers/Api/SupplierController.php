<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Responses\Responses;
use App\Models\Supplier;

class SupplierController extends Controller
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
        $suppliers = Supplier::paginate($limit);

        $paginator = [
            'total_count' => $suppliers->total(),
            'limit'       => $suppliers->perPage(),
            'total_page'  => ceil($suppliers->total() / $suppliers->perPage()),
            'current_page'=> $suppliers->currentPage()
        ];

        return Responses::respondSuccess($suppliers->all(),$paginator);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $supplier = Supplier::find($request->id);
        if ($supplier) 
            return Responses::respondSuccess($supplier);
        $msg = 'there is no supplier found with this id';
        return Responses::respondError($msg);   
    }

    public function trucks(Request $request)
    {
        $limit = $request->limit ? : 5 ;
        if($limit > 30 ) $limit =30 ;

        $supplier = Supplier::find($request->id);
        if($supplier){
            $trucks = $supplier->truck()->paginate($limit);
            $paginator = [
                'total_count' => $trucks->total(),
                'limit'       => $trucks->perPage(),
                'total_page'  => ceil($trucks->total() / $trucks->perPage()),
                'current_page'=> $trucks->currentPage()
            ];
            return Responses::respondSuccess( $trucks->all(),$paginator);
        }

        $msg = 'there is no supplier found with this id';
        return Responses::respondError($msg);   
        
    }

    public function search(Request $request){
        $limit = $request->limit ? : 5 ;
        if($limit > 30 ) $limit =30 ;
        
        $data = $request->get('word');

        $suppliers = Supplier::where('name', 'like', "%{$data}%")
        ->orWhere('description', 'like', "%{$data}%")
        ->orWhere('phone', 'like', "%{$data}%")
        ->paginate($limit);
        $paginator = [
            'total_count' => $suppliers->total(),
            'limit'       => $suppliers->perPage(),
            'total_page'  => ceil($suppliers->total() / $suppliers->perPage()),
            'current_page'=> $suppliers->currentPage()
        ];

        if (count($suppliers)) {
            return Responses::respondSuccess($suppliers->all(),$paginator);
        }
        $msg = 'there is no supplier found with this name or contain this word in description';
        return Responses::respondError($msg);  


    }
}
