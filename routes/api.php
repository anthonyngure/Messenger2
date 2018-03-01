<?php
	
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
	
	ob_start('ob_gzhandler');
	
	
	Route::group(['prefix' => 'v1', 'guard' => 'api'], function () {
		
		Route::get('/', function () {
			return response('Cube Messenger API Version 1');
		});
		
		Route::group(['prefix' => 'auth'], function () {
			Route::post('signIn', 'AuthController@signIn');
			Route::post('emailSignIn', 'AuthController@emailSignIn');
		});
		
		Route::group(['middleware' => 'auth:api'], function () {
			Route::resource('courierOptions', 'CourierOptionController');
			Route::post('auth/signOut', 'AuthController@signOut');
			Route::get('auth/refresh', 'AuthController@refresh');
			Route::get('auth/user', 'AuthController@user');
			Route::resource('deliveries', 'DeliveryController');
			Route::resource('subscriptions', 'SubscriptionController');
		});
		
	});


