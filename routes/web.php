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

 
Route::POST('/createRowsFromDateRange','TimeController@createRowsFromDateRange')->name('createRowsFromDateRange');

Route::get('/dashboard','AdminController@dashboard')->name('dashboard');
Route::get('/home','UserController@home')->name('home');

Route::resource('admins', 'AdminController');
Route::resource('users', 'UserController');
Route::resource('pharmacies', 'PharmacyController');
Route::resource('roles', 'RoleController');
Route::resource('times', 'TimeController');
