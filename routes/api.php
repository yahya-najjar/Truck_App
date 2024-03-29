<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::post('recover', 'AuthController@recover');
Route::post('verify', 'AuthController@verifyUserRequest'); // send code so you verify your account
Route::post('resetPassword','AuthController@resetPassword');
Route::post('reset','AuthController@reset');

Route::post('check', function () {
            // if (!request()->has('token')) {
            //     return \App\Http\Responses\Responses::respondError('token required');
            // }
            $user = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();
            unset($user->password);
            unset($user->active_code);

            if ($user->type == 1) {
            	$url = 'http://94.206.36.74/filerun/wl/?id=hZ4OCP4YuRQRDaAYKMBZnvowBXcid7kI';
            }else
            	$url = 'http://94.206.36.74/filerun/wl/?id=IGhS98Hot6BuqO9UGh7h4ubrskcehrEb';

            $data = array(
                'user' => $user,
                'android-version' => '1',
                'ios-version' => '1',
                'google-url' => $url,
                'appstore-url' => 'https://www.apple.com',
            );

            return \App\Http\Responses\Responses::respondSuccess($data);

        });

Route::group(['middleware' => ['jwt.auth']], function() {

    // Customer area
    Route::post('/OnlineTrucks','Api\OrderController@online');
    Route::post('/order','Api\OrderController@order'); //user order for this
    Route::post('/myOrders','Api\OrderController@myOrders'); //user orders 
    Route::post('/ratingOrder','Api\OrderController@rating');
    Route::post('/getOrderById','Api\OrderController@getOrderById');
    Route::post('/cancelOrder','Api\OrderController@cancelOrder');
    // Common routes
    Route::post('logout', 'AuthController@logout');
    Route::post('/payment_type','Api\OrderController@Payment_type');


    // Driver area
    Route::post('/checkIn','Api\DriverController@online');
    Route::post('/checkOut','Api\DriverController@offline');
    Route::post('/getOrder','Api\DriverController@getOrder');
    Route::post('/acceptOrder','Api\DriverController@accept');
    Route::post('/rejectOrder','Api\DriverController@reject');
    Route::post('/arrivedOrder','Api\DriverController@arrived');
    Route::post('/doneOrder','Api\DriverController@done');
    Route::post('/updateStatus','Api\DriverController@updateStatus');
    Route::post('/driverOrders','Api\DriverController@driver_orders'); //driver orders

    Route::post('/company','Api\CompanyController@terms');

    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
});

Route::group(['namespace' => 'Api'], function(){

	//supplier area
	Route::post('/suppliers','SupplierController@index'); // return all suppliers
	Route::post('/supplier','SupplierController@show');  // return supplier by id
	Route::post('/supplierTrucks','SupplierController@trucks');  // return supplier trucks by supplier id (which is online)
	Route::post('/supplier/search','SupplierController@search'); // return suppliers by search values

    //Truck area
    Route::post('/trucks','TruckController@index'); // return all trucks
    Route::post('/truck','TruckController@show');  // return truck by id
    Route::post('/truckSupplier','TruckController@supplier');  // return truck supplier by supplier id (which is activated)
    Route::post('/truck/search','TruckController@search'); // return trucks by search values

    //Driver area
    Route::post('/drivers','DriverController@index'); // return all drivers
    Route::post('/driver','DriverController@show');  // return driver by id
    Route::post('/driverTruck','DriverController@truck');  // return driver truck by driver id (which is activated)
    Route::post('/driver/search','DriverController@search'); // return drivers by search values

});
