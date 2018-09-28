@extends('admin.layouts.app')
@section('title')
Users
@endsection

@section('bread')
<li class="breadcrumb-item active">All Users</li>
@endsection

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">All Users </h4>
        <h6 class="card-subtitle"></h6>
        <div class="table-responsive">
          <table class="table table-striped table-bordered" style="width:100%" id="table_id">
            <thead>
              <tr>
                <th>#</th>
                <th>User name</th>
                <th>User email</th>
                <th>User role</th>
                <th>User role description</th>

                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($customers as $user)
              <tr>
                <td>{{ $user->id }}</td>

                <td>{{ strip_tags($user->name) ?? 'No Name' }}</td>

                <td>{{ $user->email }}</td>
                <td>{{ $user->roles()->first()->display_name  }}</td>
                <td>{{ $user->roles()->first()->description   }}</td>


                

                <td class="text-nowrap">


                  <!-- Delete -->
                  <a class="btn default btn-outline " data-delete href="javascript:void(0);"><i
                    class="fa fa-trash text-danger m-r-10"></i></a>

                    <form action="{{ action('Admin\UserController@destroy', $user) }}"
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