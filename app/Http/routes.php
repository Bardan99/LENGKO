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

Route::post('/dashboard/create/device', 'DeviceController@create');
Route::post('/dashboard/search/device', 'DeviceController@search');
Route::get('/dashboard/retrieve/device', 'DeviceController@retrieve');

Route::post('/dashboard/create/employee', 'EmployeeController@create');
Route::post('/dashboard/search/employee', 'EmployeeController@search');
Route::get('/dashboard/retrieve/employee', 'EmployeeController@retrieve');

Route::get('/dashboard/retrieve/{param}/', 'DashboardController@retrieve');
Route::put('/dashboard/update/{param}/', 'DashboardController@update');
Route::delete('/dashboard/delete/{param}/{id}', 'DashboardController@delete');

Route::get('/dashboard/update/{param}/', function() {
  return redirect('dashboard');
});


Route::get('/ajax/object/{param}', 'HomeController@ajax_handler');
//Route::post('/ajax/object/field/menu/bahan-baku', 'HomeController@ajax_handler');

//Route::group(['middleware' => 'auth'], function() {

//});

Route::get('/dashboard/', 'DashboardController@index');
Route::get('/dashboard/{param}/', 'DashboardController@view');


Route::get('/', 'HomeController@index');
Route::get('/{param}/', 'HomeController@view');
