@extends('admin.layouts.app')

@section('title')
Truck Location
@endsection

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h2 style="color: blue;" class="card-title">Truck {{$truck->id}} location</h2>
        <form class="form-material m-t-40 row">
          <!-- <div class="form-group col-md-12 m-t-20">
            <label>Address <span class="help"> </span></label>
            <input type="text" class="form-control" name="address" 
                id="address" 
                value=""
                placeholder=""
                >
              </div> -->
              <div class="form-group col-md-6 m-t-20">
                <label>Lat <span class="help"> </span></label>
                <input type="text" class="form-control" name="lat" 
                id="lat" 
                value="{{isset($truck->lat)?$truck->lat:'-33.873197054587095'}}"
                placeholder=""
                >
              </div>
              <div class="form-group col-md-6 m-t-20">
                <label>Lng<span class="help"> </span></label>
                <input type="text" class="form-control" name="lng" id="lng"  
                value="{{isset($truck->lng)?$truck->lng:'151.21117772930046'}}"
                placeholder=""
                >
              </div>
            </form>
            <div class="col-md-12">
              <input id="pac-input" class="controls form-control" type="text" placeholder="Search Box">
              <div id="map" class="gmaps"></div>
            </div>
          </div>
        </div>
      </div>
    </div>


    @endsection 
    @section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfqfNvE-Tof6EFFrTuHobGrUzUq_lQNSQ&libraries=places&callback=initMap"
    async defer></script>

    <script>
      var lat = parseFloat('{{$truck->lat ?$truck->lat :-33.873197054587095}}');
      var lng = parseFloat('{{$truck->lng ? $truck->lng : 151.21117772930046}}');
      var position = [lat, lng];

      function initMap() {
       var latlng = new google.maps.LatLng(position[0], position[1]);

       var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat:lat, lng:lng },
        zoom: 13
      });

       marker = new google.maps.Marker({
        position: latlng,
        map: map,
        title: "Latitude:"+position[0]+" | Longitude:"+position[1]
      });

       var input = document.getElementById('pac-input');

       var autocomplete = new google.maps.places.Autocomplete(input);
       autocomplete.bindTo('bounds', map);

       map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

       google.maps.event.addDomListener(input, 'keydown', function(event) { 
        if (event.keyCode === 13) { 
          event.preventDefault();                 
        }
      });

       var infowindow = new google.maps.InfoWindow();
       var infowindowContent = document.getElementById('infowindow-content');
       infowindow.setContent(infowindowContent);

       marker.addListener('click', function() {
        infowindow.open(map, marker);
      });

       autocomplete.addListener('place_changed', function() {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (!place.geometry) {
          return;
        }

        if (place.geometry.viewport) {
          map.fitBounds(place.geometry.viewport);
        } else {
          map.setCenter(place.geometry.location);
          map.setZoom(17);
        }
        marker.setPosition(map.getCenter());

        $('input[name="lat"]').attr('value',marker.position.lat());
        $('input[name="lng"]').attr('value',marker.position.lng());
        $('input[id="address"]').attr('value', place.formatted_address);



        infowindowContent.children['place-name'].textContent = place.name;
        infowindowContent.children['place-address'].textContent =
        place.formatted_address;
        infowindow.open(map, marker);
      });

       google.maps.event.addListener(map, 'click', function(event) {
        var result = [event.latLng.lat(), event.latLng.lng()];
        MyLatLng = new google.maps.LatLng(event.latLng.lat(),event.latLng.lng());
        transition(result);
      });

       var numDeltas = 100;
       var delay = 10; 
       var i = 0;
       var deltaLat;
       var deltaLng;
       function transition(result){
        position = [marker.position.lat(),marker.position.lng()];

        i = 0;
        deltaLat = (result[0] - position[0])/numDeltas;
        deltaLng = (result[1] - position[1])/numDeltas;
        moveMarker();
      }

      function moveMarker(){
        console.log(position);

        position[0] += deltaLat;
        position[1] += deltaLng;
        var latlng = new google.maps.LatLng(position[0], position[1]);
        marker.setTitle("Latitude:"+position[0]+" | Longitude:"+position[1]);

        $('input[name="lat"]').attr('value',position[0]);
        $('input[name="lng"]').attr('value',position[1]);
        marker.setPosition(latlng);
        if(i!=numDeltas){
          i++;
          setTimeout(moveMarker, delay);
        }
      }
    }
  </script>

  @endsection