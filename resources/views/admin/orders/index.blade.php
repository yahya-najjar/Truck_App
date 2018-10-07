@extends('admin.layouts.app')
@section('title')
Orders
@endsection

@section('content')

@if(!count($orders))
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<h1 class="">There is no Orders Here Yet! <i class="far fa-grin-beam-sweat"></i>
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
				<h4 class="card-title">All orders </h4>
				<h6 class="card-subtitle"></h6>
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="table_id">
						<thead>
							<tr>
								<th>#</th>
								<th>Customer name</th>
								<th>Truck Driver name</th>
								<th>Pick up location</th>
								<th>Status</th>
								<th>Rating</th>
								<th>Order Date</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($orders as $order)
							<tr>
								<td>{{ $order->id }}</td>

								<td>{{ strip_tags($order->user->name) ?? 'No Title' }}</td>
								<td>{{ $order->truck->driver_name }}</td>
								<td>{{ $order->location }}</td>

								<td>{{ $order->status }}</td>
								<td>{{ $order->rating }}</td>
								<td>{{ $order->created_at }}</td>



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