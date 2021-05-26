<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ImageController;
use App\Models\Coins;
use App\Models\Player;
use App\Models\Raffles;
use App\Models\RaffleSlots;
use App\Models\Ticket;
use App\Models\TicketTransaction;
use Response;
use Auth;
use Config;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function __construct() {
        $this->image = new ImageController();
        $this->ticket = new Ticket();
        $this->coins = new Coins();
    }

    public function allUsers() {

        $users = Player::with('ticket')->get();

        for($i = 0; $i < count($users); $i++) {
            if($users[$i]->profile != null) {
                $users[$i]['profile'] = Config::get('constants.RIFFA_S3_URL.PROFILE').$users[$i]['profile'];
            }
        }
        return Response::json(
            [
                'users' => $users
            ],
            200
        );
    }

    public function login(Request $request) {
        $token = '';
        $player = Player::where([
            ['email', $request->email],
        ])->with('coin','ticket', 'slots')->first();

        if(Hash::check($request->password, $player->password)) {
            if($player != null) {
                $player['profile'] = Config::get('constants.RIFFA_S3_URL.PROFILE').$player['profile'];
                $token = $player->createToken('player')->plainTextToken;
            }
        } else {
            $player = null;
            $token  = null;
        }

        return Response::json(
            [
                'player' => $player,
                'token'  => $token,
            ],
            200
        );
    }

    public function registerPlayer(Request $request) {
        $player = new Player([
            'first_name'    => $request->firstname,
            'last_name'     => $request->lastname,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => Config::get('constants.ROLE.USER'),
            'profile'       => Config::get('constants.ASSET_IMAGE.NO_IMG_DEFAULT'),
            'created_at'    => time()
        ]);
        $player->save();

        $this->newPlayer($player->player_id);

        return Response::json(
            [
                'player' => $player
            ],
            200
        );
    }

    public function updatePlayerInfo(Request $request) {
        $info = $request->all();
        $player = Player::find($info['playerId']);
        $player->update([
            'first_name'        => $info['firstname'],
            'last_name'         => $info['lastname'],
            'middle_initial'    => $info['middleinitial'],
            'email'             => $info['email'],
            'profile'           => $info['profile'] != null ? (strpos($info['profile'], 'aws') ? (str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['profile']) == $player['profile'] ? str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['profile']) : $this->image->uploadImage($info['profile'])) : "" ) : "",
            'address_type'      => $info['address_type'],
            'phone_number'      => $info['phone'],
            'address'           => $info['address'],
            'birthdate'         => $info['birthdate'],
            'updated_at'        => time()
        ]);
        if($info['profile'] != null) {
            $player['profile'] = Config::get('constants.RIFFA_S3_URL.PROFILE').$player['profile'];
        }
        return Response::json(
            [
                'player' => $player
            ],
            200
        );
    }

    public function newPlayer($player_id) {

        $ticket = new Ticket([
            'player_id'         => $player_id,
            'ticket_balance'    => 0,
            'last_update'       => time()
        ]);
        $ticket->save();

        $coins = new Coins([
            'player_id'         => $player_id,
            'coin_balance'    => 0,
            'last_update'       => time()
        ]);
        $coins->save();

    }

    public function showAllPlayers() {
        $players = Player::all();
        $total_ticket_spent = 0;

        foreach($players as $player) {

            $raffle_entry = RaffleSlots::where('player_id', $player->player_id)
            ->first(DB::raw("COUNT(player_id) as player_id"));
            $player['raffle_entry'] = $raffle_entry->player_id;

            // $ticket_id = Ticket::where('player_id', $player->player_id)->first();
            // $ticket_spent = TicketTransaction::where('ticket_id', $ticket_id->ticket_id)->get();
            // foreach($ticket_spent as $ticket){

            //     $player['raffle_entry'] = $raffle_entry->player_id;

            // }

        }

        return Response::json(
            [
                'players' => $players
            ],
            200
        );
    }

    public function showPlayerInfo($player_id) {
        $raffle_list = array();

        $player = Player::where('player_id', $player_id)->first();

        $ticket = Ticket::where('player_id', $player_id)->first();
        $player['ticket_balance'] = $ticket->ticket_balance;

        $raffles_participated = RaffleSlots::where('player_id', $player_id)
        ->orderBy('raffle_id', 'desc')
        ->limit(5)
        ->get(DB::raw("DISTINCT(raffle_id)"));

        foreach($raffles_participated as $entry) {
            $raffle = Raffles::where('raffle_id', $entry->raffle_id)->first();
            array_push($raffle_list, $raffle);
        }
        $player['recent_raffles'] = $raffle_list;

        return Response::json(
            [
                'player' => $player
            ],
            200
        );

    }

}
