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
 

Route::resource('admins', 'AdminController');
Route::resource('users', 'UserController');
Route::resource('pharmacies', 'PharmacyController');
Route::resource('roles', 'RoleController');
Route::resource('times', 'TimeController');