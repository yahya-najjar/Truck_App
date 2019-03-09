@extends('admin.layouts.app')
@section('title')
Edit Customer
@endsection
@section('bread')
<li class="breadcrumb-item "><a href="{{asset('admin/customers')}}">all customers</a></li>
<li class="breadcrumb-item active">edit customers</li>
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-body">
            <h4 class="card-title">Edit customer {{$customer->id}}</h4>
            <h6 class="card-subtitle"> </h6>
            <form class="form-material" enctype="multipart/form-data"
            action="{{action('Admin\CustomerController@update',$customer) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>First Name <span class="help"> </span></label>
                            <input type="text" value="{{$customer->first_name}}" class="form-control form-control-line"
                            name="first_name"  >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Last Name <span class="help"> </span></label>
                            <input type="text" value="{{$customer->last_name}}" class="form-control form-control-line"
                            name="last_name"  >
                        </div>
                    </div>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email <span class="help"> </span></label>
                            <input type="text" value="{{$customer->email}}" class="form-control form-control-line"
                            name="email"  >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Password <span class="help"> </span></label>
                            <input type="password" value="" class="form-control form-control-line"
                                name="password" placeholder="******" >
                        </div>
                    </div>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone <span class="help"> </span></label>
                            <input type="text" value="{{$customer->phone}}" class="form-control form-control-line"
                            name="phone"  >
                        </div>
                    </div>
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary my-2">Save</button>
                    </div>
                </div>
          </form>
        </div>
    </div>
</div>
@endsection('content')                