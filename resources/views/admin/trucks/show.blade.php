@extends('admin.layouts.app')
@section('title')
Truck Detailes
@endsection
@section('bread')
<li class="breadcrumb-item "><a href="{{asset('admin/trucks')}}">all trucks</a></li>
<li class="breadcrumb-item active">show truck details</li>
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
				<h2 class="card-title">Truck {{$truck->id}}</h2>
				<h6 class="card-subtitle">truck detailes</h6>
				<hr>
				<!-- Row -->
				<div class="row">
					<!-- Column -->
					<div class="col-lg-4 col-xlg-3 col-md-5">
						<div class="card"> <img class="card-img" src="{{ $truck->image }}?w=320&h=405" alt="Card image">
							<div class="card-img-overlay card-inverse social-profile d-flex ">
								<div class="align-self-center"> <img src="{{asset(/assets/admin/images/users/1.jpg)}}" class="img-circle" width="100">
									<h4 class="card-title">{{$truck->driver_name ?? 'No Driver Set to this truck'}}</h4>
									<h6 class="card-subtitle">current driver</h6>
									<p class="text-white">{{$truck->desc ?? ''}} </p>
								</div>
							</div>
						</div>
						@if(isset($truck->currentDriver))
						<div class="card">
							<div class="card-body"> <small class="text-muted">Email address </small>
								<h6>{{$truck->currentDriver->email ?? ''}}</h6> <small class="text-muted p-t-30 db">Phone</small>
								<h6>{{$truck->currentDriver->phone ?? ''}}</h6> <small class="text-muted p-t-30 db">Current Location</small>
								<h6>{{$truck->location ?? ''}}</h6>
<!-- 								<div class="map-box">
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d470029.1604841957!2d72.29955005258641!3d23.019996818380896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fcedd11614f6516!2sAhmedabad%2C+Gujarat!5e0!3m2!1sen!2sin!4v1493204785508" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
								</div> --> 
							</div>
						</div>
						@endif
					</div>
					<!-- Column -->
					<!-- Column -->
					<div class="col-lg-8 col-xlg-9 col-md-7">
						<div class="card">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs profile-tab" role="tablist">
								<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Shifts</a> </li>
								<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Profile</a> </li>
								<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Settings</a> </li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane active" id="home" role="tabpanel">
									<div class="card-body">
										<div class="profiletimeline">
											@foreach($shifts as $shift)
											<div class="sl-item">
												<div class="sl-left"> <img src="/assets/admin/images/users/1.jpg" alt="user" class="img-circle" /> </div>
												<div class="sl-right">
													<div><a href="#" class="link">{{$shift->first_name .' '. $shift->last_name}}</a> <span class="sl-date">{{Carbon\Carbon::parse($shift->created_at)->diffForHumans()}}</span>
														<p>assigned to this truck <a href="{{ action('Admin\TruckController@shifts', $truck) }}" target="_blank"> Shifts Management</a></p>
														<div class="row col-md-12">
															Shift Note : {{$shift->note}}
														</div>
														<div class="row col-md-12">
															<div class="col-md-6">
																From : {{Carbon\Carbon::parse($shift->from)->format('g:i A')}}
															</div>
															<div class="col-md-6">
																To : {{Carbon\Carbon::parse($shift->to)->format('g:i A')}}
															</div>
														</div>
													</div>
												</div>
											</div>
											<hr>
											@endforeach
										</div>
									</div>
								</div>
								<!--second tab-->
								<div class="tab-pane" id="profile" role="tabpanel">
									<div class="card-body">
										<div class="row">
											<div class="col-md-3 col-xs-6"> <strong>Supplier</strong>
												<br>
												<p class="text-muted">{{$truck->supplier->name}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Plate Number</strong>
												<br>
												<p class="text-muted">{{$truck->plate_num}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Company Phone</strong>
												<br>
												<p class="text-muted">{{$truck->company_phone}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Capacity</strong>
												<br>
												<p class="text-muted">{{$truck->capacity}}</p>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-md-3 col-xs-6"> <strong>Price Per Km</strong>
												<br>
												<p class="text-muted">{{$truck->price_km}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Price Per Hour</strong>
												<br>
												<p class="text-muted">{{$truck->price_h}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>Expire Date</strong>
												<br>
												<p class="text-muted">{{$truck->expire_date}}</p>
											</div>
											<div class="col-md-3 col-xs-6 b-r"> <strong>License Expire Date</strong>
												<br>
												<p class="text-muted">{{$truck->licence_date}}</p>
											</div>
										</div>
										<hr>
										<p class="m-t-30">{{$truck->desc}}</p>
										<h4 class="font-medium m-t-30">Truck Orders</h4>
										<hr>
										<h5 class="m-t-30">Done <span class="label label-rounded label-success">{{$truck->done}}</span>  <span class="pull-right">{{$truck->done_rat}}%</span></h5>
										<div class="progress">
											<div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{$truck->done_rat}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$truck->done_rat}}%; height:6px;"> <span class="sr-only">50% Complete</span> </div>
										</div>
										<h5 class="m-t-30">OnGoing <span class="label label-rounded label-info">{{$truck->on_going}}</span><span class="pull-right">{{$truck->on_going_rat}}%</span></h5>
										<div class="progress">
											<div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{$truck->on_going_rat}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$truck->on_going_rat}}%; height:6px;"> <span class="sr-only">50% Complete</span> </div>
										</div>
										<h5 class="m-t-30">Rejected<span class="label label-rounded label-danger">{{$truck->rejected}}</span> <span class="pull-right">{{$truck->rejected_rat}}%</span></h5>
										<div class="progress">
											<div class="progress-bar bg-danger" role="progressbar" aria-valuenow="{{$truck->rejected_rat}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$truck->rejected_rat}}%; height:6px;"> <span class="sr-only">50% Complete</span> </div>
										</div>
										<h5 class="m-t-30">Canceled <span class="label label-rounded label-warning">{{$truck->canceled}}</span> <span class="pull-right">{{$truck->canceled_rat}}%</span></h5>
										<div class="progress">
											<div class="progress-bar bg-warning" role="progressbar" aria-valuenow="{{$truck->canceled_rat}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$truck->canceled_rat}}%; height:6px;"> <span class="sr-only">50% Complete</span> </div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="settings" role="tabpanel">
									<div class="card-body">
										<form class="form-horizontal form-material" enctype="multipart/form-data"
										action="{{action('Admin\TruckController@update',$truck) }}" method="post">
										{{ csrf_field() }}
										{{ method_field('PATCH') }}
										<div class="row col-md-12">
											<div class="col-md-6">
												<div class="form-group">
													<label>Company Phone <span class="help"> </span></label>
													<input type="text" value="{{$truck->company_phone}}" class="form-control form-control-line"
													name="company_phone"  >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Plate Number <span class="help"> </span></label>
													<input type="text" value="{{$truck->plate_num}}" class="form-control form-control-line"
													name="plate_num"  >
												</div>
											</div>
										</div>
										<div class="row col-md-12">
											<div class="col-md-6">
												<div class="form-group">
													<label>Capacity <span class="help"> </span></label>
													<input type="text" value="{{$truck->capacity}}" class="form-control form-control-line"
													name="capacity"  >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Vehicle Model <span class="help"> </span></label>
													<input type="text" value="{{$truck->model}}" class="form-control form-control-line"
													name="model"  >
												</div>
											</div>
										</div>
										<div class="row col-md-12">
											<div class="col-md-6">
												<div class="form-group">
													<label>Price Per KM <span class="help"> </span></label>
													<input type="text" value="{{$truck->price_km}}" class="form-control form-control-line"
													name="price_km"  >
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Price Per Hour <span class="help"> </span></label>
													<input type="text" value="{{$truck->price_h}}" class="form-control form-control-line"
													name="price_h"  >
												</div>        
											</div>
										</div>     
										<div class="col-md-12">
										    <div class="form-group">
										            <label>Description <span class="help"> </span></label>
										            <textarea rows="4" name="desc" value="{{$truck->desc}}" class="form-control form-control-line">{{$truck->desc}}</textarea>
										    </div>
										</div>           
										<div class=" row col-md-12 ">
											<div class="col-md-6">
												<label class="my-1 mr-2" for="inlineFormCustomSelectPref">
													Supplier Name 
												</label>
												<select  style="width: 100%;" class="select2 m-b-10 select2-multiple" id="inlineFormCustomSelectPref">
													@foreach($suppliers as $supplier)
													<option value="{{$supplier->id}}" {{$supplier->id == $truck->supplier->id ?'seleced' : ''}} >
														{{$supplier->name}}
													</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="row col-sm-12">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Image</label>
													<input type="file" name="image" value="{{ url('/storage/' . $truck->image)}}" class="dropify">
												</div>
											</div>
											<div class="col-sm-6">
												<label>Old Image</label>

												<div class="card " >
													<div class="card-body" style="margin-top: -20px;">
														<div class="d-flex no-block">
															<div id="image-popups">
																<a href="{{ $truck->image }}?w=400&h=200" data-effect="mfp-zoom-in"><img src="{{ $truck->image }}?w=400&h=200" class="img-responsive" />
																	<br/>
																</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<br>
										<div class="row col-md-12">
											<div class="offset-2 col-md-6">
												<div class="form-group">
													<button type="submit" class="btn btn-primary my-2">Save</button>                
												</div>
											</div>
										</div>

									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Column -->
			</div>
		</div>
	</div>
</div>
</div>
@endsection
@section('script')
<script src="{{asset('/assets/admin/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('/assets/admin/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>
@endsection

