@extends('admin.layouts.app')
@section('title')
Roles
@endsection

@section('bread')
<li class="breadcrumb-item active">All Roles</li>
@endsection

@section('content')

@if(!count($roles))
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h1 class="text-danger">There is no Items Here Yet! <i class="mdi mdi-emoticon-neutral"></i>
        </h1><br>
        <a href="{{ action('Admin\RoleController@create', 'roles') }}"><h4><i class="mdi mdi-plus"></i> Add
        </h4></a>
      </div>
    </div>
  </div>
</div>
@else
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">All Roles </h4>
        <h6 class="card-subtitle">you can edit question data from translations</h6>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Role name</th>
                <th>Role display name</th>
                <th>Role description</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($roles as $role)
              <tr>
                <td>{{ $role->id }}</td>

                <td>{{ strip_tags($role->name) ?? 'No Title' }}</td>

                <td>{{ $role->display_name}}</td>
                <td>{{ $role->description}}</td>                

                <td class="text-nowrap">
                @if($role->name != 'admin')
                  <a href="{{ action('Admin\RoleController@edit', $role) }}"
                  data-toggle="tooltip"
                  data-original-title="Edit"> <i
                  class="fa fa-pencil text-inverse m-r-10"></i> </a>

                  <!-- Delete -->
                  <a class="btn default btn-outline " data-delete href="javascript:void(0);"><i
                    class="fa fa-trash text-danger m-r-10"></i></a>

                    <form action="{{ action('Admin\RoleController@destroy', $role) }}"
                    method="post" id="delete">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                  </form>

                  @endif

                </td>

                
             </tr>
             @endforeach

           </tbody>
         </table>

       </div>
     </div>
   </div>
 </div>
</div>
@endif

@endsection