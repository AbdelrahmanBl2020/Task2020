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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*     Start Users Controller     */
Route::post('login','usersController@login');
Route::post('chkOTP','usersController@chkOTP');
Route::post('setName','usersController@setName');
/*     End Users Controller     */
