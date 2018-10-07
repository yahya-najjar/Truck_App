<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class RatingController extends Controller
{

    public function showRatings($star){
        return view('admin.rating.index',['star'=>$star]);
    }

    public function ratings(Request $request){
        if (isset($request->star))
            $from_star = $request->star;
        else
            $from_star = 1;

        $ratings = Order::getRatingsPerStar($from_star);
        $columns = array( 
                            0 =>'id', 
                            1 =>'user_id',
                            2=> 'truck_id',
                            3=> 'rating',
                            4=> 'created_at',
                            5=> 'id',
                        );
        $totalData = count($ratings->get());
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

         if(empty($request->input('search.value')))
            {            
                $ratings = $ratings->offset($start)
                             ->limit($limit)
                             ->orderBy($order,$dir)
                             ->get();
            }
            else {
                $search = $request->input('search.value'); 

                $ratings = Order::select('orders.*','users.name')->leftJoin('users', 'users.id', '=','orders.user_id')->where('orders.rating','=',$from_star)->where('orders.id','LIKE',"%{$search}%")
                                ->orWhere('users.name', 'LIKE',"%{$search}%")
                                ->where('orders.rating','=',$from_star)
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();


                $totalFiltered = Order::select('orders.*','users.name')->leftJoin('users', 'users.id', '=','orders.user_id')->where('orders.rating','=',$from_star)->where('orders.id','LIKE',"%{$search}%")
                                ->orWhere('users.name', 'LIKE',"%{$search}%")
                                ->where('orders.rating','=',$from_star)
                                ->count();
            }

        $data = array();
        if($ratings){
        foreach ($ratings as $rate) {

                $nestedData['id']= $rate->id;
                $nestedData['customer']= $rate->user->name;
                $nestedData['driver']= $rate->truck->driver_name;
                $nestedData['rating']= $rate->rating;
                $nestedData['created_at']= $rate->created_at->format('d M Y - H:i:s');
                $nestedData['show']= $rate->id;
                $data[] = $nestedData;
            }
        }
     
      $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );

           echo json_encode($json_data);

    }

    
}
