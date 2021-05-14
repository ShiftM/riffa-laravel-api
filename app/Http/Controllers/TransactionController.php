<?php

namespace App\Http\Controllers;

use App\Models\Coins;
use App\Models\Player;
use App\Models\Ticket;
use App\Models\TicketTransaction;
use Illuminate\Http\Request;
use Response;

class TransactionController extends Controller
{
    public function showAllTransactions() {
        $transactions = TicketTransaction::all();

        foreach($transactions as $transac) {

            if(isset($transac->ticket_id)){
                $ticket = Ticket::where('ticket_id', $transac->ticket_id)-> first();
                $player = Player::where('player_id', $ticket->player_id)->first();
                $transac['user'] = $player->first_name . " " . $player->last_name;
            }

            if(isset($transac->coin_id)){
                $coin = Coins::where('coin_id', $transac->coin_id)-> first();
                $player = Player::where('player_id', $coin->player_id)->first();
                $transac['user'] = $player->first_name . " " . $player->last_name;
            }

        }

        return Response::json(
            [
                'transactions' => $transactions
            ],
            200
        );

    }
}
