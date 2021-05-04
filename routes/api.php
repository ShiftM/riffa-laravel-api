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
    Route::post('/register/player',         'PlayerController@registerPlayer');
    Route::post('/login',                   'PlayerController@login');
    Route::post('/update/info',             'PlayerController@updatePlayerInfo')->middleware('auth:sanctum');

    //<--------COINS - PLAYER CONTROLLER-------->
    Route::get('/coins/{id}',               'PlayerController@showCoinBalance');

    //<--------RAFFLES CONTROLLER-------->
    Route::get('/all/raffles',              'RafflesController@showAllRaffles');
    Route::get('/raffles/info/{raffle_id}', 'RafflesController@showRaffleInfo');
    Route::get('/raffles/taken/{raffle_id}','RafflesController@showTakenSlots');
    Route::post('/take/raffle/',            'RafflesController@saveSelectedSlot');
    Route::post('/end/raffle/',             'RafflesController@endRaffle');
    Route::post('/add/raffle',              'RafflesController@insertRaffleInfo');

    //<--------PRIZES CONTROLLER-------->
    Route::get('/all/prizes',               'PrizeController@showAllPrizes');

});
