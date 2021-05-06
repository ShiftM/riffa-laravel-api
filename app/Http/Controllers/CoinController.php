<?php

namespace App\Http\Controllers;

use App\Models\Coins;
use Illuminate\Http\Request;
use Response;

class CoinController extends Controller
{
    public function showCoinBalance($player_id) {
        $coins = Coins::where([
            ['player_id', $player_id]
        ])->first();

        return Response::json(
            [
                'coins' => $coins
            ],
            200
        );
    }
}
