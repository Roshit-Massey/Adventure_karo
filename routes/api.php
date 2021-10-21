<?php

use Illuminate\Http\Request;

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

/* ---------------------------------------------- Start Login and Logout Section ------------------------------------*/
Route::group([
    'prefix' => 'auth'
], function () {
    Route::group([
        'middleware' => 'auth:api'
    ], function() {
    });
});
Route::post('login','Auth\LoginController@index');
Route::get('logout', 'Auth\LoginController@logout');
/* ---------------------------------------------- End Login and Logout Section --------------------------------------*/

/* ---------------------------------------------- Start Activity Section -----------------------------------------*/
Route::get('countries','API\CountryStateCityController@index');
Route::get('states','API\CountryStateCityController@states');
Route::get('cities','API\CountryStateCityController@cities');

/* --------------------------------------------- End Activity Section --------------------------------------------*/

/* ---------------------------------------------- Start Activity Section -----------------------------------------*/
Route::get('all-activities','API\ActivityController@index');
Route::post('add-activity','API\ActivityController@store');
Route::get('show-activity','API\ActivityController@show');
Route::post('update-activity','API\ActivityController@update');
Route::delete('delete-activity','API\ActivityController@delete');
/* --------------------------------------------- End Activity Section --------------------------------------------*/

/* ---------------------------------------------- Start Experience Section -----------------------------------------*/
Route::get('all-experiences','API\ExperienceController@index');
Route::post('add-experience','API\ExperienceController@store');
Route::get('show-experience','API\ExperienceController@show');
Route::post('update-experience','API\ExperienceController@update');
Route::delete('delete-experience','API\ExperienceController@delete');
/* --------------------------------------------- End Experience Section --------------------------------------------*/

/* ---------------------------------------------- Start Inclusive Section -----------------------------------------*/
Route::get('all-inclusives','API\InclusiveExclusiveController@index');
Route::post('add-inclusive','API\InclusiveExclusiveController@store');
Route::get('show-inclusive','API\InclusiveExclusiveController@show');
Route::patch('update-inclusive','API\InclusiveExclusiveController@update');
Route::delete('delete-inclusive','API\InclusiveExclusiveController@delete');
/* --------------------------------------------- End Inclusive Section --------------------------------------------*/

/* ---------------------------------------------- Start Exclusive Section -----------------------------------------*/
Route::get('all-exclusives','API\InclusiveExclusiveController@list');
Route::post('add-exclusive','API\InclusiveExclusiveController@save');
Route::get('show-exclusive','API\InclusiveExclusiveController@get');
Route::patch('update-exclusive','API\InclusiveExclusiveController@updateOne');
Route::delete('delete-exclusive','API\InclusiveExclusiveController@deleteOne');
/* --------------------------------------------- End Exclusive Section --------------------------------------------*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
