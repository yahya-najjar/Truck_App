@extends('admin.layouts.app')
@section('title')
Trucks
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Online trucks on map </h4>
				<h6 class="card-subtitle">data will update automatically every 10 seconds</h6>
    				<div id="map-canvas"></div>
			</div>
		</div>
	</div>
</div>
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
								<th>status</th>
                                <th>Current Location</th>
								<th>Coordinates</th>
								<th>last update</th>
								<th>Actions</th>
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
@endsection
@section('script')
<script type="text/javascript">var url = "{{url('')}}";</script> 
<script type="text/javascript">
	$(document).ready( function () {
		var table = $('#table_id').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax":
			{
				"url": url + '/admin/get_online_trucks',
				"dataType": "json",
				"type": "POST",
				"data": {
					"_token": "{{ csrf_token() }}",
				}
			},
			"columns": [
			{"data": "id"},
			{"data": "driver"},
			{"data": "status"},
            {"data": "location"},
			{"data": "coordinates"},
			{"data": "last_update"},
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


		setInterval( function () {
		    table.ajax.reload();
		}, 10000 );
	});

	</script>
	<script>
    var map;
    var markers = [];
    var myLatlng = new google.maps.LatLng(33.5138, 36.2765);

    function initialize() {
        var googleMapOptions = {
            zoom: 10,
            center: myLatlng
        };
        map = new google.maps.Map(document.getElementById("map-canvas"), googleMapOptions);
        setMarkers();
        setInterval(setMarkers, 30000);
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    function addMarker(lat, lng, full_name, created_at, last_update, color) {
        var pos = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
        var contentString =
            '<div id="content">' +
            '<div id="siteNotice">' +
            '</div>' +
            '<h1 id="firstHeading" class="firstHeading">Driver Info</h1>' +
            '<div id="bodyContent">' +
            '<p><b>Driver Name : </b>' + full_name +
            '<p><b>last seen : </b>' + created_at +
            '<p><b>last update : </b>' + last_update +
            '</div>' +
            '</div>';
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        var marker = new google.maps.Marker({
            title: 'click to zoom',
            label: full_name,
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
        $.ajax({
            url: '/admin/ajaxLocations',
            type: "get",
            success: function (response) {
                var trucks = JSON.parse(response);
                var length = trucks.length;
                for(var i = 0; i < length; i++){
                    addMarker(
                        trucks[i]['lat'],
                        trucks[i]['lng'],
                        trucks[i]['first_name'] + ' ' + trucks[i]['last_name'],
                        trucks[i]['location'],
                        trucks[i]['updated_at']? trucks[i]['updated_at']:'not yet',
                        trucks[i]['updated_at']? trucks[i]['updated_at']['color'] : "#FFF"
                    );
                    var row =
                        '<tr>' +
                        '<td>' + trucks[i]['id'] +  '</td>' +
                        '<td>' + trucks[i]['first_name'] + ' ' + trucks[i]['last_name'] +  '</td>' +
                        '<td>' + ((trucks[i]['status'] == 1)? 'online':'offline')  +  '</td>' +
                        '<td><a href="" data-toggle="tooltip" data-original-title="Show Driver Routes"> <i class="fa fa-eye text-inverse m-r-10"></i> </a> </td>'
                        '</tr>';

                    $('#drivers_table').append(row);
                }
            }
        });
    }
</script>
@endsection
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAI0S27Loc1RoYrhQYVPke_31aiF7lzXPQ"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfqfNvE-Tof6EFFrTuHobGrUzUq_lQNSQ"
    async defer></script> -->