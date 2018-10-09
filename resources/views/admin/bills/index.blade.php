@extends('admin.layouts.app')
@section('title')
Renew Account
@endsection

@section('content')

@if(!count($bills))
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<h1 class="">There is no Items Here Yet! <i class="far fa-grin-beam-sweat"></i>
				</h1><br>
				<button class=" btn btn-success btn-rounded col-md-3" data-toggle="modal"
				data-target="#addAdminModal">
				<i class="fa fa-plus-circle m-r-5"></i>Renew Account</button><br><br>
			</div>
		</div>
	</div>
</div>
@else
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Pay Fee For Suppliers and Private Drivers </h4>
				
				<button class=" btn btn-success btn-rounded col-md-3" data-toggle="modal"
				data-target="#addAdminModal">
				<i class="fa fa-plus-circle m-r-5"></i>Renew Account</button><br>
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
								<th>Note</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($bills as $bill)
							<tr>
								<td>{{ $bill->id }}</td>
								<td>{{ $bill->cash_amount }}</td>
								<td>{{ $bill->month_count }}</td>
								<td> {{ $bill->supplier ? $bill->supplier->name : '' }} </td>
								<td> {{ $bill->truck ? $bill->truck->driver_name : '' }} </td>
								<td>{{ $bill->note }}</td>


								<td class="text-nowrap">
	                              <!-- 	<a class="btn default btn-outline" title="Show More Detailes" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\BillController@show', $bill) }} "> <i style="color:#00edd5;" class="fas fa-eye"></i></a> 

									<a class="btn default btn-outline" title="Edit Bill" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\BillController@edit', $bill) }} "><i class="fas fa-edit" style="color: #1e88e5;"> </i></a>
								-->


								<a class="btn default btn-outline " data-delete href="javascript:void(0);"><i
									class="fa fa-trash text-danger" data-toggle="tooltip" data-placement="top" title="Delete Bill"></i></a>

									<form action="{{ action('Admin\BillController@destroy', $bill) }}"
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
					<input type="number" class="form-control form-control-line"
					name="cash_amount">
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
				<!-- <div class="form-group">
					<label for="expire_date">Expier_Date</label>
					<input type="date" name="expire_date"  id="mdate"class="mdate form-control form-control-line">
				</div> -->
<!-- 				<div class="form-group">
					<label> Transaction id <span class="help"> </span></label>
					<input type="tel" class="form-control form-control-line"
					name="transaction_id"  >
				</div> -->

				<div class="col-md-12 form-group">
					<label>Supplier Name </label>
					<select style="width: 100%;" class="select2 m-b-10 select2-multiple supplier_id" name="supplier_id">
						<option selected>Open this select menu</option>
						<option  value="">None</option>
						@foreach($suppliers as $supplier)

						<option value="{{$supplier->id}}">{{$supplier->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="col-md-12 form-group">
					<label>Driver Name <small>Private Trucks</small></label>
					<select style="width: 100%;" class="select2 m-b-10 select2-multiple truck_id" name="truck_id">
						<option selected>Open this select menu</option>
						<option  value="">None</option>
						@foreach($trucks as $truck)

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

	$('[name=supplier_id]').change(function () {
		$('option:selected', 'select[name="truck_id"]').removeAttr('selected');
		console.log('sup changed');
		$(".truck_id option[value='']").attr('selected', 'selected');
		console.log($(".truck_id").val());
	});

	$('[name=truck_id]').change(function () {
		$('option:selected', 'select[name="supplier_id"]').removeAttr('selected');
		console.log('truck changed');
		$(".supplier_id option[value='']").attr('selected', 'selected');
		console.log($(".supplier_id").val());

	});

</script>
@endsection