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
        $from_status = 3;
        return view ('admin.trucks.index',compact('trucks','suppliers','from_status'));
    }

    public function allTrucks(Request $request,$status = null)
    {
        if (isset($status))
            $from_status = $status;
        else
            $from_status = 1;
        if($from_status==3)
            $trucks=Truck::all();
        else
            $trucks = Truck::where('status',$from_status)->get();
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
        $allTrucks = Truck::all();
        $trucks = array();
        foreach ($allTrucks as $key => $truck)
        {
            if($truck->IsOnline)
                if($truck->IsOnline->online)
                    array_push($trucks,$truck);
        }
        return view('admin.trucks.online',compact('trucks'));
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
        $truck = Truck::find($truck_id);
        $shifts = DB::table('customer_truck')
                            ->where('truck_id',$truck->id)
                            ->get();


        return response()->json([
            'status' => true,
            'data' => $shifts,
        ]);
    }


}
