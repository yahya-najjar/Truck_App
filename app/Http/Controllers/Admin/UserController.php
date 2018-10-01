<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view ('admin.users.index',compact('users','roles'));
    }

    public function admins(){

        $admins =  User::withRole('admin')->paginate(3);
        $roles = Role::all();
        return view('admin.users.admins',compact('admins','roles'));
    }

    public function customers(){
        $customers = User::withRole('customer')->paginate(3);
        return view('admin.users.customers',compact('customers'));
    }

    public function suppliers(){
        $suppliers = User::withRole('supplier')->paginate(3);
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
        $user->delete();
        return back()->with('danger','Item Deleted');
    }
}
