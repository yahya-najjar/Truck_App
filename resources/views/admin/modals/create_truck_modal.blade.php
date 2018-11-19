{{--Add Truck Modal--}}
<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="myLargeModalLabel">Add new Truck</h4>
			<button type="button" class="close" data-dismiss="modal"
			aria-hidden="true">×
		</button>
	</div>
	<form action="{{action("Admin\TruckController@store")}}" method="post" enctype="multipart/form-data">
		<div class="modal-body">
			<div class="modal-body">
				{{ csrf_field() }}
				<div class="row col-md-12">
					<div class="col-md-6">
						<div class="form-group">
							<label>Driver Name <span class="help"> </span></label>
							<input type="text" class="form-control form-control-line"
							name="driver_name"  >
						</div>
						<div class="form-group">
							<label> Driver phone <span class="help"> </span></label>
							<input type="tel" class="form-control form-control-line"
							name="driver_phone">
						</div>

						<div class="form-group">
							<label> Company Phone <span class="help"> </span></label>
							<input type="tel" class="form-control form-control-line"
							name="company_phone" >
						</div>
					</div>
					<div class="col-md-6">
						<h2>Drage Image For Truck</h2>
						<input type="file" name="image" class="dropify">
					</div>
				</div>
				<hr>
				<div class="row col-md-12">
					<div class="col-md-6 form-group">
						<label for="expire_date">Expier Date</label>
						<input type="text" name="expire_date"  id="mdate" class=" mdate form-control ">
					</div>
					<div class="col-md-6 form-group">
						<label for="expire_date">Licence Date</label>
						<input type="text" name="licence_date"  id="mdate" class=" mdate form-control ">
					</div>
				</div>
				<div class="row col-md-12">
					<div class="col-md-12 form-group">
						<label> Plate Number <span class="help"> </span></label>
						<input type="text" class="form-control form-control-line"
						name="plate_num"  >
					</div>
				</div>
				<div class="row col-md-12">
					<div class="col-md-6 form-group">
						<label> Capacity <span class="help"> </span></label>
						<input type="number" class="form-control form-control-line"
						name="capacity"  >
					</div>
					<div class="col-md-6 form-group">
						<label>  Vehicle Model <span class="help"> </span></label>
						<input type="text" class="form-control form-control-line"
						name="model"  >
					</div>
				</div>
				<div class="row col-md-12">
					<div class="col-md-6 form-group">
					<label> Price Per KM <span class="help"> </span></label>
					<input type="number" class="form-control form-control-line"
					name="price_km"  >
				</div>
				<div class="col-md-6 form-group">
					<label> Price Per Hour <span class="help"> </span></label>
					<input type="number" class="form-control form-control-line"
					name="price_h"  >
				</div>
				</div>
				<div class="row col-md-12">
					<div class="col-md-12 form-group">
					<label>Supplier Name </label>
					<select style="width: 100%; height: 100%" class="select2 m-b-10 select2-multiple" name="supplier_id">
						<option selected>Open this select menu</option>

						<option  value="">none</option>
						@foreach($suppliers as $supplier)
						<option value="{{$supplier->id}}">{{$supplier->name}}</option>
						@endforeach
					</select>
				</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit"
				class="btn btn-primary waves-effect waves-light">
				Save
			</button>
			<button type="button"
			class="btn btn-danger waves-effect text-left"
			data-dismiss="modal">Cancel
		</button>
	</div>
</div>
</form>

</div>
</div>
</div>