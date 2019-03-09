@extends('admin.layouts.app')
@section('title')
Orders
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">All orders </h4>
				<h6 class="card-subtitle"></h6>
				<div class="form-group">
                    <label>States</label>
                    <select name="status" class="form-control">
                        <option selected >All</option>
                        @foreach($states as $key => $status)
                            <option value="{{$status}}">{{$key}}</option>
                        @endforeach
                    </select>
                </div>
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="orders_table">
						<thead>
							<tr>
								<th>Customer name</th>
								<th>Truck Driver name</th>
								<th>Status</th>
								<th>Rating</th>
								<th>Comment</th>
								<th>Order Date</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<!-- @foreach($orders as $order)
							<tr>
								<td>{{ $order->id }}</td>
								<td>{{ strip_tags($order->customer->FullName) ?? 'No Title' }}</td>
								<td>{{ $order->truck->driver_name }}</td>
								<td>{{ $order->location }}</td>

								<td>{{ $order->StatusName }}</td>
								<td>{{ $order->rating }}</td>
								<td>{{ $order->created_at }}</td>
								<td></td>
							</tr>
							@endforeach -->

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<form style="display: hidden" action="url('allorders')" method="POST" id="form">
    <input type="hidden" id="status" name="status" value=""/>
</form>
@endsection
@section('script')
<script type="text/javascript" charset="utf8" src="{{asset('/assets/admin/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript">var url = "{{url('')}}";</script>
<script type="text/javascript">

    $(document).ready(function () {
        var order = $('#orders_table').attr('order');
        $("#var1").val(order);
        var table =  $('#orders_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":
                {
                    "url": url + '/admin/all_orders',
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d){
                       d._token = "{{ csrf_token() }}";
                       d.status = $('#orders_table').attr('order');
                    }
                },
            "columns": [
                {"data": "customer_name"},
                {"data": "driver_name"},
                {"data": "status"},
                {"data": "rating"},
                {"data": "comment"},
                {"data": "created_at"},
                {"data": "actions"},
            ],

            "data":{
                "_token": "{{ csrf_token() }}",
            }

        });

        function getOrder() {
            var order = $('#orders_table').attr('order');
            return 
        }
         // "order": $('#orders_table').attr('order'),
         //                "_token": "{{ csrf_token() }}",

        $('#orders_table tbody').on('click', 'tr', function () {
            var data = table.row( this ).data();
            // console.log(data);

            $('[data-delete]').click(function (e) {
                console.log("clicked");
                e.preventDefault();

                swal({
                    title: "Are You Sure?",
                    text: "If you Activate/Deactivate this user !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: false,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $(this).parent().find('> #delete').submit();
                        } else {
                            swal("Canceled!");
                        }
                    });

            });

        } );

        $('[name=status]').change(function () {
            // location.href = url + '/admin/all_users/' + $(this).val();
            console.log($(this).val())
            $('#orders_table').attr('order',$(this).val());
            console.log($('#orders_table').attr('order'));

            table.ajax.reload();

        });


    });


</script>
@endsection