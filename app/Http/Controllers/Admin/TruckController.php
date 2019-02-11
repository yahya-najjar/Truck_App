<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\Supplier;
use App\Customer;
use Carbon\Carbon,DB;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trucks=Truck::all();
        $suppliers = Supplier::all();
        $from_status = 4;
        return view ('admin.trucks.index',compact('trucks','suppliers','from_status'));
    }

    public function locations(){
        $date = Carbon::Now()->addSeconds(-60);
        $trucks = Truck::where('updated_at','>=',$date)->where('status',Truck::ONLINE)->get();

        $trucks = Truck::all(); // temp
        return json_encode($trucks);
    }


    public function allTrucks(Request $request,$status = null)
    {
        if (isset($status))
            $from_status = $status;
        else
            $from_status = 1;
        switch ($from_status) {
            case 4:
                $trucks=Truck::all();
                break;
            case 1:
                $date = Carbon::Now()->addSeconds(-60);
                $trucks = Truck::where('updated_at','>=',$date)->where('status',Truck::ONLINE)->get();
                break;
            case 2:
            case 3:
                $trucks = Truck::where('status',$from_status)->get();
                break;
        }
        $suppliers = Supplier::all();
        return view ('admin.trucks.index',compact('trucks','suppliers','from_status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::all();
        return view ('admin.trucks.create',compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'driver_name'  =>      'required',
            'plate_num' =>      'required|unique:trucks',
            'capacity' =>      'required | numeric',
            'model' =>      'required',
            'driver_phone' =>      'required | numeric',
            // 'location' =>      'required',
            // 'status' =>      'required',
            'desc' => 'required',
            'image' =>      'required | image',
            'price_km' =>      'required | numeric',
            'price_h' =>      'required | numeric',
            'company_phone' =>      'required | numeric',
            'expire_date' => 'required',
            'licence_date' => 'required',
        ]);

        $input = $request->all();

        if (isset($request->image))
        {
            $input['image'] = request('image')->store('images','public');
        }

        $input['status'] = Truck::OFFLINE;

        
        $truck = new Truck($input);
        $truck->save();
        $supplier = $request['supplier_id'];
        $truck->supplier()->associate($supplier);
        return back()->with('success','Item created successfully !');
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Truck $truck)
    {
        return view ('admin.trucks.show',compact('truck'));
    }


    public function location(Truck $truck)
    {
        return view ('admin.trucks.get_truck_location',compact('truck'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Truck $truck)
    {
        $suppliers = Supplier::all();
        return view ('admin.trucks.edit',compact('truck','suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Truck $truck)
    {
        $truck->update($request->all());
        $truck->save();

        return back()->with('success','Item Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Truck $truck)
    {

        $truck->delete();
        return back()->with('danger','Item Deleted');
    }

    public function online()
    {
            return view('admin.trucks.online');
    }

    public function online_trucks(Request $request)
    {
        $date = Carbon::Now()->addSeconds(-60);
        $trucks = Truck::where('updated_at','>=',$date)->where('status',Truck::ONLINE);
        // if (! $request->ajax()) 
        //     $trucks = $trucks->get();
        //     return view('admin.trucks.online',compact('trucks'));

        $columns = array( 
                            0 =>'id', 
                            1 =>'driver_name',
                            2=> 'status',
                            3=> 'location',
                            4=> 'updated_at',
                            5=> 'id',
                        );
        $totalData = count($trucks->get());
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

         if(empty($request->input('search.value')))
            {            
                $trucks = $trucks->offset($start)
                             ->limit($limit)
                             ->orderBy($order,$dir)
                             ->get();
            }
            else {
                $search = $request->input('search.value'); 

                $trucks = Truck::where('updated_at','>=',$date)->where('status',Truck::ONLINE)->where('trucks.id','LIKE',"%{$search}%")
                                ->orWhere('trucks.driver_name', 'LIKE',"%{$search}%")
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->get();


                $totalFiltered = Truck::where('updated_at','>=',$date)->where('status',Truck::ONLINE)->where('trucks.id','LIKE',"%{$search}%")
                                ->orWhere('trucks.driver_name', 'LIKE',"%{$search}%")
                                ->count();
            }

        $data = array();
        if($trucks){
        foreach ($trucks as $truck) {

                $nestedData['id']= $truck->id;
                $nestedData['driver']= $truck->driver_name;
                $nestedData['status']= $truck->status;
                $nestedData['location']= $truck->location;
                $nestedData['last_update']= $truck->updated_at->format('d M Y - H:i:s');
                $nestedData['show']= $truck->id;
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

    public function orders(Truck $truck)
    {
        $orders = $truck->orders;
        return view('admin.trucks.orders',compact('truck','orders'));
    }

    public function shifts(Truck $truck)
    {
        $drivers = Customer::drivers()->get();
       return view('admin.trucks.shifts',compact('truck','drivers'));
    }

    public function get_truck_shifts($truck_id)
    {

        $shifts = DB::table('customer_truck')
                    ->join('customers', function ($join) use ($truck_id) {
                        $join->on('customer_truck.customer_id', '=', 'customers.id')
                             ->where('customer_truck.truck_id', '=', $truck_id);
                    })
                    ->select('customer_truck.*','customers.first_name','customers.last_name')
                    ->get();      


        return response()->json([
            'status' => true,
            'data' => $shifts,
        ]);
    }


}
