@extends('admin.layouts.app')
@section('title')
Suppliers (Users)
@endsection

@section('bread')
<li class="breadcrumb-item active">All Suppliers(Users)</li>
@endsection

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">All Suppliers(Users) </h4>
        <h6 class="card-subtitle"></h6>
        <div class="table-responsive">
          <table class="table table-striped table-bordered" style="width:100%" id="table_id">
            <thead>
              <tr>
                <th>#</th>
                <th>Supplier name</th>
                <th>email</th>
                <th>role</th>
                <th>role description</th>

                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($suppliers as $supplier)
              <tr>
                <td>{{ $supplier->id }}</td>

                <td>{{ strip_tags($supplier->name) ?? 'No Name' }}</td>

                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->roles()->first()->display_name  }}</td>
                <td>{{ $supplier->roles()->first()->description   }}</td>


                

                <td class="text-nowrap">

                  <a class="btn default btn-outline" title="Edit User" data-placement="top" href="{{ action('Admin\UserController@edit', $supplier) }} "><i style="color: #1e88e5;" class="fas fa-user-edit" data-toggle="tooltip" data-placement="left" title="Edit User"></i></a>

                  <!-- Delete -->
                  <a class="btn default btn-outline " data-delete href="javascript:void(0);"><i
                    class="fas fa-user-times text-danger m-r-10" data-toggle="tooltip" data-placement="top" title="Delete User"></i></a>

                    <form action="{{ action('Admin\UserController@destroy', $supplier) }}"
                    method="post" id="delete">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                  </form>


                </td>

                
              </tr>
              @endforeach

            </tbody>
          </table>
          {{ $suppliers->links("pagination::bootstrap-4") }}

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