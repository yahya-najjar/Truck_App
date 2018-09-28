@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-body">
            <h4 class="card-title">Edit Truck Information {{$truck->id}}</h4>
            <h6 class="card-subtitle"> </h6>
            <form class="form-material" enctype="multipart/form-data"
            action="{{action('Admin\TruckController@update',$truck) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="form-group">
                <label>Driver_Name <span class="help"> </span></label>
                <input type="text" value="{{$truck->driver_name}}" class="form-control form-control-line"
                name="driver_name"  >
            </div>
            <div class="form-group">
                <label> Driver_phone <span class="help"> </span></label>
                <textarea type="text" value="{{$truck->driver_name}}" class="form-control form-control-line"
                    name="driver_name"  >{{$truck->driver_name}} </textarea>
                </div>
                <div class="form-group">
                    <label>Company_Name <span class="help"> </span></label>
                    <input type="text" value="{{$truck->company_name}}" class="form-control form-control-line"
                    name="company_name"  >
                </div>
                <div class="form-group">
                    <label>Company_Phone <span class="help"> </span></label>
                    <input type="text" value="{{$truck->comany_phone}}" class="form-control form-control-line"
                    name="comany_phone"  >
                </div>
                <div class="form-group">
                    <label>Plate_Number <span class="help"> </span></label>
                    <input type="text" value="{{$truck->plat_num}}" class="form-control form-control-line"
                    name="plat_num"  >
                </div>
                <div class="form-group">
                    <label>Location <span class="help"> </span></label>
                    <input type="text" value="{{$truck->location}}" class="form-control form-control-line"
                    name="location"  >
                </div>
                <div class="form-group">
                    <label>Capacity <span class="help"> </span></label>
                    <input type="text" value="{{$truck->capacity}}" class="form-control form-control-line"
                    name="capacity"  >
                </div>
                <div class="form-group">
                    <label>Vehicle_Model <span class="help"> </span></label>
                    <input type="text" value="{{$truck->model}}" class="form-control form-control-line"
                    name="model"  >
                </div>
                <div class="form-group">
                    <label>Price_Per_KM <span class="help"> </span></label>
                    <input type="text" value="{{$truck->price_km}}" class="form-control form-control-line"
                    name="price_km"  >
                </div>
                <div class="form-group">
                    <label>Price_Per_Hour <span class="help"> </span></label>
                    <input type="text" value="{{$truck->price_h}}" class="form-control form-control-line"
                    name="price_h"  >
                </div>
                <div class="col-md-12 ">
                  <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Supplier_Name </label>
                  <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                     @foreach($suppliers as $supplier)
                     <option selected>Open this select menu</option>
                     <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                     @endforeach
                 </select>
             </div>

             <button type="submit" class="btn btn-primary my-2">Save</button>

         </form>
     </div>
 </div>
</div>
@endsection('content')                