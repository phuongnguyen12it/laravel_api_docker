<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('admin/user');
});
Route::namespace('Admin')->group(function(){
	Route::get('/login', 'LoginController@login')->name('admin-login');
	Route::post('/login', 'LoginController@store')->name('adin-login-store');

	//@todo midleware check login
	Route::group([
		'middleware' => 'admin-auth',
		'prefix' => 'admin'
	], function (){
		Route::get('home', 'HomeController@index')->name('admin-home');
		route::prefix('user')->group(function(){
			Route::get('', 'UserController@index')->name('list-user');
			Route::get('create', 'UserController@create')->name('user-create');
			Route::post('store', 'UserController@store')->name('user-store');
			Route::get('edit/{id}', 'UserController@edit')->name('user-edit');
			Route::post('update/{id}', 'UserController@update')->name('user-update');
			Route::get('delete/{id}', 'UserController@destroy')->name('user-delete');
		});
		Route::get('/logout', 'LoginController@logout')->name('admin-logout');
	});
});
