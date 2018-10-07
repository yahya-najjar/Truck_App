<?php 

Route::get('/', function(){
	return view('admin.dashboard');
});

Route::resource('/users','UserController');
Route::resource('/suppliers','SupplierController');
Route::resource('/trucks','TruckController');
Route::resource('/roles','RoleController');
Route::resource('/bills','BillController');
Route::resource('/orders','OrderController');



Route::get('admins/','UserController@admins');
// Route::delete('admins/{admin}','UserController@destroy');

Route::get('customers/','UserController@customers');
// Route::delete('users/{user}','UserController@destroy');
Route::post('users/store','UserController@store');

Route::get('suppliers_users/','UserController@suppliers');
Route::get('/onlineTrucks','TruckController@online');
Route::get('/truck/{truck}','TruckController@orders');

Route::get('/ratings/{star?}', 'RatingController@showRatings');
Route::post('/driversRatings', 'RatingController@ratings')->name('allratings');



