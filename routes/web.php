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

Route::get('/','AdminController@login_page');
Route::get('/login','AdminController@login_page')->name('login_page');
Route::post('/login_action','AdminController@login')->name('login');
Route::get('/logout','AdminController@logout')->name('logout');

 
Route::POST('/createRowsFromDateRange','TimeController@createRowsFromDateRange')->name('createRowsFromDateRange');

Route::get('/dashboard','AdminController@dashboard')->name('dashboard');
Route::match(['GET','POST'],'/home','UserController@home')->name('home');

Route::get('/view_user_times','TimeController@view_user_times')->name('view_user_times');

Route::post('/getStats','AdminController@getStats')->name('getStats');

Route::post('/getListOfPharmacies','PharmacyController@getListOfPharmacies')->name('getListOfPharmacies');
Route::get('/editPharmacy','PharmacyController@editPharmacy')->name('editPharmacy');
Route::post('/updatePharmacy','PharmacyController@updatePharmacy')->name('updatePharmacy');
Route::post('/deletePharmacy','PharmacyController@deletePharmacy')->name('deletePharmacy');

Route::post('/getListOfUsers','UserController@getListOfUsers')->name('getListOfUsers');
Route::get('/editUser','UserController@editUser')->name('editUser');
Route::post('/updateUser','UserController@updateUser')->name('updateUser');
Route::post('/deleteUser','UserController@deleteUser')->name('deleteUser');

Route::post('/getListOfAdmins','AdminController@getListOfAdmins')->name('getListOfAdmins');
Route::get('/editAdmin','AdminController@editAdmin')->name('editAdmin');
Route::post('/updateAdmin','AdminController@updateAdmin')->name('updateAdmin');
Route::post('/deleteAdmin','AdminController@deleteAdmin')->name('deleteAdmin');

Route::post('/getListOfTimes','TimeController@getListOfTimes')->name('getListOfTimes');
Route::post('/editTime','TimeController@editTime')->name('editTime');
Route::post('/updateTime','TimeController@updateTime')->name('updateTime');
Route::post('/deleteTime','TimeController@deleteTime')->name('deleteTime');

Route::post('/getListOfRoles','RoleController@getListOfRoles')->name('getListOfRoles');
Route::get('/editRole','RoleController@editRole')->name('editRole');
Route::post('/updateRole','RoleController@updateRole')->name('updateRole');
Route::post('/deleteRole','RoleController@deleteRole')->name('deleteRole');

Route::resource('admins', 'AdminController');
Route::resource('users', 'UserController');
Route::resource('pharmacies', 'PharmacyController');
Route::resource('roles', 'RoleController');
Route::resource('times', 'TimeController');
