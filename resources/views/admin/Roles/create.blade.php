@extends('admin.layouts.app')
@section('title')
New Role
@endsection

@section('bread')
<li class="breadcrumb-item"><a href="{{ action('Admin\RoleController@index', 'roles') }}">All Roles</a></li>
<li class="breadcrumb-item active">New Role</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">New Role</h4>

                <form class="form-material" enctype="multipart/form-data"
                action="{{ isset($role) ? action('Admin\RoleController@update', $role) : action('Admin\RoleController@store') }}"
                method="post">
                {{ csrf_field() }}


                @if(isset($role))
                {{ method_field('PATCH') }}
                @endif

                <div class="row p-t-20">

                    <div class="col-md-12">
                        <h3>
                            <span class="label label-info">1</span>
                            Name *
                        </h3>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Name </label>
                            <input type="text" class="form-control form-control-line"
                            name="name"
                            placeholder="role name"
                            value="{{ isset($role) ? $role->name: '' }} "/>
                        </div>
                    </div>

                    <hr>

                    <div class="col-md-12">
                        <h3>
                            <span class="label label-info">2</span>
                            Display name *
                        </h3>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="display_name">Display name</label>
                            <input type="text" class="form-control form-control-line"
                            name="display_name"
                            placeholder="display name"
                            value="{{ isset($role) ? $role->display_name: '' }} "/>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h3>
                            <span class="label label-info">3</span>
                            Description *
                        </h3>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control form-control-line"
                            name="description"
                            placeholder="description"
                            value="{{ isset($role) ? $role->description: '' }} "/>
                        </div>
                    </div>

                    
                    
                    <div class="col-md-12 form-group">

                        @if(!count($permissions))
                        <p>please add permissions first</p>
                        @else
                        <label for="permissions" >Permissions</label><br>
                        @endif
                        <select class="select2 m-b-10 select2-multiple" style="width: 100%"  data-placeholder="Choose" multiple="true" name="permissions[]">

                            <!-- <select  multiple data-role="tagsinput" name="permissions[]" > -->
                                <optgroup label="Choose Plan permissions">
                                    @foreach($permissions as $permission)
                                    <option value="{{$permission->id}}" {{ isset($role) ? ((in_array($permission->id, $ids)) ? 'selected' : '') : '' }}> {{$permission->name}} </option>
                                    @endforeach
                                </optgroup>

                            </select>
                        </div>  





                        <div class="col-md-12">
                            <br>
                            <div class="form-group">
                                <button class="btn btn-success btn-rounded" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
