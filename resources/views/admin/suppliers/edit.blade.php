@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-body">
            <h4 class="card-title">Edit Supplier {{$supplier->id}}</h4>
            <h6 class="card-subtitle"> </h6>
            <form class="form-material" enctype="multipart/form-data"
            action="{{action('Admin\SupplierController@update',$supplier) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="form-group">
                <label>Name <span class="help"> </span></label>
                <input type="text" value="{{$supplier->name}}" class="form-control form-control-line"
                name="name"  >
            </div>
            <div class="form-group">
                <label> Description <span class="help"> </span></label>
                <textarea type="text" value="{{$supplier->description}}" class="form-control form-control-line"
                    name="description"  >{{$supplier->description}} </textarea>
                </div>
                <div class="form-group">
                    <label>Location <span class="help"> </span></label>
                    <input type="text" value="{{$supplier->location}}" class="form-control form-control-line"
                    name="location"  >
                </div>
                <div class="form-group">
                    <label>Phone_Number <span class="help"> </span></label>
                    <input type="text" value="{{$supplier->phone}}" class="form-control form-control-line"
                    name="phone"  >
                </div>
                <div class="form-group">
                    <label>Expier_Date <span class="help"> </span></label>
                    <input type="date" value="{{$supplier->date}}" id="mdate" class="mdate form-control form-control-line"
                    name="expier_date">
                </div>

                <button type="submit" class="btn btn-primary my-2">Save</button>

            </form>
        </div>
    </div>
</div>
@endsection('content')                