@extends('admin.layouts.app')
@section('title')
Order Detailes
@endsection
@section('bread')
<li class="breadcrumb-item "><a href="{{asset('admin/orders')}}">all orders</a></li>
<li class="breadcrumb-item active">show order details</li>
@endsection
@section('style')
<link href="{{asset('/assets/admin/plugins/Magnific-Popup-master/dist/magnific-popup.css')}}" rel="stylesheet">
<link href="{{asset('/assets/admin/css/pages/contact-app-page.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h2 class="card-title">Order {{$order->id}}</h2>
				<h6 class="card-subtitle">order detailes</h6>
				<hr>
				<!-- Row -->
				<div class="row">
					<!-- Column -->
					<div class="col-lg-4 col-xlg-3 col-md-5">
						<div class="card"> <img class="card-img" src="{{ $order->truck->image }}?w=320&h=405" alt="Card image">
							<div class="card-img-overlay card-inverse social-profile d-flex ">
								<div class="align-self-center"> <img src="/assets/admin/images/users/1.jpg" class="img-circle" width="100">
									<h4 class="card-title">{{$order->truck->driver_name ?? 'No Driver Set to this order'}}</h4>
									<h6 class="card-subtitle">current driver</h6>
									<p class="text-white">{{$order->truck->desc ?? ''}} </p>
								</div>
							</div>
						</div>
					</div>
					<!-- Column -->
					<!-- Column -->
					<div class="col-lg-8 col-xlg-9 col-md-7">
						<div class="card">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs profile-tab" role="tablist">
								<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#order_info" role="tab">Order</a> </li>
								<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#customer_info" role="tab">Customer</a> </li>
								<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#driver_info" role="tab">Driver</a> </li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane active" id="order_info" role="tabpanel">
									<div class="card-body">
										<div class="row">
											<div class="col-md-3 col-xs-6"> <strong>Status</strong>
												<br>
												<p class="text-muted">{{$order->StatusName}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Rating</strong>
												<br>
												<p class="text-muted">{{$order->rating}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Driver Name</strong>
												<br>
												<p class="text-muted">{{$order->driver->FullName}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Customer Name</strong>
												<br>
												<p class="text-muted">{{$order->customer->FullName}}</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-md-3 col-xs-6"> <strong>Order From :</strong>
												<br>
												<p class="text-muted">{{$order->location}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Order To:</strong>
												<br>
												<p class="text-muted">plapla</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Ordrer Date</strong>
												<br>
												<p class="text-muted">{{$order->created_at}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Order</strong>
												<br>
												<p class="text-muted">plapla</p>
											</div>
										</div>
										<hr>
										<p class="m-t-30">{{$order->comment}}</p>
									</div>
								</div>
								<!--second tab-->
								<div class="tab-pane" id="customer_info" role="tabpanel">
									<div class="card-body">
										<div class="row">
											<div class="col-md-3 col-xs-6"> <strong>Full Name</strong>
												<br>
												<p class="text-muted">{{$order->customer->FullName}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
												<br>
												<p class="text-muted">{{$order->customer->email}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Phone</strong>
												<br>
												<p class="text-muted">{{$order->customer->phone}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Gender</strong>
												<br>
												<p class="text-muted">{{$order->customer->gender = 1?'Male':'Female'}}</p>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="driver_info" role="tabpanel">
									<div class="card-body">
										<div class="row">
											<div class="col-md-3 col-xs-6"> <strong>Full Name</strong>
												<br>
												<p class="text-muted">{{$order->driver->FullName}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
												<br>
												<p class="text-muted">{{$order->driver->email}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Phone</strong>
												<br>
												<p class="text-muted">{{$order->driver->phone}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Gender</strong>
												<br>
												<p class="text-muted">{{$order->driver->gender = 1?'Male':'Female'}}</p>
											</div>
										</div>
										<hr>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Column -->
				</div>
				<div class="col-md-12">
					<div id="map-canvas" class="gmaps"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="{{asset('/assets/admin/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('/assets/admin/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>

<script>
	var map;
	var markers = [];
	var myLatlng = new google.maps.LatLng('{{ $order->order_logs()->first()->lat }}', '{{ $order->order_logs()->first()->lng }}');

	function initialize() {
		var googleMapOptions = {
			zoom: 8,
			center: myLatlng,
		};
		map = new google.maps.Map(document.getElementById("map-canvas"), googleMapOptions);
		var TripCoordinates = [
			@foreach($order->order_logs as $log)
	          {lat: parseFloat('{{ $log->lat }}'), lng: parseFloat('{{$log->lng}}')},
			@endforeach
        ];
        var TripPath = new google.maps.Polyline({
                  path: TripCoordinates,
                  geodesic: true,
                  strokeColor: '#FF0000',
                  strokeOpacity: 1.0,
                  strokeWeight: 2
                });
        TripPath.setMap(map);
		setMarkers();
		// setInterval(setMarkers, 30000);
	}

	google.maps.event.addDomListener(window, 'load', initialize);

	function addMarker(lat, lng, status, location, last_update, color) {
		var pos = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
		var contentString =
		'<div id="content">' +
		'<div id="siteNotice">' +
		'</div>' +
		'<h3 id="firstHeading" class="firstHeading" style="color:'+ color +'">'+ status +'</h3>' +
		'<div id="bodyContent">' +
		'<p><b>Action Date : </b>' + last_update +
		'<p><b>Location : </b>' + location +
		'</div>' +
		'</div>';
		var infowindow = new google.maps.InfoWindow({
			content: contentString
		});
		var marker = new google.maps.Marker({
			title: 'click to zoom',
			label: status,
			position: pos,
			map: map,
			icon: pinSymbol(color),
		});
		google.maps.event.addListener(marker, 'click', (function (marker) {
			return function () {
				map.setZoom(15);
				map.setCenter(marker.getPosition());
			}
		})(marker));
		google.maps.event.addListener(marker, 'mouseover', (function (marker, contentString, infowindow) {
			return function () {
				infowindow.setContent(contentString);
				infowindow.open(map, marker);
			}
		})(marker, contentString, infowindow));

		google.maps.event.addListener(marker, 'mouseout', (function (marker, contentString, infowindow) {
			return function () {
				infowindow.close();
			}
		})(marker, contentString, infowindow));
		markers.push(marker);
	}

	function pinSymbol(color) {
		return {
			path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z M -2,-30 a 2,2 0 1,1 4,0 2,2 0 1,1 -4,0',
			fillColor: color,
			fillOpacity: 1,
			strokeColor: '#000',
			strokeWeight: 2,
			scale: 1,
		};
	}

	function clearMarkers(){
		for(var i=0; i<markers.length; i++){
			markers[i].setMap(null);
		}
	}
	function clearTable(){
		$('#drivers_table').html('');
	}

	function setMarkers() {
		clearMarkers();
		clearTable();
		@foreach($order->order_logs as $log)
		console.log('{{ $log->lat }}')
			addMarker(
				'{{$log->lat}}',
				'{{$log->lng}}',
				'{{$log->StatusName}}',
				'{{$log->location}}',
				'{{$log->updated_at ?? 'not yet'}}',
				' {{$log->Color ?? "#FFF"}}'
				);
		@endforeach
	}
</script><!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfqfNvE-Tof6EFFrTuHobGrUzUq_lQNSQ&libraries=places&callback=initMap"
async defer></script> -->
@endsection
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAI0S27Loc1RoYrhQYVPke_31aiF7lzXPQ"></script>

