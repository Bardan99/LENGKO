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

/* authentication */
Route::auth();

// Admin login
Route::group(['prefix' => 'dashboard'], function() {
  Route::get('login', 'Auth\EmployeeLoginController@showLoginForm')->name('employee.login');
  Route::post('login', 'Auth\EmployeeLoginController@login')->name('employee.login.submit');
});

Route::group(['prefix' => ''], function() {
  Route::get('login', 'Auth\DeviceLoginController@showLoginForm')->name('device.login');
  Route::post('login', 'Auth\DeviceLoginController@login')->name('device.login.submit');

  Route::get('register', function() {
    return redirect('/');
  });
  Route::get('register/{any}', function() {
    return redirect('/');
  });

  Route::get('password', function() {
    return redirect('/');
  });

  Route::get('password/{any}', function() {
    return redirect('/');
  });
});

//multi-view both employee and device; this is dangerous (for topsecret dataa)
Route::get('/dashboard/retrieve/review', 'ReviewController@retrieve');

Route::group(['middleware' => 'employee'], function() {

  Route::group(['prefix' => 'dashboard'], function() {
    Route::get('/', 'DashboardController@index');
    Route::get('/logout', 'Auth\EmployeeLoginController@logout');
    Route::get('/{param}', 'DashboardController@view');
    Route::get('/material/change/{id}', 'MaterialController@changematerial');

    Route::post('/create/device', 'DeviceController@create');
    Route::post('/search/device', 'DeviceController@search');
    Route::get('/retrieve/device', 'DeviceController@retrieve');

    Route::post('/create/employee', 'EmployeeController@create');
    Route::post('/search/employee', 'EmployeeController@search');
    Route::get('/retrieve/employee', 'EmployeeController@retrieve');

    Route::post('/create/request', 'PengadaanController@createrequest');
    Route::post('/search/materialrequest', 'PengadaanController@searchrequest');

    Route::post('/create/materialrequest', 'PengadaanController@acceptrequest');
    Route::post('/decline/material', 'PengadaanController@declinerequest');

    Route::post('/create/material', 'MaterialController@create');
    Route::post('/search/material', 'MaterialController@search');
    Route::get('/retrieve/material', 'MaterialController@retrieve');

    Route::post('/create/menu', 'MenuController@create');
    Route::post('/search/menu', 'MenuController@search');
    Route::post('/search/materialmenu', 'MenuController@searchmaterial');

    Route::post('/confirm/order', 'OrderController@confirm');
    Route::post('/search/order', 'OrderController@search');

    Route::get('/update/order/{id}', 'OrderController@marked');
    Route::get('/update/ordermenu/{id}', 'OrderController@checked');
    Route::get('/update/transaction/{id}/{cash}', 'TransactionController@marked');
    Route::post('/search/transaction', 'TransactionController@search');
    Route::post('/search/transactionhistory', 'TransactionController@searchhistory');
    Route::get('/transaction/report/{id}', 'TransactionController@report');
    Route::get('/transaction/report', function() {
      return redirect('dashboard/transaction');
    });

    Route::get('/retrieve/income', 'ReportController@income');
    Route::post('/retrieve/report', 'ReportController@report');
    Route::get('/report/income/date/{start}/{end}', 'ReportController@incomereportdate');
    Route::get('/report/income/{type}', 'ReportController@incomereport');

    Route::post('/create/review', 'ReviewController@create');
    Route::post('/search/review', 'ReviewController@search');
    Route::get('/update/review/{id}', 'ReviewController@status');

    Route::put('/update/{param}/', 'DashboardController@update');
    Route::delete('/delete/{param}/{id}', 'DashboardController@delete');

    Route::post('/filter/device', 'DashboardController@filterdevice');

    Route::get('/generate/material/textbox', 'MaterialController@generate_textbox');

    Route::post('/get/notification', 'DashboardController@getnotification');
    Route::post('/refresh/confirmationorder', 'OrderController@refreshconfirmationorder');
    Route::post('/refresh/queueorder', 'OrderController@refreshqueueorder');
    Route::post('/refresh/transaction', 'TransactionController@refreshtransaction');
  });
});

Route::group(['middleware' => 'device'], function() {
  Route::get('/', 'HomeController@index');
  Route::get('/logout', 'Auth\DeviceLoginController@logout');
  Route::post('/logout/verification', 'Auth\DeviceLoginController@logoutverification');
  Route::get('/{param}', 'HomeController@view');

  Route::group(['prefix' => 'customer'], function() {
    Route::post('/search/menu', 'HomeController@searchmenu');
    Route::post('/page/menu', 'HomeController@pagemenu');
    Route::post('/create/review', 'HomeController@createreview');
    Route::post('/add/menu', 'HomeController@addmenu');
    Route::post('/remove/menu', 'HomeController@removemenu');
    Route::post('/change/menu', 'HomeController@changemenu');
    Route::post('/create/order', 'HomeController@createorder');
    Route::post('/filter/menu', 'HomeController@filtermenu');

    Route::post('/notif/help', 'HomeController@notifhelp');
    Route::post('/notif/order', 'HomeController@notiforder');
    Route::post('/notif/transaction', 'HomeController@notiftransaction');

    Route::post('/get/notification', 'HomeController@getnotification');
    Route::post('/refresh/order', 'HomeController@refreshorder');
  });

});

/*
Route::get('/secret/clearcache', function() {
    $exitCode = Artisan::call('cache:clear');
});

Route::get('/secret/routecache', function() {
    $exitCode = Artisan::call('route:cache');
});

Route::get('/secret/generatekey', function() {
    $exitCode = Artisan::call('key:generate');
});
*/
