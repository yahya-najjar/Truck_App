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
				<h1 class="">There is no Online Trucks Here Yet! <i class="far fa-grin-beam-sweat"></i>
				</h1><br>
			</div>
		</div>
	</div>
</div>
@else
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">All Online trucks </h4>
				<h6 class="card-subtitle"></h6>
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="table_id">
						<thead>
							<tr>
								<th>#</th>
								<th>Driver Name</th>
								<th>Phone</th>
								<th>Plate Number</th>
								<th>Current Location</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($trucks as $truck)
							<tr>
								<td>{{ $truck->id }}</td>

								<td>{{ strip_tags($truck->driver_name) ?? 'No Title' }}</td>
								<td>{{ $truck->driver_phone }}</td>
								<td>{{ $truck->plate_num }}</td>

								<td>{{ $truck->capacity }}</td>


								<td class="text-nowrap">
									<a class="btn default btn-outline" title="Show More Detailes" data-placement="top" data-toggle="tooltip" href="{{ action('Admin\TruckController@show', $truck) }} "> <i style="color:#00edd5;" class="fas fa-eye m-r-10"></i></a>
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
@section('script')
<script type="text/javascript">
	$(document).ready( function () {
		$('#table_id').DataTable(); });
</script>
@endsection