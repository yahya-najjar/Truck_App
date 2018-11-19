@extends('admin.layouts.app')
@section('title')
users
@endsection

@section('content')

@if(!count($users))
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<h1 class="text-danger">There is no Items Here Yet! <i class="mdi mdi-emoticon-neutral"></i>
				</h1><br>
				<!-- <a href="{{ action('Admin\UserController@create', 'users') }}"><h4><i class="mdi mdi-plus"></i> Add
				</h4></a> -->
			</div>
		</div>
	</div>
</div>
@else
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">All users </h4>
				<button class=" btn btn-success btn-rounded col-md-3" data-toggle="modal"
					data-target="#addAdminModal">
				<i class="fa fa-plus-circle m-r-5"></i>Add User</button><br><br>
				<h6 class="card-subtitle"></h6>
				<div class="table-responsive">
					<table class="table table-striped table-bordered" style="width:100%" id="table_id">
						<thead>
							<tr>
								<th>#</th>
								<th>User name</th>
								<th>User role</th>
								<th>User role description</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
							<tr>
								<td>{{ $user->id }}</td>

								<td>{{ strip_tags($user->name) ?? 'No Title' }}</td>

								<td>{{ $user->roles()->first()? $user->roles()->first()->display_name :'' }}</td>
								<td>{{$user->roles()->first()? $user->roles()->first()->description :''  }}</td>

								<td class="text-nowrap">
									<a class="btn default btn-outline" title="Edit User" data-placement="top" href="{{ action('Admin\UserController@edit', $user) }} "><i style="color: #1e88e5;" class="fas fa-user-edit" data-toggle="tooltip" data-placement="left" title="Edit User"></i></a>

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
				</div>
			</div>
		</div>
	</div>
</div>
@endif

{{--Add User Modal--}}
<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="myLargeModalLabel">Add new User</h4>
			<button type="button" class="close" data-dismiss="modal"
			aria-hidden="true">×
		</button>
	</div>
	<form action="{{action("Admin\UserController@store")}}" method="post">
		<div class="modal-body">
			<div class="modal-body">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="name">name</label>
					<input type="text" name="name" class="form-control">
				</div>
				<div class="form-group">
					<label for="email">email</label>
					<input type="email" name="email" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">password</label>
					<input type="password" name="password" class="form-control">
				</div>
				<div class="col-md-12 form-group">
					<label for="roles">Role</label>
					<select style="width: 100%;" class="select2 m-b-10 select2-multiple" multiple="true" name="roles[]"
					multiple="multiple">
					@foreach ($roles as $role)
					<option value="{{$role->id}}">{{$role->display_name}}</option>
					@endforeach
				</select></div>
			</div>
			<div class="modal-footer">
				<button type="submit"
				class="btn btn-primary waves-effect waves-light">
				Save
			</button>
			<button type="button"
			class="btn btn-danger waves-effect text-left"
			data-dismiss="modal">Cancel
		</button>
	</div>
</div>
</form>

</div>
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready( function () {
		$('#table_id').DataTable();


		$('#my_button').click(function(){
			console.log("button pressed");

			$.ajax({
				url: "/admin/like/users",
				type: "get",
				data: {},
				success:function(data){
					console.log(data);
				}
			})
		});
	} );



</script>
@endsection