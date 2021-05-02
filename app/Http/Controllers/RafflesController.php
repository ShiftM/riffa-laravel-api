<?php

namespace App\Http\Controllers;

use App\Models\Raffles;
use App\Models\RaffleSlots;
use App\Models\RafflesSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            ['status', '1']
        ])->get();


        return Response::json(
            [
                'raffle_slots' => $raffle_slots,
            ],
            200
        );
    }

    public function takeSlot(Request $request) {

        $raffle_slots = RaffleSlots::where([
            ['raffle_id', $request->raffle_id],
            ['slot_number', $request->slot_number],
            ['status', '1']
        ])->first();

        if($raffle_slots==null) {
            $taken_slot = new RaffleSlots([
                'raffle_id'     => $request->raffle_id,
                'player_id'     => $request->player_id,
                'price_id'      => $request->price_id,
                'slot_number'   => $request->slot_number,
                'status'        => "1"
            ]);

            if($taken_slot->save()){
                return response('Successful', 200)
                ->header('Content-Type', 'text/plain');
            }
            else {
                return response('Failed', 200)
                ->header('Content-Type', 'text/plain');
            }
        } else {
            return response('Slot Taken', 200)
                ->header('Content-Type', 'text/plain');
        }

    }

    public function endRaffle(Request $request)
    {
        if($raffle_slots = RaffleSlots::where([
            ['raffle_id', $request->raffle_id],
            ['status', '1']
        ])->update(array('status' => 0))) {
            return response('Successful', 200)
                ->header('Content-Type', 'text/plain');
        } else {
            return response('Failed/Already Updated', 200)
                ->header('Content-Type', 'text/plain');
        }

    }

}
