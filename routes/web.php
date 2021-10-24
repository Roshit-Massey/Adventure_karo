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

//------------------------------------ Start For Website Routes -------------------------------------//
Route::get('/', function () {
    return view('primary.welcome');
});
//------------------------------------ End For Website Routes ---------------------------------------//

//------------------------------------ Start For Only Admin Routes -------------------------------------//
Route::group(['middleware'=>['CheckLogin']],function (){ 
    Route::get('/auth/login', function () {
        return view('secondary.index');
    });
});

Route::group(['middleware'=>['web', 'CheckAdmin']],function (){ 
    
    Route::get('/v1/activities', function () {
        return view('secondary.activity.index');
    });

    Route::get('/v1/activity/{id}', 'WebController@index');

    Route::get('/v1/inclusives', function () {
        return view('secondary.inclusive.index');
    });

    Route::get('/v1/exclusives', function () {
        return view('secondary.exclusive.index');
    });

    Route::get('/v1/experiences', function () {
        return view('secondary.experience.index');
    });

    Route::get('/v1/experience/{id}', 'WebController@experience');

    Route::get('/v1/vendors', function () {
        return view('secondary.vendor.index');
    });

    Route::get('/v1/vendor/{id}', 'WebController@vendor');

});
//------------------------------------ End For Only Admin Routes -------------------------------------//

//------------------------------------ Start For Only Vendor Routes -------------------------------------//
Route::group(['middleware'=>['CheckVendor']],function (){ 
   
});
//------------------------------------ End For Only Vendor Routes -------------------------------------//

//------------------------------------ Start For Both Admin and Vendor Routes -------------------------------------//
Route::group(['middleware'=>['CheckAdminVendor']],function (){ 
    Route::get('/v1', function () {
        return view('secondary.dashboard.index');
    });
});
//------------------------------------ End For Both Admin and Vendor Routes -------------------------------------//
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
