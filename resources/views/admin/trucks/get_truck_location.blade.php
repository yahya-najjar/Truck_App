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
            <div class="col-md-12">
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

      
    }
  </script>

  @endsection