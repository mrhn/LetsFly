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

Route::get('/people', 'PersonController@all');
Route::get('/teams/{id}', 'TeamController@get')->where('id', '[0-9]+');
Route::post('/teams', 'TeamController@create');
