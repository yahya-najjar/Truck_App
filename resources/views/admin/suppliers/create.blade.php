@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-body">
            <h4 class="card-title">Creat New Supplier</h4>
            <h6 class="card-subtitle"> </h6>
            <form class="form-material" enctype="multipart/form-data"
            action="{{action('Admin\SupplierController@store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Name <span class="help"> </span></label>
                <input type="text" class="form-control form-control-line"
                name="name"  >
            </div>
            <div class="form-group">
                <label> Location <span class="help"> </span></label>
                <textarea type="text" class="form-control form-control-line"
                name="location"  > </textarea>
            </div>
            <div class="form-group">
                <label> Description <span class="help"> </span></label>
                <textarea type="text" class="form-control form-control-line"
                name="description"  > </textarea>
            </div>

            <div class="form-group">
                <label> Phone_Number <span class="help"> </span></label>
                <textarea type="text" class="form-control form-control-line"
                name="phone"  > </textarea>
            </div>
            <div class="form-group">
                <label> Expier_Date <span class="help"> </span></label>
                <input type="date" id="mdate" class="mdate form-control form-control-line"
                name="expire_date">
            </div>

        <button type="submit" class="btn btn-primary my-2">Save</button>

    </form>
</div>
</div>
</div>
@endsection('content')                