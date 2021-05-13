<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RaffleType;

use Config;
use Response;
class RaffleTypeController extends Controller
{
    public function getAllTypes() {
        $raffle_types = RaffleType::all();

        return Response::json(
            [
                'types' => $raffle_types
            ],
            200
        );
    }
}
