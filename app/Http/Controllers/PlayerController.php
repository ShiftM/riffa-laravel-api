<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Player;
use Response;
use Auth;
use Config;
class PlayerController extends Controller
{
    public function login(Request $request) {
        $token = '';
        $player = Player::where([
            ['email', $request->email],
            ['password', $request->password]
        ])->first();
        
        if($player != null) {
            $token = $player->createToken('player')->plainTextToken;
        }
        return Response::json(
            [
                'player' => $player,
                'token'  => $token
            ],
            200
        );
    }

    public function registerPlayer(Request $request) {
        $player = new Player([
            'first_name'    => $request->firstname,
            'last_name'     => $request->lastname,
            'email'         => $request->email,
            'password'      => $request->password,
            'created_at'    => time()
        ]);
        $player->save();

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
            'first_name' => $info['firstname'],
            'last_name' => $info['lastname'],
            'middle_initial' => $info['middleinitial'],
            'email' => $info['email'],
            'profile' => $info['profile'],
            'address_type' => $info['address_type'],
            'phone_number' => $info['phone'],
            'address' => $info['address'],
            'birthdate' => $info['birthdate'],
            'updated_at' => time()
        ]);

        return Response::json(
            [
                'player' => $player
            ],
            200
        );
    }
}
