<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Admin Area
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    require_once base_path('routes/admin.php');
});



Route::get('user/verify/{verification_code}', 'AuthController@verifyUser');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');


Route::get('img/{path}', 'ImageController@show')->where('path', '.*');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

use App\Models\Truck;
Route::get('/test',function(){
        $driver_id = 11;
        $shifts = DB::table('customer_truck')
                ->join('trucks', function ($join) use ($driver_id) {
                    $join->on('customer_truck.truck_id', '=', 'trucks.id')
                         ->where('customer_truck.customer_id', '=', $driver_id);
                })
                ->select('trucks.*')->pluck('id')
           ;  

           return $shifts;
});

Route::get('download',function(){
    return Response::download(public_path() .'/assets/TruckUp.apk','TruckUp.apk');
})->name('downloadApp');