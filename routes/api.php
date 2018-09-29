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
Route::group(['middleware' => ['jwt.auth']], function() {
    Route::post('logout', 'AuthController@logout');
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

});
