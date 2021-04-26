<?php

namespace App\Http\Controllers;

use App\Models\Raffles;
use App\Models\RafflesSchedule;
use Illuminate\Http\Request;
use Response;

class RafflesController extends Controller
{
    public function showRaffleInfo($id)
    {
        $raffle_schedule = RafflesSchedule::where([
            ['raffle_id', $id],
        ])->first();

        $raffle_info = Raffles::where([
            ['raffle_id', $id],
        ])->first();


        return Response::json(
            [
                'raffles_schedule' => $raffle_schedule,
                'raffles_info' => $raffle_info,
            ],
            200
        );
    }
}
