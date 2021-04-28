<?php

namespace App\Http\Controllers;

use App\Models\Raffles;
use App\Models\RaffleSlots;
use App\Models\RafflesSchedule;
use Illuminate\Http\Request;
use Response;

class RafflesController extends Controller
{
    public function showAllRaffles()
    {
        $raffle_info = Raffles::all();


        return Response::json(
            [
                'raffles_info' => $raffle_info,
            ],
            200
        );
    }

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

    public function showTakenSlots($id)
    {
        $raffle_slots = RaffleSlots::where([
            ['raffle_id', $id],
        ])->get();


        return Response::json(
            [
                'raffle_slots' => $raffle_slots,
            ],
            200
        );
    }
}
