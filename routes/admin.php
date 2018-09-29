<?php 

Route::get('/', function(){
	return view('admin.dashboard');
});

Route::resource('/users','UserController');
Route::resource('/suppliers','SupplierController');
Route::resource('/trucks','TruckController');
Route::resource('/suppliers','SupplierController');
Route::resource('/roles','RoleController');
Route::resource('/bills','BillController');



Route::get('admins/','UserController@admins');
Route::delete('admins/{admin}','UserController@destroy');

Route::get('customers/','UserController@customers');
Route::delete('users/{user}','UserController@destroy');
Route::post('users/store','UserController@store');

Route::get('suppliers_users/','UserController@suppliers');
Route::get('/onlineTrucks','TruckController@online');



