<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Customer;
use App\Role;
use App\Models\Truck;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Validator,DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a_users = User::all();
        $customers = Customer::all();

        $users = $a_users->merge($customers);

        $roles = Role::all();
        return view ('admin.users.index',compact('users','roles'));
    }

    public function admins(){

        $admins =  User::withRole('admin')->paginate(5);
        $roles = Role::all();
        return view('admin.users.admins',compact('admins','roles'));
    }

    public function customers(){
        // $customers = User::withRole('customer')->paginate(5);
        $customers = Customer::paginate(5);
        return view('admin.users.customers',compact('customers'));
    }

    public function drivers(){
        $drivers = Customer::drivers()->get();
        return response()->json([
            'status' => true,
            'drivers' => $drivers,
        ]);
    }

    public function suppliers(){
        $suppliers = User::withRole('supplier')->paginate(5);
        return view('admin.users.suppliers',compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view ('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,User $user){
        $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required']
        );

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_verified' => 1,
            'code' => 0,
        ]);

        $admin->roles()->attach($request->roles);
        return back()->with('success','User Created.');
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
    public function edit(User $user)
    {
        $roles = Role::all();
        $ids = $user->roles()->pluck('role_id')->toArray();
        return view ('admin.users.edit',compact('user','roles','ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        if(request('roles')){
            $user->roles()->detach();
            $roles = $request['roles'];
            $user->roles()->attach($roles);
        }
        $user->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->is_verified = ($user->is_verified==1?-1:1);
        $user->save();
        return back()->with('danger','User Deactivated');
    }

    function like(){
        return Response()->json("test");
    }

    public function addShift(Request $request)
    {
        $credentials = $request->only('truck_id','driver_id','note','start_time','end_time');
        $rules = [
            'truck_id' => 'required',
            'driver_id' => 'required',
            'note' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return Responses::respondError($validator->messages());
        }
        $driver_id = $request['driver_id'];
        $note = $request['note'];
        $start_time = $request['start_time'];
        $end_time = $request['end_time'];

        $truck = Truck::find($request['truck_id']);

        $truck->customers()->attach($driver_id,['note'=> $note,'from'=>$start_time,'to'=>$end_time]);

        return response()->json([
            'status' => true,
            'data' => $truck->customers()->first(),
        ]);

    }

    public function deleteShift(Request $request)
    {
        $driver_id = $request['driver_id'];
        $truck_id = $request['truck_id'];

        DB::table('customer_truck')
                            ->where('customer_id',$driver_id)
                            ->where('truck_id',$truck_id)
                            ->delete();

        return response()->json([
            'status' => true,
            'data' => $truck_id,
        ]);
    }

    public function updateShift(Request $request)
    {
        $driver_id = $request['driver_id'];
        $truck_id = $request['truck_id'];
        $from = $request['start_time'];
        $to = $request['end_time'];

        $shift = DB::table('customer_truck')
                            ->where('customer_id',$driver_id)
                            ->where('truck_id',$truck_id)
                            ->update(['from'=>$from ,'to'=>$to]);

        return response()->json([
            'status' => true,
            'data' => $shift,
        ]);
    }
}
