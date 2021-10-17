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

//------------------------------------ Start For Admin(v1) Routes -------------------------------------//
Route::get('/v1/dashboard', function () {
    return view('secondary.dashboard.index');
});

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


//------------------------------------ End For Admin(v1) Routes -------------------------------------//

//------------------------------------ Start For Vendor(v2) Routes -------------------------------------//
Route::get('/v2/dashboard', function () {
    return view('secondary.dashboard.index');
});
//------------------------------------ End For Vendor(v2) Routes -------------------------------------//