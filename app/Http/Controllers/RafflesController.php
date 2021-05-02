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
        $raffles = Raffles::with('schedule')
        ->where('raffle_id', '=', $id)
        ->first();

        return Response::json(
            [
                'raffle' => $raffles,
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
            ['status', '1']
        ])->get();


        return Response::json(
            [
                'raffle_slots' => $raffle_slots,
            ],
            200
        );
    }

    public function saveSelectedSlot(Request $request) {

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
