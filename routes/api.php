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
    Route::post('/register/player',             'PlayerController@registerPlayer');
    Route::post('/login',                       'PlayerController@login');
    Route::post('/update/info',                 'PlayerController@updatePlayerInfo')->middleware('auth:sanctum');
    Route::get('/all/players',                  'PlayerController@showAllPlayers');
    Route::get('/player/{player_id}',           'PlayerController@showPlayerInfo');

    //<--------TICKET CONTROLLER-------->
    Route::get('/balance/ticket/{player_id}',   'TIcketController@showTicketBalance');
    Route::post('/add/ticket/',                 'TIcketController@addTicket');
    Route::post('/subtract/ticket/',            'TIcketController@subtractTicket');

    //<--------COIN CONTROLLER-------->
    Route::get('/balance/coins/{player_id}',    'CoinController@showCoinBalance');

    //<--------RAFFLES CONTROLLER-------->
    Route::get('/all/raffles',                  'RafflesController@showAllRaffles');
    Route::get('/raffles/info/{raffle_id}',     'RafflesController@showRaffleInfo');
    Route::get('/raffles/taken/{raffle_id}',    'RafflesController@showTakenSlots');

    Route::post('/take/raffle/',                'RafflesController@saveSelectedSlot');
    Route::post('/start/raffle/',               'RafflesController@startRaffle');
    Route::post('/end/raffle/',                 'RafflesController@endRaffle');
    Route::post('/add/raffle',                  'RafflesController@insertRaffleInfo');
    Route::post('/edit/raffle',                 'RafflesController@editRaffleInfo');

    //<--------PRIZES CONTROLLER-------->
    Route::get('/all/prizes',                   'PrizeController@showAllPrizes');
    Route::post('/add/prize',                   'PrizeController@newPrize');
    Route::post('/edit/prize',                  'PrizeController@editPrize');
    Route::post('/remove/prize',                'PrizeController@removePrize');

    //<--------TRANSACTION CONTROLLER-------->
    Route::get('/all/transactions',             'TransactionController@showAllTransactions');

});
