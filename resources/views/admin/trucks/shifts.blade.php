@extends('admin.layouts.app')
@section('title')
Truck Shifts
@endsection
@section('bread')
    <li class="breadcrumb-item"><a href="{{asset('/admin/trucks')}}">all trucks</a></li>
    <li class="breadcrumb-item active">trucks shifts</li>
@endsection
@section('style')
<link href="{{asset('/assets/admin/plugins/calendar/dist/fullcalendar.css')}}" rel="stylesheet">
@endsection

@section('content')
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="">
                                <div class="row">
<!--                                     <div class="col-lg-3">
                                        <div class="card-body">
                                            <h4 class="card-title m-t-10">Drag & Drop Event</h4>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="calendar-events" class="">
                                                        <div class="calendar-events" data-class="bg-info"><i class="fa fa-circle text-info"></i> My Event One</div>
                                                        <div class="calendar-events" data-class="bg-success"><i class="fa fa-circle text-success"></i> My Event Two</div>
                                                        <div class="calendar-events" data-class="bg-danger"><i class="fa fa-circle text-danger"></i> My Event Three</div>
                                                        <div class="calendar-events" data-class="bg-warning"><i class="fa fa-circle text-warning"></i> My Event Four</div>
                                                    </div>
                                                    // checkbox
                                                    <div class="checkbox m-t-20">
                                                        <input id="drop-remove" type="checkbox">
                                                        <label for="drop-remove">
                                                            Remove after drop
                                                        </label>
                                                    </div>
                                                    <a href="#" data-toggle="modal" data-target="#add-new-event" class="btn m-t-10 btn-info btn-block waves-effect waves-light">
                                                            <i class="ti-plus"></i> Add New Event
                                                        </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-12">
                                        <div class="card-body b-l calender-sidebar">
                                            <div id="calendar"></div>
                                        </div>
                                        <input type="hidden" name="truck_id" id="truck_id" value="{{$truck->id}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BEGIN MODAL -->
                <div class="modal none-border" id="my-event" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Add Shift</strong></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success save-event waves-effect waves-light">Create shift</button>
                                <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Add Category -->
                <div class="modal fade none-border" id="add-new-event" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Add</strong> a Shift</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form role="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">Admin Note</label>
                                            <input class="form-control form-white" placeholder="Enter note" type="text" name="category-name" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Choose Driver</label>
                                            <select class="form-control form-white" data-placeholder="Choose a driver..." name="category-color" id="select_driver_list">
                                                @foreach($drivers as $driver)
                                                <option value="{{$driver->id}}">{{$driver->FullName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
@endsection

@section('script')
    <!-- Calendar JavaScript -->
    <script src="{{asset('/assets/admin/plugins/calendar/jquery-ui.min.js')}}"></script>
    <script src="{{asset('/assets/admin/plugins/moment/moment.js')}}"></script>
    <script src="{{asset('/assets/admin/plugins/calendar/dist/fullcalendar.min.js')}}"></script>
    <script src="{{asset('/assets/admin/plugins/calendar/dist/cal-init.js')}}"></script>
@endsection