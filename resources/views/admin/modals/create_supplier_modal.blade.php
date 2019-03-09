
{{--Add Supplier Modal--}}
<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="myLargeModalLabel">Add new Supplier</h4>
			<button type="button" class="close" data-dismiss="modal"
			aria-hidden="true">×
		</button>
	</div>
	<form action="{{action("Admin\SupplierController@store")}}" method="post">
		<div class="modal-body">
			<div class="modal-body">
				{{ csrf_field() }}
				<div class="row col-md-12">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">name</label>
							<input type="text" name="name" class="form-control">
						</div>		
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="location">location</label>
							<input type="text" name="location" class="form-control">
						</div>		
					</div>
				</div>
				<div class="row col-md-12">
					<div class="col-md-6">
						<div class="form-group">
							<label for="description">description</label>
							<input type="text" name="description" class="form-control">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="phone">phone Number</label>
							<input type="text" name="phone" class="form-control">
						</div>
					</div>
				</div>
				<div class="row col-md-12">
					<div class="col-md-6">
						<div class="form-group">
							<label for="expire_date">Expier Date</label>
							<input type="date" name="expire_date"  id="mdate"class="mdate form-control form-control-line">
						</div>
					</div>
					<div class="col-md-6">
						
					</div>
				</div>				
			
				<div class="col-md-12 form-group">
					<label>User(supplier) Account </label>
					<select style="width: 100%;" class="select2 m-b-10 select2-multiple" name="user_id">
						<option selected>Open this select menu</option>

						<option  value="">none</option>
						@foreach($users as $user)
						<option value="{{$user->id}}">{{$user->name}}</option>
						@endforeach
					</select>
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