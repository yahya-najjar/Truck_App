@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-body">
            <h4 class="card-title">Edit Bill {{$bill->id}}</h4>
            <h6 class="card-subtitle"> </h6>
            <form class="form-material" enctype="multipart/form-data"
            action="{{action('Admin\BillController@update',$bill) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="form-group">
                <label>Cash Amount <span class="help"> </span></label>
                <input type="text" value="{{$bill->cash_amountcash_amount}}" class="form-control form-control-line"
                name="cash_amount"  >
            </div>
            <div class="form-group">
                <label> Month Count <span class="help"> </span></label>
                <textarea type="text" value="{{$bill->month_count}}" class="form-control form-control-line"
                    name="month_count"  >{{$bill->month_count}} </textarea>
                </div>
                <div class="form-group">
                    <label>Note <span class="help"> </span></label>
                    <input type="text" value="{{$bill->note}}" class="form-control form-control-line"
                    name="note"  >
                </div>
                <div class="form-group">
                    <label> Transaction id <span class="help"> </span></label>
                    <input type="text" value="{{$bill->transaction_id}}" class="form-control form-control-line"
                    name="transaction_id"  >
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

             <div class="col-md-12 ">
                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Driver_Name </label>
              <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
               @foreach($trucks as $truck)
               <option selected>Open this select menu</option>
               <option value="{{$truck->id}}">{{$truck->driver_name}}</option>
               @endforeach
           </select>
       </div>
       <button type="submit" class="btn btn-primary my-2">Save</button>

   </form>
</div>
</div>
</div>
@endsection('content')                