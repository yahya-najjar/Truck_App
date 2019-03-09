<?php 

Route::get('/','DashboardController@index');

Route::resource('/users','UserController');
Route::resource('/suppliers','SupplierController');
Route::resource('/trucks','TruckController');
Route::resource('/roles','RoleController');
Route::resource('/bills','BillController');
Route::resource('/orders','OrderController');
Route::resource('company','CompanyController');
Route::resource('customers','CustomerController');

Route::get('/location/{truck}','TruckController@location');
Route::get('/shifts/{truck}','TruckController@shifts');


Route::get('admins/','UserController@admins');
// Route::delete('admins/{admin}','UserController@destroy');

Route::get('drivers/','UserController@drivers');
Route::post('drivers/shift/','UserController@addShift');
Route::post('drivers/shift/delete','UserController@deleteShift');
Route::post('drivers/shift/update','UserController@updateShift');
Route::get('/drivers/get_driver_working_hours/{id}','TruckController@get_truck_shifts');

// Customers
// Route::get('customers/','CustomerController@customers');
Route::get('customers_drivers/','CustomerController@drivers');
Route::post('/all_customers', 'CustomerController@all_customers')->name('allcustomers');
Route::post('/all_drivers', 'CustomerController@all_drivers')->name('alldrivers');
Route::post('/all_orders', 'OrderController@orders')->name('allorders');


// Route::delete('users/{user}','UserController@destroy');
Route::post('users/store','UserController@store');

Route::get('suppliers_users/','UserController@suppliers');
Route::get('/onlineTrucks','TruckController@online');
Route::post('/get_online_trucks','TruckController@online_trucks');
Route::get('/ajaxLocations', 'TruckController@locations');
Route::get('/truck/{truck}','TruckController@orders');

Route::get('/ratings/{star?}', 'RatingController@showRatings');
Route::post('/driversRatings', 'RatingController@ratings')->name('allratings');
Route::get('/allTrucks/{status?}', 'TruckController@allTrucks');
Route::get('/like/users', 'UserController@like');


// FCM Custom Notification
Route::get('fcm_custom_notes/create', 'FCMCustomNotificationController@sendForm');
Route::post('fcm_custom_notes/send', 'FCMCustomNotificationController@sendPost');
Route::get('customersJson/search', 'FCMCustomNotificationController@getCustomers');



