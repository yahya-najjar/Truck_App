@extends('admin.layouts.app')
@section('title')
    Custom Notifications for customers
@endsection

@section('bread')
    <li class="breadcrumb-item active">Custom Notifications for customers</li>
@endsection


@section('content')

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ action('Admin\FCMCustomNotificationController@sendPost') }}" class="" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="customers">Choose Customers</label>
                                <small class="text-info">Leave it blank to broadcast</small>
                                <select style="width: 100%" name="customers_ids[]" id="customers"
                                        class="select2 m-b-10 select2-multiple"
                                        data-placeholder="All" multiple="multiple">
                                    <option>All</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">Message Title</label>
                                <input type="text" name="title" id="title" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="body">Message Body</label>
                                <textarea name="body" id="body" cols="30" rows="10"
                                          class="form-control"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Send</button>
                    </div>
                    <p id="llll">asdasd</p>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        console.log($('#llll').text());
        $(document).ready(function(){
            $('#customers').select2({
                ajax: {
                    url: "{{ action('Admin\FCMCustomNotificationController@getCustomers') }}",
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            search: params.term,
                        }
                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    }
                }
            });
        })
    </script>
@endsection