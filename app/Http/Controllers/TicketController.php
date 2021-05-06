<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketTransaction;
use Illuminate\Http\Request;
use Response;

class TicketController extends Controller
{
    public function showTicketBalance($player_id) {
        $ticket = Ticket::where([
            ['player_id', $player_id]
        ])->first();

        return Response::json(
            [
                'ticket' => $ticket
            ],
            200
        );
    }

    public function addTicket(Request $request) {
        $ticket = Ticket::updateOrCreate(
            ['player_id'  =>  $request->player_id],
            [
                'ticket_balance' => $request->ticket_balance,
                'last_update' => '2021-05-15'
            ]
        );

        $ticket_transaction = new TicketTransaction([
            'ticket_id' => $ticket->ticket_id,
            'description' => $request->description,
            'date' => '2021-05-15 23:59'
        ]);
        $ticket_transaction->save();


        return Response::json(
            [
                'ticket' => $ticket
            ],
            200
        );
    }
}
