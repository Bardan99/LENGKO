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

Route::get('/ajax/object/{param}', 'HomeController@ajax_handler');
//Route::post('/ajax/object/field/menu/bahan-baku', 'HomeController@ajax_handler');

Route::group(['middleware' => 'auth'], function() {

});

Route::get('/dashboard/', 'DashboardController@index');
Route::get('/dashboard/{param}/', 'DashboardController@view');

Route::get('/', 'HomeController@index');
Route::get('/menu/', 'MenuController@view');
Route::get('/about/', 'AboutController@view');
Route::get('/login/', 'LoginController@view');
Route::get('/{param}/', 'HomeController@view');
