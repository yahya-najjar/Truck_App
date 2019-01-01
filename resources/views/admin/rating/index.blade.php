@extends('admin.layouts.app')


@section('title')
Rating
@endsection

@section('style')
<style type="text/css">
.rating {
	display: inline-block;
	position: relative;
	height: 50px;
	line-height: 50px;
	font-size: 50px;
}

.rating label {
	position: absolute;
	top: 0;
	left: 0;
	height: 100%;
	cursor: pointer;
}

.rating label:last-child {
	position: static;
}

.rating label:nth-child(1) {
	z-index: 5;
}

.rating label:nth-child(2) {
	z-index: 4;
}

.rating label:nth-child(3) {
	z-index: 3;
}

.rating label:nth-child(4) {
	z-index: 2;
}

.rating label:nth-child(5) {
	z-index: 1;
}

.rating label input {
	position: absolute;
	top: 0;
	left: 0;
	opacity: 0;
}

.rating label .icon {
	float: left;
	color: transparent;
}

.rating label:last-child .icon {
	color: #000;
}

.rating:not(:hover) label input:checked ~ .icon,
.rating:hover label:hover input ~ .icon {
	color: #09f;
}

.rating label input:focus:not(:checked) ~ .icon:last-child {
	color: #000;
	text-shadow: 0 0 5px #09f;
}
</style>
@endsection


@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-9 rating">
			<label>
				<input  type="radio" name="star" value="1" {{ $star == 1 ? 'checked' : ''}}/>
				<span class="icon">★</span>
			</label>
			<label>
				<input type="radio" name="star" value="2" {{ $star == 2 ? 'checked' : ''}}/>
				<span class="icon">★</span>
				<span class="icon">★</span>
			</label>
			<label>
				<input type="radio" name="star" value="3" {{ $star == 3 ? 'checked' : ''}}/>
				<span class="icon">★</span>
				<span class="icon">★</span>
				<span class="icon">★</span>   
			</label>
			<label>
				<input type="radio" name="star" value="4" {{ $star == 4 ? 'checked' : ''}} />
				<span class="icon">★</span>
				<span class="icon">★</span>
				<span class="icon">★</span>
				<span class="icon">★</span>
			</label>
			<label>
				<input type="radio" name="star" value="5" {{ $star == 5 ? 'checked' : ''}}/>
				<span class="icon">★</span>
				<span class="icon">★</span>
				<span class="icon">★</span>
				<span class="icon">★</span>
				<span class="icon">★</span>
			</label>
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">
						Trucks Orders
					</h4>

					<table class="table table-striped table-actions" star="{{$star}}"  id="ratings">
						<thead>
							<tr>
								<th>id</th>
								<th>Customer Name</th>
								<th>Driver Name</th>
								<th>Rating</th>
								<th>Rating Date</th>
								<th>Show Ride</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>

<form style="display: hidden" action="/admin/driversRatings" method="POST" id="form">
	<input type="hidden" id="star" name="star" value=""/>
</form>

@endsection
@section('script')
<script type="text/javascript">var url = "{{url('')}}";</script> 
<script type="text/javascript">
	$(document).ready(function () {
		var star = $('#ratings').attr('star');
		$("#var1").val(star);
		$('#ratings').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax":
			{
				"url": url + '/admin/driversRatings',
				"dataType": "json",
				"type": "POST",
				"data": {
					"star": $('#ratings').attr('star'),
					"_token": "{{ csrf_token() }}",
				}
			},
			"columns": [
			{"data": "id"},
			{"data": "customer"},
			{"data": "driver"},
			{"data": "rating"},
			{"data": "created_at"},
			{"data": "show"},
			],


			columnDefs: [{
				targets: [-1],
				render: function (data, type, row, meta) {
					console.log(row['show']);
					var ID = row['show'];
					return '<a  data-toggle="tooltip" data-placement="top" title="" target="_blank" target="_blank"' +
					'  href="'+url+'/admin/truck/'+ID+'" data-original-title="Ride"><span class="fa fa-info"></span> &nbsp Truck: '+ ID +' </a> ';
				}
			}],

			"data":{
				"_token": "{{ csrf_token() }}",
			}

		});
	});
	console.log('{{$star}}');
	$('[name=star]').change(function () {
		location.href = url + '/admin/ratings/'+ this.value ;
	});

	$(':radio').change(function() {
		console.log('New star rating: ' + this.value);
	});


</script>
@endsection