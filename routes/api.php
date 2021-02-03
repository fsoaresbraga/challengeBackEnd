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

Route::apiResource('users','Api\UserController');
Route::post('user/balance/{id}','Api\UserController@newBalance');
Route::get('user/balanceMovements/{id}','Api\UserController@balanceWithMovements');

Route::apiResource('movements','Api\MovementController');
Route::delete('movements/{idUser}/{idMovement}','Api\MovementController@destroy');
Route::get('movements/user/{userId}/export/{filter?}','Api\MovementController@export');