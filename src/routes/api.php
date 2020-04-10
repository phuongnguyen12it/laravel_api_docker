<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function(){
	Route::namespace('Api')->group(function(){

		Route::group(['middleware' => 'write-logs-api'], function(){
			
			Route::post('users/login', 'UserController@login');
			Route::group([
				'middleware' => 'auth.jwt',
				'prefix' =>'users'
			], function(){
				Route::get('', 'UserController@index');
				Route::get('logout', 'UserController@logout');
				Route::get('{id}', 'UserController@show');
				Route::post('create', 'UserController@store');
				Route::put('edit/{id}', 'UserController@update');
				Route::delete('delete/{id}', 'UserController@destroy');
			});
		});
	});
});

//Handle route not found when request to url no exist
Route::fallback(function(){
    return response()->json([
        'msg'	 	=> 'Page not found.',
        'code'		=> 404,
    ], 404);
});