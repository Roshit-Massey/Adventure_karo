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
Route::post('login','Auth\LoginController@index');
Route::get('logout', 'Auth\LoginController@logout');
/* ---------------------------------------------- End Login and Logout Section --------------------------------------*/

/* ------------------------------ Start Countries, State and Cities Section Routes -----------------------------------*/
Route::get('countries','V1\CountryStateCityController@index');
Route::get('states','V1\CountryStateCityController@states');
Route::get('cities','V1\CountryStateCityController@cities');
/* ------------------------------------ End Countries, State and Cities Section Routes -------------------------------*/



/* ============================================ Start Admin(V1) Section Routes ==========================================*/

/* ---------------------------------------------- Start Activity Section -----------------------------------------*/
Route::get('all-activities','V1\ActivityController@index');
Route::post('add-activity','V1\ActivityController@store');
Route::get('show-activity','V1\ActivityController@show');
Route::post('update-activity','V1\ActivityController@update');
Route::delete('delete-activity','V1\ActivityController@delete');
Route::delete('delete-activity-image','V1\ActivityController@deleteImage');
/* --------------------------------------------- End Activity Section --------------------------------------------*/

/* ---------------------------------------------- Start Experience Section -----------------------------------------*/
Route::get('all-experiences','V1\ExperienceController@index');
Route::post('add-experience','V1\ExperienceController@store');
Route::get('show-experience','V1\ExperienceController@show');
Route::post('update-experience','V1\ExperienceController@update');
Route::delete('delete-experience','V1\ExperienceController@delete');
Route::delete('delete-experience-image','V1\ExperienceController@deleteImage');
/* --------------------------------------------- End Experience Section --------------------------------------------*/

/* ---------------------------------------------- Start Inclusive Section -----------------------------------------*/
Route::get('all-inclusives','V1\InclusiveExclusiveController@index');
Route::post('add-inclusive','V1\InclusiveExclusiveController@store');
Route::get('show-inclusive','V1\InclusiveExclusiveController@show');
Route::patch('update-inclusive','V1\InclusiveExclusiveController@update');
Route::delete('delete-inclusive','V1\InclusiveExclusiveController@delete');
/* --------------------------------------------- End Inclusive Section --------------------------------------------*/

/* ---------------------------------------------- Start Exclusive Section -----------------------------------------*/
Route::get('all-exclusives','V1\InclusiveExclusiveController@list');
Route::post('add-exclusive','V1\InclusiveExclusiveController@save');
Route::get('show-exclusive','V1\InclusiveExclusiveController@get');
Route::patch('update-exclusive','V1\InclusiveExclusiveController@updateOne');
Route::delete('delete-exclusive','V1\InclusiveExclusiveController@deleteOne');
/* --------------------------------------------- End Exclusive Section --------------------------------------------*/

/* ---------------------------------------------- Start Exclusive Section -----------------------------------------*/
Route::get('all-vendors','V1\VendorController@index');
Route::post('add-vendor','V1\VendorController@store');
Route::get('show-vendor','V1\VendorController@show');
Route::post('update-vendor','V1\VendorController@update');
Route::delete('delete-vendor','V1\VendorController@delete');
Route::get('verify-vendor','V1\VendorController@verify');
Route::post('add-company-vendor','V1\VendorController@insert');
Route::post('update-company-vendor','V1\VendorController@updateOne');
/* --------------------------------------------- End Exclusive Section --------------------------------------------*/

/* ============================================ End Admin(V1) Section Routes ==========================================*/






/* ============================================ Start Vendor(V2) Section Routes ==========================================*/

/* ---------------------------------------------- Start Activity Section -----------------------------------------*/
Route::get('v-all-activities','V2\ActivityController@index');
Route::post('v-add-activity','V2\ActivityController@store');
Route::get('v-show-activity','V2\ActivityController@show');
Route::post('v-update-activity','V2\ActivityController@update');
Route::delete('v-delete-activity','V2\ActivityController@delete');
Route::delete('v-delete-activity-image','V2\ActivityController@deleteImage');
/* --------------------------------------------- End Activity Section --------------------------------------------*/

/* ============================================ End Vendor(V2) Section Routes ==========================================*/
// Route::group([    
//     'prefix' => 'v',
//     'middleware' => 'auth:api',
// ], function () {
// 	Route::group([
//     ], function() {
//     });
// });
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
