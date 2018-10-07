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
				<h6 class="card-subtitle"></h6>
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="table_id">
						<thead>
							<tr>
								<th>#</th>
								<th>Driver Name</th>
								<th>Capacity</th>
								<th>Rating</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($trucks as $truck)
							<tr>
								<td>{{ $truck->id }}</td>

								<td>{{ strip_tags($truck->driver_name) ?? 'No Title' }}</td>
								<td>{{ $truck->capacity }}</td>
								<td>{{ $truck->rating}}</td>


								<td class="text-nowrap">
									<a class="btn default btn-outline" title="Show More Detailes" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@show', $truck) }} "> <i style="color:#00edd5;" class="fas fa-eye m-r-10"></i></a>

									<a class="btn default btn-outline" title="Edit Truck" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@edit', $truck) }} "><i class="fas fa-edit m-r-10" style="color: #1e88e5;"> </i></a>

									<a class="btn default btn-outline" title="Show Truck Orders" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@orders', $truck) }} "> <i style="color:#000;" class="fas fa-truck-monster m-r-10"></i></a>
								

									<a class="btn default btn-outline" title="Show Truck Orders" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@location') }} "> <i style="color:#000;" class="fas fa-map-marked-alt m-r-10"></i></a>

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

				<div class="form-group">
					<label> Company Phone <span class="help"> </span></label>
					<input type="tel" class="form-control form-control-line"
					name="company_phone"  >
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

@endsection
@section('script')
<script type="text/javascript">
	$(document).ready( function () {
		$('#table_id').DataTable();
	} );

</script>
@endsection