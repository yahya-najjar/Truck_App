
{{--Add Bill Modal--}}
@foreach($trucks as $truck)
<div class="modal fade" id="renewModal_{{$truck->id}}" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel_{{$truck->id}}" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myLargeModalLabel_{{$truck->id}}">Renew {{$truck->driver_name}} account</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X
				</button>
			</div>
			<form action="{{action("Admin\BillController@store")}}" method="post">
				<div class="modal-body">
					{{ csrf_field() }}
					<div class="form-group">
						<label>Cash Amount <span class="help"> </span></label>
						<input type="number" class="form-control form-control-line"
						name="cash_amount"  >
					</div>
					<div class="form-group">
						<label> Month Count <span class="help"> </span></label>
						<input type="number" class="form-control form-control-line"
						name="month_count"  >
					</div>

					<div class="form-group">
						<label> Note <span class="help"> </span></label>
						<textarea type="text" class="form-control form-control-line"
						name="note" ></textarea>
					</div>

					<div class="col-md-12 form-group">
						<input type="hidden" name="truck_id" value="{{$truck->id}}">
					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-primary waves-effect waves-light">
							Save
						</button>
						<button type="button" class="btn btn-danger waves-effect text-left"data-dismiss="modal">
							Cancel
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endforeach