@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-body">
            <h4 class="card-title">Creat New Truck</h4>
            <h6 class="card-subtitle"> </h6>
            <form class="form-material" enctype="multipart/form-data"
            action="{{action('Admin\TruckController@store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Driver_Name <span class="help"> </span></label>
                <input type="text" class="form-control form-control-line"
                name="driver_name"  >
            </div>
            <div class="form-group">
                <label> Driver_phone <span class="help"> </span></label>
                <input type="tel" class="form-control form-control-line"
                name="driver_phone"  >
            </div>

            <div class="form-group">
                <label> Company_Name <span class="help"> </span></label>
                <input type="text" class="form-control form-control-line"
                name="company_name"  > 
            </div>
            <div class="form-group">
                <label> Company_Phone <span class="help"> </span></label>
                <input type="tel" class="form-control form-control-line"
                name="company_phone"> 
            </div>

            <div class="form-group">
                <label> Plate_Number <span class="help"> </span></label>
                <input type="number" class="form-control form-control-line"
                name="plate_num"  > 
            </div>
            <div class="form-group">
                <label> Location <span class="help"> </span></label>
                <input type="text" class="form-control form-control-line"
                name="location"  > 
            </div>
            <div class="form-group">
                <label> Capacity <span class="help"> </span></label>
                <input type="number" class="form-control form-control-line"
                name="capacity"  > 
            </div>
            <div class="form-group">
                <label>  Vehicle_Model <span class="help"> </span></label>
                <input type="text" class="form-control form-control-line"
                name="model"  > 
            </div>
            <div class="form-group">
                <label> Price_Per_KM <span class="help"> </span></label>
                <input type="number" class="form-control form-control-line"
                name="price_km"  > 
            </div>
            <div class="form-group">
                <label> Price_Per_Hour <span class="help"> </span></label>
                <input type="number" class="form-control form-control-line"
                name="price_h"  > 
            </div>
            <div class="col-md-12 ">
                <div class="form-group">
                    <label>Supplier_Name </label>
                    <select class="select2 m-b-10 select2-multiple" name="supplier_id">
                       @foreach($suppliers as $supplier)
                       <option selected>Open this select menu</option>
                       <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                       @endforeach
                   </select>
               </div>
           </div>

           <button type="submit" class="btn btn-primary my-2">Save</button>

       </form>
   </div>
</div>
</div>
@endsection('content')                