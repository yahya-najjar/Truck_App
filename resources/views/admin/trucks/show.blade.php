@extends('admin.layouts.app')
@section('title')
Truck Detailes
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h2 style="color: blue;" class="card-title">Truck {{$truck->id}}</h2>
				<h6 class="card-subtitle">truck detailes</h6>
				<hr>
				<div class="row">
					<div class="col-lg-3">
						<div class="card bg-danger">
							<div class="card-body">
								<div class="d-flex no-block">
									<div class="m-r-20 align-self-center"><img src="{{asset('../../assets/images/icon/staff-w.png')}}" alt="Income" /></div>
									<div class="align-self-center">
										<h6 class="text-white m-t-10 m-b-0">Driver Name</h6>
										<h2 class="m-t-0 text-white">{{$truck->driver_name}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="card bg-info">
							<div class="card-body">
								<div class="d-flex no-block">
									<div class="m-r-20 align-self-center"><img src="{{asset('../../assets/images/icon/income-w.png')}}" alt="Income" /></div>
									<div class="align-self-center">
										<h6 class="text-white m-t-10 m-b-0">Plate Number</h6>
										<h2 class="m-t-0 text-white">{{$truck->plate_num}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="card bg-success">
							<div class="card-body">
								<div class="d-flex no-block">
									<div class="m-r-20 align-self-center"><img src="{{asset('../../assets/images/icon/expense-w.png')}}" alt="Income" /></div>
									<div class="align-self-center">
										<h6 class="text-white m-t-10 m-b-0">Capacity</h6>
										<h2 class="m-t-0 text-white">{{$truck->capacity}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3">
						<div class="card bg-primary">
							<div class="card-body">
								<div class="d-flex no-block">
									<div class="m-r-20 align-self-center"><img src="{{asset('../../assets/images/icon/assets-w.png')}}" alt="Income" /></div>
									<div class="align-self-center">
										<h6 class="text-white m-t-10 m-b-0">Model</h6>
										<h2 class="m-t-0 text-white">{{$truck->model}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="col-lg-3">
						<div class="card bg-danger">
							<div class="card-body">
								<div class="d-flex no-block">
									<div class="m-r-20 align-self-center"><img src="{{asset('../../assets/images/icon/staff-w.png')}}" alt="Income" /></div>
									<div class="align-self-center">
										<h6 class="text-white m-t-10 m-b-0">Location</h6>
										<h2 class="m-t-0 text-white">{{$truck->location}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="col-lg-3">
						<div class="card bg-info">
							<div class="card-body">
								<div class="d-flex no-block">
									<div class="m-r-20 align-self-center"><img src="{{asset('../../assets/images/icon/income-w.png')}}" alt="Income" /></div>
									<div class="align-self-center">
										<h6 class="text-white m-t-10 m-b-0">Driver phone</h6>
										<h2 class="m-t-0 text-white">{{$truck->driver_phone}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-3">
						<div class="card bg-success">
							<div class="card-body">
								<div class="d-flex no-block">
									<div class="m-r-20 align-self-center"><img src="../../assets/images/icon/expense-w.png" alt="Income" /></div>
									<div class="align-self-center">
										<h6 class="text-white m-t-10 m-b-0">Vehicle Model</h6>
										<h2 class="m-t-0 text-white">{{$truck->model}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="card bg-primary">
							<div class="card-body">
								<div class="d-flex no-block">
									<div class="m-r-20 align-self-center"><img src="{{asset('../../assets/images/icon/assets-w.png')}}" alt="Income" /></div>
									<div class="align-self-center">
										<h6 class="text-white m-t-10 m-b-0">Price Per KM</h6>
										<h2 class="m-t-0 text-white">{{$truck->price_km}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="card bg-danger">
							<div class="card-body">
								<div class="d-flex no-block">
									<div class="m-r-20 align-self-center"><img src="{{asset('../../assets/images/icon/staff-w.png')}}" alt="Income" /></div>
									<div class="align-self-center">
										<h6 class="text-white m-t-10 m-b-0">Price Per Hour</h6>
										<h2 class="m-t-0 text-white">{{$truck->price_h}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="card bg-info">
							<div class="card-body">
								<div class="d-flex no-block">
									<div class="m-r-20 align-self-center"><img src="{{asset('../../assets/images/icon/income-w.png')}}" alt="Income" /></div>
									<div class="align-self-center">
										<h6 class="text-white m-t-10 m-b-0">Company Phone</h6>
										<h2 class="m-t-0 text-white">{{$truck->company_phone}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="card bg-info" >
							<div class="card-body" style="background-color: #000">
								<div class="d-flex no-block">
									<div class="m-r-20 align-self-center"></div>
									<div class="align-self-center">
										<h6 class="text-white m-t-10 m-b-0">Supplier</h6>
										<h2 class="m-t-0 text-white">{{$truck->supplier?$truck->supplier->name:'Private Truck'}}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection