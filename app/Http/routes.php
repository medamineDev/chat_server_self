<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');


Route::get('chat', 'SocketController@writemessage');


Route::get('home', 'HomeController@index');


Route::get('socket', 'SocketController@index');


Route::post('sendmessage', 'SocketController@sendMessage');


Route::get('get_logged_user', 'HomeController@get_logged_user');


Route::post('register_api', 'HomeController@register_api');


Route::post('login_api', 'HomeController@login_api');


Route::post('registred_phones_api', 'HomeController@registered_phones_api');



Route::post('send_msg_api', 'HomeController@send_msg_api');


Route::post('get_msgs_api', 'HomeController@get_msgs_api');







/*Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/
