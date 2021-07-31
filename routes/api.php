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

Route::post('login','Api\ApiAuthController@login');
Route::post('login/google','Api\ApiAuthController@loginGoogle');
Route::get('cek-auth','Api\ApiAuthController@cekAuth');

Route::get('get-profile', 'Api\ApiProfileController@getProfile');
Route::get('get-batik', 'Api\ApiBatikController@getBatik');
Route::get('get-batik-proses', 'Api\ApiBatikController@getBatikProses');