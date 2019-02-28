@extends('admin.layouts.app')
@section('title')
Customers
@endsection

@section('bread')
<li class="breadcrumb-item active">All Customers</li>
@endsection

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">All Customers </h4>
        <h6 class="card-subtitle"></h6>
        <div class="table-responsive">
          <table class="table table-striped table-bordered" style="width:100%" id="table_id">
            <thead>
              <tr>
                <th>#</th>
                <th>Customer name</th>
                <th>User email</th>
                <th>phone</th>
                <th>Payment type</th>
                <th>Registeration Completed</th>

                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($customers as $customer)
              <tr>
                <td>{{ $customer->id }}</td>

                <td>{{ $customer->first_name ." ".$customer->last_name ?? 'No Name' }}</td>

                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone  }}</td>
                <td>{{ $customer->payment_type?"cash":"Credit" }}</td>
                <td>{{ $customer->registeration_completed?"Yes":"No" }}</td>


                

                <td class="text-nowrap">
                  
                  <a class="btn default btn-outline" title="Edit User" data-placement="top" href="{{ action('Admin\CustomerController@edit', $customer) }} "><i style="color: #1e88e5;" class="fas fa-user-edit" data-toggle="tooltip" data-placement="left" title="Edit User"></i></a>

                  <!-- Delete -->
                  <a class="btn default btn-outline " data-delete href="javascript:void(0);"><i
                    class="fas fa-user-{{$customer->active==1?'times':'check'}} text-{{$customer->active==1?'danger':'success'}} m-r-10" data-toggle="tooltip" data-placement="top" title="{{$customer->active==1?'Deactivate':'Activate'}} User"></i></a>

                    <form action="{{ action('Admin\CustomerController@destroy', $customer) }}"
                    method="post" id="delete">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                  </form>


                </td>

                
              </tr>
              @endforeach

            </tbody>
          </table>
          {{ $customers->links("pagination::bootstrap-4") }}

        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
  $(document).ready( function () {
    $('#table_id').DataTable();
  } );

</script>
@endsection