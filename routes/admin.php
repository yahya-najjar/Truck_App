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
Route::resource('company','CompanyController');

Route::get('/location/{truck}','TruckController@location');
Route::get('/shifts/{truck}','TruckController@shifts');


Route::get('admins/','UserController@admins');
// Route::delete('admins/{admin}','UserController@destroy');

Route::get('customers/','UserController@customers');
Route::get('drivers/','UserController@drivers');
Route::post('drivers/shift/','UserController@addShift');
Route::post('drivers/shift/delete','UserController@deleteShift');
Route::post('drivers/shift/update','UserController@updateShift');
Route::get('/drivers/get_driver_working_hours/{id}','TruckController@get_truck_shifts');

// Route::delete('users/{user}','UserController@destroy');
Route::post('users/store','UserController@store');

Route::get('suppliers_users/','UserController@suppliers');
Route::get('/onlineTrucks','TruckController@online');
Route::get('/truck/{truck}','TruckController@orders');

Route::get('/ratings/{star?}', 'RatingController@showRatings');
Route::post('/driversRatings', 'RatingController@ratings')->name('allratings');
Route::get('/allTrucks/{status?}', 'TruckController@allTrucks');
Route::get('/like/users', 'UserController@like');


// FCM Custom Notification
Route::get('fcm_custom_notes/create', 'FCMCustomNotificationController@sendForm');
Route::post('fcm_custom_notes/send', 'FCMCustomNotificationController@sendPost');
Route::get('customersJson/search', 'FCMCustomNotificationController@getCustomers');



