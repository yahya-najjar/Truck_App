@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-body">
            <h4 class="card-title">Edit User {{$user->id}}</h4>
            <h6 class="card-subtitle"> </h6>
            <form class="form-material" enctype="multipart/form-data"
            action="{{action('Admin\UserController@update',$user) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group">
                    <label>Name <span class="help"> </span></label>
                    <input type="text" value="{{$user->name}}" class="form-control form-control-line"
                    name="name"  >
                </div>
                <div class="form-group">
                    <label> Password <span class="help"> </span></label>
                    <textarea type="text" value="{{$user->password}}" class="form-control form-control-line"
                        name="password"  >******* 
                    </textarea>
                </div>
                <div class="form-group">
                    <label>Email <span class="help"> </span></label>
                    <input type="text" value="{{$user->email}}" class="form-control form-control-line"
                    name="email"  >
                </div>

                <div class="col-md-12 form-group">
                    <label for="roles">Role</label>
                    <select style="width: 100%;" class="select2 m-b-10 select2-multiple" multiple="true" name="roles[]"
                      multiple="multiple">
                      <optgroup label="Choose Roles for user">
                      @foreach ($roles as $role)
                      <option value="{{$role->id}}" {{ isset($user) ? ((in_array($role->id, $ids)) ? 'selected' : '') : '' }}>{{$role->display_name}}</option>
                      @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary my-2">Save</button>
          </form>
        </div>
    </div>
</div>
@endsection('content')                