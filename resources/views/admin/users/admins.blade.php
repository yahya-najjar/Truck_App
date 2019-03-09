@extends('admin.layouts.app')
@section('title')
Users
@endsection

@section('bread')
<li class="breadcrumb-item active">Web App Users</li>
@endsection

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Web App Users</h4>
     <h6 class="card-subtitle">you can't delete last user</h6>
     <div class="table-responsive">
      <table class="table table-striped table-bordered" style="width:100%" id="table_id">
        <thead>
          <tr>
            <th>#</th>
            <th>User name</th>
            <th>email</th>
            <th>role</th>
            <th>role description</th>

            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($admins as $user)
          <tr>
            <td>{{ $user->id }}</td>

            <td>{{ strip_tags($user->name) ?? 'No Name' }}</td>

            <td>{{ $user->email }}</td>
            <td>{{ $user->roles()->first()->display_name  }}</td>
            <td>{{ $user->roles()->first()->description   }}</td>




            <td class="text-nowrap">

              <a class="btn default btn-outline" title="Edit User" data-placement="top" href="{{ action('Admin\UserController@edit', $user) }} "><i style="color: #1e88e5;" class="fas fa-user-edit" data-toggle="tooltip" data-placement="left" title="Edit User"></i></a>

              <!-- Delete -->
              <a class="btn default btn-outline " data-delete href="javascript:void(0);"><i
                    class="fas fa-user-{{$user->is_verified==1?'times':'check'}} text-{{$user->is_verified==1?'danger':'success'}} m-r-10" data-toggle="tooltip" data-placement="top" title="{{$user->is_verified==1?'Deactivate':'Activate'}} User"></i></a>

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
      {{ $admins->links("pagination::bootstrap-4") }}

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