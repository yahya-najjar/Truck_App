@extends('admin.layouts.app')
@section('title')
Bills
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
				<i class="fa fa-plus-circle m-r-5"></i>Add Bill</button><br><br>
			</div>
		</div>
	</div>
</div>
@else
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">All bills </h4>
				
				<button class=" btn btn-success btn-rounded col-md-3" data-toggle="modal"
				data-target="#addAdminModal">
				<i class="fa fa-plus-circle m-r-5"></i>Add Bill</button><br>
				<h6 class="card-subtitle"></h6>
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="table_id">
						<thead>
							<tr>
								<th>#</th>
								<th>Cash amount</th>
								<th>Month count</th>
								<th>Supplier name</th>
								<th>Driver name</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($bills as $bill)
							<tr>
								<td>{{ $bill->id }}</td>
								<td>{{ $bill->cash_amount }}</td>
								<td>{{ $bill->month_count }}</td>
								<td>{{ $bill->$supplier->name }}</td>
								<td>{{ $bill->$truck->driver_name }}</td>


								<td class="text-nowrap">
									<a class="btn default btn-outline" title="Show More Detailes" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\BillController@show', $bill) }} "> <i style="color:#00edd5;" class="fas fa-eye m-r-10"></i></a>

									<a class="btn default btn-outline" title="Edit Truck" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\BillController@edit', $bill) }} "><i class="fas fa-edit m-r-10" style="color: #1e88e5;"> </i></a>
									

									<a class="btn default btn-outline " data-delete href="javascript:void(0);"><i
										class="fa fa-trash text-danger m-r-10" data-toggle="tooltip" data-placement="top" title="Delete Truck"></i></a>

										<form action="{{ action('Admin\BillController@destroy', $truck) }}"
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
{{--Add Bill Modal--}}
<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="myLargeModalLabel">Add new Bill</h4>
			<button type="button" class="close" data-dismiss="modal"
			aria-hidden="true">×
		</button>
	</div>
	<form action="{{action("Admin\BillController@store")}}" method="post">
		<div class="modal-body">
			<div class="modal-body">
				{{ csrf_field() }}
				<div class="form-group">
					<label>Cash Amount <span class="help"> </span></label>
					<input type="text" class="form-control form-control-line"
					name="cash_amount"  >
				</div>
				<div class="form-group">
					<label> Month Count <span class="help"> </span></label>
					<input type="text" class="form-control form-control-line"
					name="month_count"  >
				</div>

				<div class="form-group">
					<label> Note <span class="help"> </span></label>
					<input type="text" class="form-control form-control-line"
					name="note"  >
				</div>
				<div class="form-group">
					<label> Transaction id <span class="help"> </span></label>
					<input type="tel" class="form-control form-control-line"
					name="transaction_id"  >
				</div>

				<div class="col-md-12 form-group">
					<label>Supplier Name </label>
					<select style="width: 100%;" class="select2 m-b-10 select2-multiple" name="supplier_id">
						@foreach($suppliers as $supplier)
						<option selected>Open this select menu</option>
						<option  value="0">None</option>
						<option value="{{$supplier->id}}">{{$supplier->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="col-md-12 form-group">
					<label>Driver Name </label>
					<select style="width: 100%;" class="select2 m-b-10 select2-multiple" name="supplier_id">
						@foreach($trucks as $truck)
						<option selected>Open this select menu</option>
						<option  value="0">None</option>
						<option value="{{$truck->id}}">{{$truck->driver_name}}</option>
						@endforeach
					</select>
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