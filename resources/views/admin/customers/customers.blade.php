@extends('admin.layouts.app')
@section('title')
Customers
@endsection

@section('bread')
<li class="breadcrumb-item active">Customers</li>
@endsection

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">All Customers </h4>
        <h6 class="card-subtitle"></h6>
        <div class="table-responsive">
          <table class="table table-striped table-bordered" style="width:100%" id="customers_table">
            <thead>
              <tr>
                <th>#</th>
                <th>Customer name</th>
                <th>User email</th>
                <th>phone</th>
                <th>Payment type</th>
                <th>Registeration Completed</th>
                <th>Registeration Date</th>

                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
          <!-- {{ $customers->links("pagination::bootstrap-4") }} -->

        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript" charset="utf8" src="{{asset('/assets/admin/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript">var url = "{{url('')}}";</script>
<script type="text/javascript">
  $(document).ready( function () {
    var table =  $('#customers_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":
        {
            "url": url + '/admin/all_customers',
            "dataType": "json",
            "type": "POST", 
            "data": function(d){
               d._token = "{{ csrf_token() }}";
           }
       },
       "columns": [
       {"data": "id"},
       {"data": "name"},
       {"data": "email"},
       {"data": "phone"},
       {"data": "payment_type"},
       {"data": "registeration"},
       {"data": "created_at"},
       {"data": "actions"},
       ],

       "data":{
        "_token": "{{ csrf_token() }}",
    }

});
  } );

</script>
@endsection