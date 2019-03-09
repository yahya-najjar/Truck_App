<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use DB;
class CustomerController extends Controller
{

    public function customers(){
        return view('admin.customers.customers');
    }

    public function all_customers(Request $request)
    {
        $customers = DB::table('customers')->where('type',Customer::CUSTOMER)->select('customers.*');

        $columns = array(
            0 =>'id',
            1 =>'first_name',
            2 =>'email',
            3 =>'phone',
            4 =>'payment_type',
            5=> 'registeration_completed',
            6=> 'created_at',
            7=> 'id',
        );
        $totalData = count($customers->get());
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $rolet = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $customers = $customers->offset($rolet)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }
        else {
            $search = $request->input('search.value');

            $customers = DB::table('customers')
            ->where('customers.id','LIKE',"%{$search}%")
            ->orWhere('customers.first_name', 'LIKE',"%{$search}%")
            ->orWhere('customers.last_name', 'LIKE',"%{$search}%")
            ->orWhere('customers.phone', 'LIKE',"%{$search}%")
            ->orWhere('customers.email', 'LIKE',"%{$search}%")
            ->offset($rolet)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();


            $totalFiltered = DB::table('customers')
            ->where('customers.id','LIKE',"%{$search}%")
            ->orWhere('customers.first_name', 'LIKE',"%{$search}%")
            ->orWhere('customers.last_name', 'LIKE',"%{$search}%")
            ->orWhere('customers.phone', 'LIKE',"%{$search}%")
            ->orWhere('customers.email', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if($customers){
            foreach ($customers as $customer) {

                $fa =  $customer->active==1? 'times':'check';
                $txt = $customer->active==1?'danger':'success';
                $tlp = $customer->active==1?'Deactivate':'Activate';
                $customer = Customer::find($customer->id);

                $nestedData['id']= $customer->id;
                $nestedData['name']= $customer->first_name . " " . $customer->last_name;
                $nestedData['email']= $customer->email;
                $nestedData['phone']= $customer->phone;
                $nestedData['payment_type']= $customer->payment_type ? 'Cash':'Credit';
                $nestedData['registeration']= $customer->registeration_completed ? 'Yes':'No' ;
                $nestedData['created_at']= $customer->created_at->format('d M Y - H:i:s');
                $nestedData['actions']='<a class="btn default btn-outline" title="Edit Customer" data-placement="top" href="'. action("Admin\CustomerController@edit", $customer) . '"><i style="color: #1e88e5;" class="fas fa-user-edit" data-toggle="tooltip" data-placement="left" title="Edit Customer"></i></a>'
                                     .'<a class="btn default btn-outline" data-delete href="javascript:void(0);"><i
                                        class="fas fa-user-' . $fa . ' text-'. $txt . ' m-r-10" data-toggle="tooltip" data-placement="top" title="'. $tlp .' Customer "></i></a>'
                                     .'<form action="'. action("Admin\CustomerController@destroy",  $customer ). ' " method="post" id="delete"> '. csrf_field() .' '. method_field('DELETE') .' </form>';
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

    public function drivers(){
        return view('admin.customers.drivers');
    }

    public function all_drivers(Request $request)
    {
        $drivers = DB::table('customers')->where('type',Customer::DRIVER)->select('customers.*');

        $columns = array(
            0 =>'id',
            1 =>'first_name',
            2 =>'email',
            3 =>'phone',
            4 =>'payment_type',
            5=> 'registeration_completed',
            6=> 'created_at',
            7=> 'id',
        );
        $totalData = count($drivers->get());
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $rolet = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $drivers = $drivers->offset($rolet)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }
        else {
            $search = $request->input('search.value');

            $drivers = DB::table('customers')
            ->where('customers.id','LIKE',"%{$search}%")
            ->orWhere('customers.first_name', 'LIKE',"%{$search}%")
            ->orWhere('customers.last_name', 'LIKE',"%{$search}%")
            ->orWhere('customers.phone', 'LIKE',"%{$search}%")
            ->orWhere('customers.email', 'LIKE',"%{$search}%")
            ->offset($rolet)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();


            $totalFiltered = DB::table('customers')
            ->where('customers.id','LIKE',"%{$search}%")
            ->orWhere('customers.first_name', 'LIKE',"%{$search}%")
            ->orWhere('customers.last_name', 'LIKE',"%{$search}%")
            ->orWhere('customers.phone', 'LIKE',"%{$search}%")
            ->orWhere('customers.email', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if($drivers){
            foreach ($drivers as $driver) {

                $fa =  $driver->active==1? 'times':'check';
                $txt = $driver->active==1?'danger':'success';
                $tlp = $driver->active==1?'Deactivate':'Activate';
                $driver = Customer::find($driver->id);

                $nestedData['id']= $driver->id;
                $nestedData['name']= $driver->first_name . " " . $driver->last_name;
                $nestedData['email']= $driver->email;
                $nestedData['phone']= $driver->phone;
                $nestedData['payment_type']= $driver->payment_type ? 'Cash':'Credit';
                $nestedData['registeration']= $driver->registeration_completed ? 'Yes':'No' ;
                $nestedData['created_at']= $driver->created_at->format('d M Y - H:i:s');
                $nestedData['actions']='<a class="btn default btn-outline" title="Edit driver" data-placement="top" href="'. action("Admin\CustomerController@edit", $driver) . '"><i style="color: #1e88e5;" class="fas fa-user-edit" data-toggle="tooltip" data-placement="left" title="Edit Customer"></i></a>'
                                     .'<a class="btn default btn-outline" data-delete href="javascript:void(0);"><i
                                        class="fas fa-user-' . $fa . ' text-'. $txt . ' m-r-10" data-toggle="tooltip" data-placement="top" title="'. $tlp .' Customer "></i></a>'
                                     .'<form action="'. action("Admin\CustomerController@destroy",  $driver ). ' " method="post" id="delete"> '. csrf_field() .' '. method_field('DELETE') .' </form>';
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::where('type',Customer::CUSTOMER)->paginate(5);
        return view('admin.customers.customers',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view ('admin.customers.edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Customer $customer)
    {
        $customer->update($request->except(['password']));
        $customer->password = bcrypt($request->password);
        $customer->save();

        return back()->with('success','Customer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->active = ($customer->active==1?-1:1);
        $customer->save();
        return back()->with('danger','Customer Deactivated');
    }
}
