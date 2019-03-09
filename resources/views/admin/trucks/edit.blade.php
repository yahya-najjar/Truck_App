@extends('admin.layouts.app')
@section('title')
Edit Truck
@endsection
@section('bread')
<li class="breadcrumb-item "><a href="{{asset('admin/trucks')}}">all trucks</a></li>
<li class="breadcrumb-item active">edit truck</li>
@endsection
@section('style')
<link href="{{asset('/assets/admin/plugins/Magnific-Popup-master/dist/magnific-popup.css')}}" rel="stylesheet">
@endsection
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
            <div class="row col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company Phone <span class="help"> </span></label>
                        <input type="text" value="{{$truck->company_phone}}" class="form-control form-control-line"
                        name="company_phone"  >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Plate Number <span class="help"> </span></label>
                        <input type="text" value="{{$truck->plate_num}}" class="form-control form-control-line"
                        name="plate_num"  >
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Capacity <span class="help"> </span></label>
                        <input type="text" value="{{$truck->capacity}}" class="form-control form-control-line"
                        name="capacity"  >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Vehicle Model <span class="help"> </span></label>
                        <input type="text" value="{{$truck->model}}" class="form-control form-control-line"
                        name="model"  >
                    </div>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Price Per KM <span class="help"> </span></label>
                        <input type="text" value="{{$truck->price_km}}" class="form-control form-control-line"
                        name="price_km"  >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Price Per Hour <span class="help"> </span></label>
                        <input type="text" value="{{$truck->price_h}}" class="form-control form-control-line"
                        name="price_h"  >
                    </div>        
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                        <label>Description <span class="help"> </span></label>
                        <textarea rows="4" name="desc" value="{{$truck->desc}}" class="form-control form-control-line">{{$truck->desc}}</textarea>
                </div>
            </div>
            <div class=" row col-md-12 ">
                <div class="col-md-6">
                     <label class="my-1 mr-2" for="inlineFormCustomSelectPref">
                        Supplier Name 
                     </label>
                     <select  style="width: 100%;" class="select2 m-b-10 select2-multiple" id="inlineFormCustomSelectPref">
                        @foreach($suppliers as $supplier)
                            <option value="{{$supplier->id}}" {{$supplier->id == $truck->supplier->id ?'seleced' : ''}} >
                               {{$supplier->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row col-sm-12">
                 <div class="col-sm-6">
                      <div class="form-group">
                           <label>Image</label>
                           <input type="file" name="image" value="{{$truck->image}}" class="dropify">
                      </div>
                 </div>
                 <div class="col-sm-6">
                           <label>Old Image</label>

                      <div class="card " >
                        <div class="card-body" style="margin-top: -20px;">
                          <div class="d-flex no-block">
                            <div id="image-popups">
                                <a href="{{ $truck->image }}?w=400&h=200" data-effect="mfp-zoom-in"><img src="{{ $truck->image }}?w=400&h=200" class="img-responsive" />
                                  <br/>
                                </a>
                            </div>
                          </div>
                        </div>
                      </div>
                 </div>
            </div>
            <br>
            <div class="row col-md-12">
                <div class="offset-2 col-md-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary my-2">Save</button>                
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
</div>
@endsection('content')
@section('script')
<script src="{{asset('/assets/admin/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('/assets/admin/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>
@endsection