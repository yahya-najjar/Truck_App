@extends('admin.layouts.app')
@section('title')
Admin Dashboard
@endsection
@section('style')
    <!-- chartist CSS -->
    <link href="{{asset('/assets/plugins/chartist-js/dist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css')}}" rel="stylesheet">
@endsection

@section('bread')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection


@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Welcome {{Auth::user()->name}}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card bg-danger">
                <div class="card-body">
                    <div class="d-flex no-block" >
                        <div class="m-r-20 align-self-center"><img width="50" height="50"  src="{{asset('../../assets/images/icon/driver_w.png')}}" alt="Income" /></div>
                        <div class="align-self-center">
                            <h6 class="text-white m-t-10 m-b-0">Total Drivers</h6>
                            <h2 class="m-t-0 text-white">{{$total_drivers}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card bg-info">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="m-r-20 align-self-center"><img src="{{asset('../../assets/images/icon/staff-w.png')}}" alt="Income" /></div>
                        <div class="align-self-center">
                            <h6 class="text-white m-t-10 m-b-0">Total Customers</h6>
                            <h2 class="m-t-0 text-white">{{$total_customers}}</h2>
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
                            <h6 class="text-white m-t-10 m-b-0">Total Orders</h6>
                            <h2 class="m-t-0 text-white">{{$total_orders}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="m-r-20 align-self-center"><img src="{{asset('../../assets/images/icon/manager_w.png')}}" alt="Income" /></div>
                        <div class="align-self-center">
                            <h6 class="text-white m-t-10 m-b-0">Total Suppliers</h6>
                            <h2 class="m-t-0 text-white">{{$total_suppliers}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><span class="lstick"></span>Orders Status</h4>
                    <div id="orders_status" style="height:280px; width:100%;"></div>
                    <table class="table vm font-14 m-b-0">
                        <tr>
                            <td class="b-0">Ongoing</td>
                            <td class="text-right font-medium b-0">{{$on_going * 100 / $total_orders}}%</td>
                        </tr>
                        <tr>
                            <td>Done</td>
                            <td class="text-right font-medium">{{$done * 100 / $total_orders}}%</td>
                        </tr>
                        <tr>
                            <td>Canceled</td>
                            <td class="text-right font-medium">{{$canceled * 100 / $total_orders}}%</td>
                        </tr>
                        <tr>
                            <td>Rejected</td>
                            <td class="text-right font-medium">{{$rejected * 100 / $total_orders}}%</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <h4 class="card-title"><span class="lstick"></span>App Visits</h4>
                        <ul class="list-inline m-b-0 ml-auto">
                            <li>
                                <h6 class="text-muted text-success"><i class="fa fa-circle font-10 m-r-10 "></i>Android App</h6> </li>
                            <li>
                                <h6 class="text-muted text-info"><i class="fa fa-circle font-10 m-r-10"></i>IOS App</h6> </li>
                        </ul>
                    </div>
                    <div class="text-center m-t-30">
                        <div class="btn-group " role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-sm btn-secondary">CUSTOMERS</button>
                            <button type="button" class="btn btn-sm btn-secondary">DRIVERS</button>
                        </div>
                    </div>
                    <div class="website-visitor p-relative m-t-30" style="height:355px; width:100%;"></div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
<script src="{{asset('/assets/plugins/chartist-js/dist/chartist.min.js')}}"></script>
<script src="{{asset('/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js')}}"></script>

<script type="text/javascript">

    // ============================================================== 
    // Orders Status
    // ============================================================== 
    
    var chart = c3.generate({
        bindto: '#orders_status',
        data: {
            columns: [
                ['On going', '{{$on_going}}'],
                ['Done', '{{$done}}'],
                ['Canceled', '{{$canceled}}'],
                ['Rejected', '{{$rejected}}'],
            ],
            
            type : 'donut',
            onclick: function (d, i) { console.log("onclick", d, i); },
            onmouseover: function (d, i) { console.log("onmouseover", d, i); },
            onmouseout: function (d, i) { console.log("onmouseout", d, i); }
        },
        donut: {
            label: {
                show: false
              },
            title:"Status",
            width:20,
            
        },
        
        legend: {
          hide: true
          //or hide: 'data1'
          //or hide: ['data1', 'data2']
        },
        color: {
              pattern: ['#1d87e5', '#06d79c', '#dc3545', '#ffb22b']
        }
    });
</script>
@endsection