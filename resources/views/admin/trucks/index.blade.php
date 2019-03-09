@extends('admin.layouts.app')
@section('title')
All Trucks
@endsection
@section('bread')
    <li class="breadcrumb-item active">all trucks</li>
@endsection
@section('style')
<style type="text/css">
.modal-dialog{
	max-width: 1000px;
}
@media (min-width: 992px)
.modal-lg {
	max-width: 900px;
}
@media (min-width: 576px)
.modal-dialog {
    max-width: 600px;
    margin: 30px auto;
}
.dataTable > thead > tr > th[class*="sort"]:after{
    content: "" !important;
}
</style>
<link href="{{asset('/assets/admin/plugins/footable/css/footable.core.css')}}" rel="stylesheet">
<link href="{{asset('css/pages/footable-page.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">All trucks </h4>
				
				<button class=" btn btn-success btn-rounded col-md-3" data-toggle="modal"
				data-target="#addAdminModal">
				<i class="fa fa-plus-circle m-r-5"></i>Add Truck</button><br>
				<h6 class="card-subtitle">

				</h6>
				<div class="form-group">
					<label>Status</label>
					<select name="status" class="form-control">
						<option {{$from_status==1?'selected':''}} value="1">Online</option>
						<option {{$from_status==2?'selected':''}} value="2">Busy</option>
						<option {{$from_status== 0?'selected':''}} value="0">Offline</option>
						<option {{$from_status== 3?'selected':''}} value="3">OnRequest</option>
						<option {{$from_status== 4?'selected':''}} value="4">All</option>
					</select>
				</div>
				<div class="table-responsive">
					<table id="demo-foo-addrow" class="table m-t-30 toggle-circle table-hover contact-list" data-page-size="10" >
						<thead>
							<tr>
								<!-- <th>#</th> -->
								<th data-toggle="true">Current Driver</th>
								<th>Supplier</th>
								<th>Account ED</th>
								<th>Licence ED</th>
								<th>Rating</th>
								<th>status</th>
								<th>last update</th>
								<th data-hide="all">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($trucks as $truck)
							<tr>
								<!-- <td>{{ $truck->id }}</td> -->

								<td>{{ strip_tags($truck->driver_name) ?? 'No Title' }}</td>
								<td>{{ isset($truck->supplier)?$truck->supplier->name:'Private Truck' }}</td>
								<td>
									<span class="label label-rounded label-{{$truck->IsExpired ?'danger':'info'}}">{{ $truck->expire_date }}</span>
								</td>
								<td>
									<span class="label label-rounded label-{{$truck->LicenceIsExpired ?'danger':'info'}}">{{ $truck->licence_date }}</span>
								</td>
								<td>{{ $truck->rating}}</td>
								<td>{{ $truck->StatusName }}</td>

								<td>{{ $truck->updated_at }}</td>


								<td class="text-nowrap">
									<a class="btn default btn-outline" title="Set Truck Shifts" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@shifts', $truck) }} "> <i style="margin-right: -15px; margin-left:-15px; color:#9e1e59;" class="fas fa-business-time m-r-1"></i></a>

									<a class="btn default btn-outline" title="Show More Detailes" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@show', $truck) }} "> <i style="margin-right: -15px; margin-left:-15px; color:#00edd5;" class="fas fa-eye m-r-1"></i></a>

									<a class="btn default btn-outline" title="Edit Truck" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@edit', $truck) }} "><i class="fas fa-edit m-r-10" style="margin-right: -15px; margin-left:-15px; color: #1e88e5;"> </i></a>

									<a class="btn default btn-outline" title="Show Truck Orders" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@orders', $truck) }} "> <i style="margin-right: -15px; margin-left:-15px; color:#000;" class="fas fa-truck-monster m-r-10"></i></a>


									<a class="btn default btn-outline" title="Show Truck Location" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@location',$truck) }} "> <i style="margin-right: -15px; margin-left:-15px; color:#000;" class="fas fa-map-marked-alt m-r-10"></i></a>

									
									<a class="btn default btn-outline" title="Renew Account"role="button" data-toggle="modal"
									data-target="#renewModal_{{$truck->id}}"><i style="margin-right: -15px; margin-left:-15px; color: #16bf1e;" class="fas fa-dollar-sign" data-toggle="tooltip" data-placement="left" title="Renew Account"></i></a>
									

									<a class="btn default btn-outline " data-delete href="javascript:void(0);"><i
										class="fa fa-trash text-danger" data-toggle="tooltip" data-placement="top" title="Delete Truck" style="margin-right: -15px; margin-left:-15px;"></i></a>

										<form action="{{ action('Admin\TruckController@destroy', $truck) }}"
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
@include('admin.modals.create_truck_modal')
@include('admin.modals.create_bill_modal')

@endsection
@section('script')
@include('admin.layouts.date_pickers')
<script type="text/javascript" charset="utf8" src="{{asset('/assets/admin/js/jquery.dataTables.js')}}"></script>

<script type="text/javascript">var url = "{{url('')}}";</script> 
<script type="text/javascript">
	$(document).ready( function () {
		$('#demo-foo-addrow').DataTable();
	} );

	$('[name=status]').change(function () {
		location.href = url + '/admin/allTrucks/' + $(this).val();
	});

</script>
<!-- Footable -->
<script src="{{asset('/assets/admin/plugins/footable/js/footable.all.min.js')}}"></script>
<script src="{{asset('/assets/plugins/bootstrap-select/bootstrap-select.min.js')}}" type="text/javascript"></script>
<!--FooTable init-->
<script src="{{asset('js/footable-init.js')}}"></script>
@endsection