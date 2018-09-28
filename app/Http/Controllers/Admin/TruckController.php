<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\Supplier;

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
        return view ('admin.trucks.index',compact('trucks','suppliers'));
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
        'plate_num' =>      'required',
        'capacity' =>      'required',
        'model' =>      'required',
        'driver_phone' =>      'required',
        'location' =>      'required',
        // 'status' =>      'required',
        'price_km' =>      'required',
        'price_h' =>      'required',
        'company_phone' =>      'required',
        'supplier_id' =>      'required',
    ]);
       $truck = new Truck($request->all());
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
        $suppliers = Supplier::all();
        return view ('admin.trucks.show',compact('truck','suppliers'));
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
}
