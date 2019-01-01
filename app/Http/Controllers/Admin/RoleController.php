<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
            'description' => 'required',
        ]);

        // $role = Role::create($request->except(['permissions']));
        // return $request->all();
        $role = $request->except(['permissions','_token']);
        $role = Role::create($role);

        $permissions = $request['permissions'];

        foreach ($permissions as $key => $value) {
            $role->attachPermission($value);
        }
        $role->save();

        return back()->with('success','Role Created Succsessfully.');
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
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $ids = $role->perms()->pluck('permission_id')->toArray();
        // return $role->perms;
        return view('admin.roles.create',compact('role','permissions','ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Role $role)
    {
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
            'description' => 'required',
        ]);

        if(request('permissions')){

            $role->update($request->except(['permissions']));
            $role->perms()->detach();
            $permissions = $request['permissions'];
            $role->perms()->attach($permissions);
        }

        $role->save();

        return back()->with('success' , 'Role Updated!');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
