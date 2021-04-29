<?php

namespace App\Http\Controllers;

use App\Models\Raffles;
use App\Models\RaffleSlots;
use App\Models\RafflesSchedule;
use Illuminate\Http\Request;
use Response;

class RafflesController extends Controller
{
    public function showAllRaffles() {
        $raffles = Raffles::with('schedule')->get();

        return Response::json(
            [
                'raffles' => $raffles
            ],
        );
    }

    public function showRaffleInfo($id)
    {
        $raffle = Raffles::with(['schedule' => function($query) use ($id) {
            $query->where([
                ['raffle_id', $id]
            ]);
        }])->get();

        return Response::json(
            [
                'raffle' => $raffle,
            ],
            200
        );
    }

    public function insertRaffleInfo(Request $request) {
        $raffle_info = new Raffles([
            'raffle_name' => $request->raffle_name,
            'raffle_desc' => $request->raffle_desc,
            'slots'       => $request->slots,
            'created_at'  => time()
        ]);
        $raffle_info->save();

        if($raffle_info != null) {
            $raffle_schedule = new RafflesSchedule([
                'raffle_id' => $raffle_info->raffle_id,
                'start_schedule' => time(),
                'end_schedule' => time(),
                'created_at' => time()
            ]);
            $raffle_schedule->save();
        }

        return Response::json(
            [
                'raffle_info' => $raffle_info
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
