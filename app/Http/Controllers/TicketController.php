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
        $ticket = Ticket::where('player_id', $request->player_id)->first();
        $ticket->update(
            [
                'ticket_balance' => $ticket->ticket_balance + $request->ticket_balance,
                'last_update' => time()
            ]
        );

        $ticket_transaction = new TicketTransaction([
            'ticket_id' => $ticket->ticket_id,
            // 'description' => $request->description . " (". $request->ticket_balance .")",
            'title' => $request->ticket_balance . " Tickets",
            'type' => "Ticket",
            'date' => time()
        ]);
        $ticket_transaction->save();


        return Response::json(
            [
                'ticket' => $ticket
            ],
            200
        );
    }

    public function subtractTicket(Request $request) {
        $ticket = Ticket::where('player_id', $request->player_id)->first();
        $ticket->update(
            [
                'ticket_balance' => $ticket->ticket_balance - $request->ticket_balance,
                'last_update' => time()
            ]
        );

        $ticket_transaction = new TicketTransaction([
            'ticket_id' => $ticket->ticket_id,
            'title' => "- " . $request->ticket_balance . " Tickets",
            'type' => "Ticket",
            'date' => time()
        ]);
        $ticket_transaction->save();


        return Response::json(
            [
                'ticket' => $ticket
            ],
            200
        );
    }

    public function enterRaffle($player_id) {
        $ticket = Ticket::where('player_id', $player_id)->first();
        if($ticket->ticket_balance != 0){
            $ticket->update(
                [
                    'ticket_balance' => $ticket->ticket_balance - 1,
                    'last_update' => time()
                ]
            );

            $ticket_transaction = new TicketTransaction([
                'ticket_id' => $ticket->ticket_id,
                'title' => 'Raffle Entry',
                'type'  => 'Ticket',
                'date'  => time()
            ]);
            $ticket_transaction->save();


            return 'Deducted';
        } else {
            return 'Insufficient Ticket';
        }
    }
}
