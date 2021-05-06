<?php

namespace App\Http\Controllers;

use App\Models\Charity;
use App\Models\Coins;
use App\Models\Player;
use App\Models\Prizes;
use App\Models\Raffles;
use App\Models\RaffleSlots;
use App\Models\RafflesSchedule;
use App\Models\TicketTransaction;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class RafflesController extends Controller
{

    public function __construct() {
        $this->enterRaffle = new TicketController();
    }

    public function showAllRaffles() {
        $raffles = Raffles::with('schedule')->get();
        // $prize = Prizes::where([
        //     ['prize_id', $raffles[0]->prize_id]
        // ])->get('name');
        // $charity = Charity::where([
        //     ['charity_id', $raffles[0]->charity_id]
        // ])->get('charity_name');

        // $raffles[0]['prize_name'] = $prize[0]['name'];
        // $raffles[0]['charity_name'] = $charity[0]['charity_name'];

        foreach($raffles as $raffle) {
            $prize = Prizes::where([
                ['prize_id', $raffle->prize_id]
            ])->first('name');
            $charity = Charity::where([
                ['charity_id', $raffle->charity_id]
            ])->first('charity_name');

            $raffle['prize_name'] = $prize['name'];

            if(isset($charity['charity_name'])) {
                $raffle['charity_name'] = $charity['charity_name'];
            }
        }


        return Response::json(
            [
                'raffles' => $raffles
            ],
            200
        );
    }

    public function showRaffleInfo($id)
    {
        $raffles = Raffles::with('schedule')
        ->where('raffle_id', $id)
        ->first();

        return Response::json(
            [
                'raffle' => $raffles,
            ],
            200
        );
    }

    public function insertRaffleInfo(Request $request) {
        $info = $request->all();
        $raffle_info = new Raffles([
            'prize_id'      =>       $info['prize_id'],
            // 'charity_id'    =>       isset($info['charity_id']) ? $info['charity_id'] : null,
            'charity'       =>       $info['charity_id'],
            'raffle_name'   =>       $info['raffle_name'],
            'image'         =>       isset($info['image']) ? (strpos($info['image'], 'aws') ? (str_replace(Config::get('constants.RIFFA_S3_URL.RAFFLE'), '', $info['image']) == $raffle_info['image'] ? str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['image']) : $this->image->uploadImage($info['image'])) : "" ) : "",
            'raffle_desc'   =>       isset($info['raffle_desc']) ? $info['raffle_desc'] : null,
            'slots'         =>       $info['slots'],
            'slot_price'    =>       $info['slot_price'],
            // 'raffle_type_id'=>       $info['raffle_type'],
            'raffle_type'   =>       $info['raffle_type'],
            'created_at'    =>       time()
        ]);
        $raffle_info->save();

        // if($raffle_info != null) {
        //     $raffle_schedule = new RafflesSchedule([
        //         'raffle_id' => $raffle_info->raffle_id,
        //         'start_schedule' => $info['start_schedule'],
        //         'end_schedule' => $info['end_schedule']
        //     ]);
        //     $raffle_schedule->save();
        // }

        return Response::json(
            [
                'raffle_info' => $raffle_info,
                // 'raffle_schedule' => $raffle_schedule
            ],
            200
        );
    }

    public function editRaffleInfo(Request $request) {
        $info = $request->all();
        $raffles = Raffles::with('schedule')->where('raffle_id', $info['raffle_id'])->get();
        $raffle = Raffles::where('raffle_id', $info['raffle_id'])->update([
            'prize_id'      =>       $info['prize_id'],
            'charity_id'    =>       isset($info['charity_id']) ? $info['charity_id'] : null,
            'raffle_name'   =>       $info['raffle_name'],
            'image'         =>       isset($info['image']) != null ? (strpos($info['image'], 'aws') ? (str_replace(Config::get('constants.RIFFA_S3_URL.RAFFLE'), '', $info['image']) == $raffles['image'] ? str_replace(Config::get('constants.RIFFA_S3_URL.RAFFLE'), '', $info['image']) : $this->image->uploadImage($info['image'])) : "" ) : "",
            'raffle_desc'   =>       isset($info['raffle_desc']) ? $info['raffle_desc'] : null,
            'slots'         =>       $info['slots'],
            'slot_price'    =>       $info['slot_price'],
            'updated_at'    =>       time()
        ]);
        if(isset($info['image']) != null) {
            $raffle['image'] = Config::get('constants.RIFFA_S3_URL.RAFFLE').$raffle['image'];
        }

        $raffle_schedule = RafflesSchedule::find($info['raffle_id']);

        $raffle_schedule->update([
            'raffle_id' => $info['raffle_id'],
            'start_schedule' => $info['start_schedule'],
            'end_schedule' => $info['end_schedule']
        ]);

        return Response::json(
            [
                'raffle_info' => $raffle
            ],
            200
        );
    }

    public function showTakenSlots($id)
    {
        $raffle_slots = RaffleSlots::where([
            ['raffle_id', $id]
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
            ['slot_number', $request->slot_number]
        ])->first();

        if($raffle_slots==null) {
            $taken_slot = new RaffleSlots([
                'raffle_id'     => $request->raffle_id,
                'player_id'     => $request->player_id,
                'slot_number'   => $request->slot_number
            ]);

            if($this->enterRaffle->enterRaffle($request->player_id, 'Raffle Entry') == 'Deducted'){

                if($taken_slot->save()){
                    return response('Successful', 200);
                }
                else {
                    return response('Failed', 200);
                }

            } else {
                return $this->enterRaffle->enterRaffle($request->player_id, 'Raffle Entry');
            }
        } else {
            return response('Slot Taken', 200);
        }

    }

    public function endRaffle(Request $request) {

        if($raffles = Raffles::with('schedule')->where([
            ['raffle_id', $request->raffle_id],
            ['is_active', 1]
        ])->update(['is_active' => 0])) {
            if($this->giveConsolationCoins($request->raffle_id) == "Done"){
                return response('Successful', 200);
            }
        } else {
            return response('Failed/Already Updated', 200);
        }

    }

    public function giveConsolationCoins($raffle_id) {

        $raffle_slots = RaffleSlots::where([
            ['raffle_id', $raffle_id],
            ['is_winner', 0]
        ])->get(DB::raw('DISTINCT(player_id)'));

        foreach($raffle_slots as $raffle_slot) {
            $player = Coins::where('player_id', $raffle_slot->player_id)->first();
            $player->update([
                    'coin_balance' => $player->coin_balance + 100 ,
                    'last_update'  => time()
                ]);

            $ticket_transaction = new TicketTransaction([
                'coin_id' => $player->coin_id,
                'description' => 'Consolation Prize',
                'date' => time()
            ]);
            $ticket_transaction->save();
        }

        return 'Done';

    }

}
