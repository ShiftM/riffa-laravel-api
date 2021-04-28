<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\ImageController;
use App\Models\Coins;
use App\Models\Player;
use Response;
use Auth;
use Config;

class PlayerController extends Controller
{
    public function __construct() {
        $this->image = new ImageController();
    }

    public function login(Request $request) {
        $token = '';
        $player = Player::where([
            ['email', $request->email],
            ['password', $request->password]
        ])->first();

        if($player != null) {
            $player['profile'] = Config::get('constants.RIFFA_S3_URL.PROFILE').$player['profile'];
            $token = $player->createToken('player')->plainTextToken;
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
            'profile' => $info['profile'] != null ? (strpos($info['profile'], 'aws') ? (str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['profile']) == $player['profile'] ? str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['profile']) : $this->image->uploadImage($info['profile'])) : "" ) : "",
            'address_type' => $info['address_type'],
            'phone_number' => $info['phone'],
            'address' => $info['address'],
            'birthdate' => $info['birthdate'],
            'updated_at' => time()
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

    public function showCoinBalance($id) {
        $coins = Coins::where([
            ['player_id', $id],
        ])->first();

        return Response::json(
            [
                'coins' => $coins
            ],
            200
        );

    }

}
