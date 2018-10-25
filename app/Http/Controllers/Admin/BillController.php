<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Truck;
use App\Models\Supplier;
use Carbon\Carbon;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers=Supplier::all();
        $trucks=Truck::PrivateTrucks();

        $bills=Bill::all();
        return view ('admin.bills.index',compact('bills','suppliers','trucks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         //return view ('admin.suppliers.create');
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
        'cash_amount'  =>      'required|numeric',
        'month_count' =>      'required|numeric',
        'note' =>      'required ',

    ]);

    $truck =Truck::find($request['truck_id']);

     $licence_date = Carbon::parse($truck->licence_date);
     $expire_date = Carbon::parse($truck->expire_date);

     $diff = $licence_date->diffInMonths($expire_date);

     if($request['month_count'] > $diff){
        $msg = 'Month Count Should Be Less Than '. $diff . ' Months, Or the client Should update his driving licence !';
        return back()->withErrors([$msg]);
     }
     
     $bill = new Bill($request->all());
     $bill->save();

     $supplier = $request['supplier_id'];
     $bill->supplier()->associate($supplier);

     $truck = $request['truck_id'];
     $bill->truck()->associate($truck);

     $month_count = $request['month_count'];
     if(isset($supplier)) 
     {
         $supplier = Supplier::find( $request['supplier_id']);
         $sup_date = Carbon::parse($supplier->expire_date)->addMonths($month_count);
         $supplier->expire_date = $sup_date;
         $supplier->save();
     }
     else{
       $truck = Truck::find( $request['truck_id']);
       $sup_date = Carbon::parse($truck->expire_date)->addMonths($month_count);
       $truck->expire_date = $sup_date;
       $truck->save();

   }



   return back()->with('success','Account Renewed successfully !');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        $suppliers = Supplier::all();
        $trucks=Truck::all();

        return view ('admin.bills.show',compact('trucks','bill','suppliers'));    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
       $suppliers = Supplier::all();
       $trucks=Truck::all();
       return view ('admin.bills.edit',compact('trucks','suppliers','bill'));
   }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        $bill->update($request->all());
        $bill->save();

        return back()->with('success','Item Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        $bill->delete();
        return back()->with('danger','Item Deleted');
    }
}
