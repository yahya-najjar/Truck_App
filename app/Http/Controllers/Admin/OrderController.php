<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use DB,Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        $states = Order::states();
        $orders = Order::all();
        return view('admin.orders.index',compact('states','orders'));
    }

    public function orders(Request $request)
    {
        // if (isset($request->status) || $request->status == 0)
        //     $from_order = (int) $request->status;
        // else
        //     $from_order = 'All';
        $from_order = $request->status;
        if (!isset($from_order)) {
            $from_order = 'All';
        }
        if ($from_order == 'All') {
            $orders = Order::select('*');
        }
        else
            $orders = Order::where('status',$from_order);

        $columns = array(
            0 =>'customer_id',
            1 =>'driver_id',
            2=> 'status',
            3=> 'rating',
            4=> 'comment',
            5=> 'created_at',
            6=> 'actions',
        );
        $totalData = count($orders->get());
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $rolet = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $orders = $orders->offset($rolet)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }
        else {
            $search = $request->input('search.value');

            $orders = DB::table('orders')->Join('customers', 'customers.id', '=','orders.customer_id')
            ->where('status','=',$from_order)
            ->where('customers.id','LIKE',"%{$search}%")
            ->orWhere('customers.first_name', 'LIKE',"%{$search}%")
            ->orWhere('customers.last_name', 'LIKE',"%{$search}%")
            ->offset($rolet)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();


            $totalFiltered = DB::table('orders')->Join('customers', 'customers.id', '=','orders.customer_id')
            ->where('status','=',$from_order)
            ->where('customers.id','LIKE',"%{$search}%")
            ->orWhere('customers.first_name', 'LIKE',"%{$search}%")
            ->orWhere('customers.last_name', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if($orders){
            foreach ($orders as $order) {
                $nestedData['customer_name']= $order->customer->FullName;
                $nestedData['driver_name']= $order->driver->FullName;
                $nestedData['status']= $order->StatusName;
                $nestedData['rating']= $order->rating;
                $nestedData['comment']= $order->comment;
                $nestedData['created_at']= $order->created_at->format('d M Y - H:i:s') .' '. Carbon::parse($order->created_at)->diffForHumans();
                $nestedData['actions']= '<a  data-toggle="tooltip" data-placement="top" title="Show Order Location" target="_blank"' .
                    '  href="'. action("Admin\OrderController@show",$order) .'" data-original-title="Ride"><i style=" color:#000;" class="fas fa-map-marked-alt m-r-10"></i> </a>';
                
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

    public function destroy(Order $order)
    {

        $order->delete();
        return back()->with('danger','Item Deleted');
    }

    public function show(Order $order)
    {
        $logs = $order->order_logs;
        return view('admin.orders.show',compact('order','logs'));
    }
}
