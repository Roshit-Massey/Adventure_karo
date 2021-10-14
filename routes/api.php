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

/* ---------------------------------------------- Start Activity Section -----------------------------------------*/
Route::get('all-activities','API\ActivityController@index');
Route::post('add-activity','API\ActivityController@store');
Route::get('show-activity','API\ActivityController@show');
Route::patch('update-activity','API\ActivityController@update');
Route::delete('delete-activity','API\ActivityController@delete');
/* --------------------------------------------- End Activity Section --------------------------------------------*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
