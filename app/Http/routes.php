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

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('/menu/', 'MenuController@view');
Route::get('/about/', 'AboutController@view');
Route::get('/login/', 'LoginController@view');
Route::get('/{param}/', 'HomeController@view');
