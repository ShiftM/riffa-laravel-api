<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function() {

    //<--------PLAYER CONTROLLER-------->
    Route::post('/register/player',     'PlayerController@registerPlayer');
    Route::post('/login',               'PlayerController@login');
    Route::post('/update/info',         'PlayerController@updatePlayerInfo')->middleware('auth:sanctum');

    //<--------RAFFLES CONTROLLER-------->
    Route::get('raffles/schedule/{id}',     'RafflesController@showRaffleInfo');

});
