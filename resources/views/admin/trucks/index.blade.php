@extends('admin.layouts.app')
@section('title')
Trucks
@endsection

@section('content')

@if(!count($trucks))
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<h1 class="">There is no Items Here Yet! <i class="far fa-grin-beam-sweat"></i>
				</h1><br>
				<button class=" btn btn-success btn-rounded col-md-3" data-toggle="modal"
				data-target="#addAdminModal">
				<i class="fa fa-plus-circle m-r-5"></i>Add Truck</button><br><br>
			</div>
		</div>
	</div>
</div>
@else
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
						<option {{$from_status== 3?'selected':''}} value="3">All</option>
					</select>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="table_id">
						<thead>
							<tr>
								<th>#</th>
								<th>Driver Name</th>
								<th>Supplier</th>
								<th>Expire Date</th>
								<th>Rating</th>
								<th>status</th>
								<th>last update</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($trucks as $truck)
							<tr>
								<td>{{ $truck->id }}</td>

								<td>{{ strip_tags($truck->driver_name) ?? 'No Title' }}</td>
								<td>{{ isset($truck->supplier)?$truck->supplier->name:'Private Truck' }}</td>
								<td>
									@if(!isset($truck->supplier))
									<span class="label label-{{$truck->IsExpired ?'danger':'info'}}">{{ $truck->expire_date }}</span>
									@endif
								</td>
								<td>{{ $truck->rating}}</td>
								<td>{{ $truck->status }}</td>

								<td>{{ $truck->updated_at }}</td>


								<td class="text-nowrap">
									<a class="btn default btn-outline" title="Show More Detailes" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@show', $truck) }} "> <i style="color:#00edd5;" class="fas fa-eye m-r-10"></i></a>

									<a class="btn default btn-outline" title="Edit Truck" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@edit', $truck) }} "><i class="fas fa-edit m-r-10" style="color: #1e88e5;"> </i></a>

									<a class="btn default btn-outline" title="Show Truck Orders" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@orders', $truck) }} "> <i style="color:#000;" class="fas fa-truck-monster m-r-10"></i></a>


									<a class="btn default btn-outline" title="Show Truck Location" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@location',$truck) }} "> <i style="color:#000;" class="fas fa-map-marked-alt m-r-10"></i></a>

									@if(!isset($truck->supplier))
									<a class="btn default btn-outline" title="Renew Account"role="button" data-toggle="modal"
									data-target="#renewModal_{{$truck->id}}"><i style="color: #16bf1e;" class="fas fa-dollar-sign" data-toggle="tooltip" data-placement="left" title="Renew Account"></i></a>
									@endif

									<a class="btn default btn-outline " data-delete href="javascript:void(0);"><i
										class="fa fa-trash text-danger" data-toggle="tooltip" data-placement="top" title="Delete Truck"></i></a>

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
@endif
{{--Add Truck Modal--}}
<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="myLargeModalLabel">Add new Truck</h4>
			<button type="button" class="close" data-dismiss="modal"
			aria-hidden="true">×
		</button>
	</div>
	<form action="{{action("Admin\TruckController@store")}}" method="post">
		<div class="modal-body">
			<div class="modal-body">
				{{ csrf_field() }}
				<div class="form-group">
					<label>Driver Name <span class="help"> </span></label>
					<input type="text" class="form-control form-control-line"
					name="driver_name"  >
				</div>
				<div class="form-group">
					<label> Driver phone <span class="help"> </span></label>
					<input type="tel" class="form-control form-control-line"
					name="driver_phone"  >
				</div>

				<div class="form-group">
					<label> Company Phone <span class="help"> </span></label>
					<input type="tel" class="form-control form-control-line"
					name="company_phone" >
				</div>
				<div class="form-group">
					<label> Location <span class="help"> </span></label>
					<input type="text" class="form-control form-control-line"
					name="location"  >
				</div> 

				<div class="form-group">
					<label> Plate Number <span class="help"> </span></label>
					<input type="number" class="form-control form-control-line"
					name="plate_num"  >
				</div>
				<div class="form-group">
					<label> Capacity <span class="help"> </span></label>
					<input type="number" class="form-control form-control-line"
					name="capacity"  >
				</div>
				<div class="form-group">
					<label>  Vehicle Model <span class="help"> </span></label>
					<input type="text" class="form-control form-control-line"
					name="model"  >
				</div>
				<div class="form-group">
					<label> Price Per KM <span class="help"> </span></label>
					<input type="number" class="form-control form-control-line"
					name="price_km"  >
				</div>
				<div class="form-group">
					<label> Price Per Hour <span class="help"> </span></label>
					<input type="number" class="form-control form-control-line"
					name="price_h"  >
				</div>

				<div class="col-md-12 form-group">
					<label>Supplier Name </label>
					<select style="width: 100%;" class="select2 m-b-10 select2-multiple" name="supplier_id">
						<option selected>Open this select menu</option>

						<option  value="">none</option>
						@foreach($suppliers as $supplier)
						<option value="{{$supplier->id}}">{{$supplier->name}}</option>
						@endforeach
					</select>
				</div>
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

{{--Add Bill Modal--}}
@foreach($trucks as $truck)
@if(!isset($truck->supplier))
<div class="modal fade" id="renewModal_{{$truck->id}}" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel_{{$truck->id}}" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myLargeModalLabel_{{$truck->id}}">Renew {{$truck->driver_name}} account</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X
				</button>
			</div>
			<form action="{{action("Admin\BillController@store")}}" method="post">
				<div class="modal-body">
					{{ csrf_field() }}
					<div class="form-group">
						<label>Cash Amount <span class="help"> </span></label>
						<input type="number" class="form-control form-control-line"
						name="cash_amount"  >
					</div>
					<div class="form-group">
						<label> Month Count <span class="help"> </span></label>
						<input type="number" class="form-control form-control-line"
						name="month_count"  >
					</div>

					<div class="form-group">
						<label> Note <span class="help"> </span></label>
						<textarea type="text" class="form-control form-control-line"
						name="note" ></textarea>
					</div>

					<div class="col-md-12 form-group">
						<input type="hidden" name="truck_id" value="{{$truck->id}}">
					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary waves-effect waves-light">
							Save
						</button>
						<button type="button" class="btn btn-danger waves-effect text-left"data-dismiss="modal">
							Cancel
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endif
@endforeach

@endsection
@section('script')
<script type="text/javascript">var url = "{{url('')}}";</script> 
<script type="text/javascript">
	$(document).ready( function () {
		$('#table_id').DataTable();
	} );

	$('[name=status]').change(function () {
		location.href = url + '/admin/allTrucks/' + $(this).val();
	});

</script>
@endsection