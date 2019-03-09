@extends('admin.layouts.app')
@section('title')
suppliers
@endsection
@section('bread')
<li class="breadcrumb-item active">suppliers</li>
@endsection

@section('content')

@if(!count($suppliers))
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<h1 class="">There is no Items Here Yet! <i class="far fa-grin-beam-sweat"></i>
				</h1><br>
				<button class=" btn btn-success btn-rounded col-md-3" data-toggle="modal"
				data-target="#addAdminModal">
				<i class="fa fa-plus-circle m-r-5"></i>Add Supplier</button><br><br>
				
			</div>
		</div>
	</div>
</div>
@else
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">All suppliers </h4>
				<button class=" btn btn-success btn-rounded col-md-3" data-toggle="modal"
				data-target="#addAdminModal">
				<i class="fa fa-plus-circle m-r-5"></i>Add Supplier</button><br><br>
				<h6 class="card-subtitle"></h6>
				<div class="table-responsive">
					<table class="table table-bordered table-striped " id="table_id">
						<thead>
							<tr>
								<th>#</th>
								<th>User name</th>
								<th>Description</th>
								<th>Location</th>
								<th>Phone</th>
								<!-- <th>Expiration Date</th> -->
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($suppliers as $supplier)
							<tr>
								<td>{{ $supplier->id }}</td>

								<td>{{ strip_tags($supplier->name) ?? 'No Title' }}</td>
								<td>{{ $supplier->description }}</td>
								<td>{{ $supplier->location }}</td>
								<td>{{ $supplier->phone }}</td>
								<!-- <td><span class="label label-{{$supplier->IsExpired ?'danger':'info'}}">{{ $supplier->expire_date }}</span></td> -->

								<td class="text-nowrap">
									<a class="btn default btn-outline" title="Edit Supplier" href="{{ action('Admin\SupplierController@edit', $supplier) }} "><i style="color: #1e88e5;" class="fas fa-edit" data-toggle="tooltip" data-placement="left" title="Edit Supplier"></i></a>

									<!-- <a class="btn default btn-outline" title="Renew Account"role="button" data-toggle="modal"
									data-target="#renewModal_{{$supplier->id}}"><i style="color: #16bf1e;" class="fas fa-dollar-sign" data-toggle="tooltip" data-placement="left" title="Renew Account"></i></a> -->

									<a class="btn default btn-outline " data-delete href="javascript:void(0);"><i
										class="fas fa-{{$supplier->is_verified==1?'lock':'lock-open'}} text-{{$supplier->is_verified==1?'danger':'success'}} m-r-10" data-toggle="tooltip" data-placement="top" title="{{$supplier->is_verified==1?'Deactivate':'Activate'}} Supplier"></i></a>

										<form action="{{ action('Admin\SupplierController@destroy', $supplier) }}"
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
@include('admin.modals.create_supplier_modal')
{{--Add Bill Modal--}}
@foreach($suppliers as $supplier)
<div class="modal fade" id="renewModal_{{$supplier->id}}" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel_{{$supplier->id}}" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myLargeModalLabel_{{$supplier->id}}">Renew {{$supplier->name}} account</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X
				</button>
			</div>
			<form action="{{action("Admin\BillController@store")}}" method="post">
				<div class="modal-body">
					{{ csrf_field() }}
					<div class="row col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<label>Cash Amount <span class="help"> </span></label>
								<input type="number" class="form-control form-control-line"
								name="cash_amount"  >
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label> Month Count <span class="help"> </span></label>
								<input type="number" class="form-control form-control-line"
								name="month_count"  >
							</div>		
						</div>
					</div>

					<div class="row col-md-12">
						<div class="col-md-6">
							<div class="form-group">
								<label> Note <span class="help"> </span></label>
								<textarea type="text" class="form-control form-control-line"
								name="note" ></textarea>
							</div>		
						</div>
						<div class="col-md-6">
							
						</div>
					</div>
					
					

					

					<div class="col-md-12 form-group">
						<input type="hidden" name="supplier_id" value="{{$supplier->id}}">
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
@endforeach

@endsection
@section('script')
<script type="text/javascript" charset="utf8" src="{{asset('/assets/admin/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript">
	$(document).ready( function () {
		$('#table_id').DataTable();
	} );

</script>
@endsection