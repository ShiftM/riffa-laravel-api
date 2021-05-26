<?php

namespace App\Http\Controllers;

use App\Events\DrawRaffle;
use App\Events\RaffleEvent;
use App\Models\Charity;
use App\Models\Coins;
use App\Models\Player;
use App\Models\Prizes;
use App\Models\Raffles;
use App\Models\RaffleSlots;
use App\Models\RafflesSchedule;
use App\Models\RaffleType;
use App\Models\TicketTransaction;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Config;

class RafflesController extends Controller
{

    public function __construct() {
        $this->enterRaffle = new TicketController();
    }

    public function showAllRaffles() {
        $raffles = Raffles::with('schedule', 'charity', 'type', 'takenSlots', 'takenSlots.user')
                 ->where('status', Config::get('constants.STATUS.ACTIVE'))
                 ->get();
        
        for($i = 0; $i < count($raffles); $i++) {
            if($raffles[$i]->takenSlots != null) {
                for($j = 0; $j < count($raffles[$i]->takenSlots); $j++) {
                   $raffles[$i]->takenSlots[$j]->user->profile = Config::get('constants.RIFFA_S3_URL.PROFILE').$raffles[$i]->takenSlots[$j]->user->profile;
                   break;
                }
            }
        }
      
        // foreach($raffles as $raffle) {
        //     $prize = Prizes::where([
        //         ['prize_id', $raffle->prize_id]
        //     ])->first('name');
        //     $charity = Charity::where([
        //         ['charity_id', $raffle->charity_id]
        //     ])->first('charity_name');
        //     $raffle_type = RaffleType::where([
        //         ['type_id', $raffle->type_id]
        //     ])->first('raffle_type');

        //     $raffle['prize_name'] = $prize['name'];
        //     $raffle['raffle_type'] = $raffle_type['raffle_type'];

        //     if(isset($charity['charity_name'])) {
        //         $raffle['charity_name'] = $charity['charity_name'];
        //     }
        // }


        return Response::json(
            [
                'raffles' => $raffles
            ],
            200
        );
    }

    public function shuffle($raffleID)
    {
        //Fire the event
        //Will draw winner then broadcast the result
        DrawRaffle::dispatch($raffleID);
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
            'prize_id'                 =>       $info['prize_id'],
            'type_id'                  =>       $info['type_id'],
            'prize_2'                  =>       isset($info['prize_2']),
            'prize_3'                  =>       isset($info['prize_3']),
            'prize1_probability'       =>       isset($info['prize1_probability']),
            'prize2_probability'       =>       isset($info['prize2_probability']),
            'prize3_probability'       =>       isset($info['prize3_probability']),
            'charity_id'               =>       isset($info['charity_id']) ? $info['charity_id'] : null,
            'raffle_name'              =>       $info['raffle_name'],
            'image1'                   =>       isset($info['image1']) ? (strpos($info['image1'], 'aws') ? str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['image1']) : $this->image->uploadImage($info['image1'])) : "",
            'image2'                   =>       isset($info['image2']) ? (strpos($info['image2'], 'aws') ? str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['image2']) : $this->image->uploadImage($info['image2'])) : "",
            'image3'                   =>       isset($info['image3']) ? (strpos($info['image3'], 'aws') ? str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['image3']) : $this->image->uploadImage($info['image3'])) : "",
            'raffle_desc'              =>       isset($info['raffle_desc']) ? $info['raffle_desc'] : null,
            'slots'                    =>       $info['slots'],
            'created_at'               =>       time()
        ]);
        $raffle_info->save();

        if($raffle_info != null) {
            $raffle_schedule = new RafflesSchedule([
                'raffle_id' => $raffle_info->raffle_id,
                'schedule' => $info['schedule'],
            ]);
            $raffle_schedule->save();
        }

        return Response::json(
            [
                'raffle_info' => $raffle_info,
            ],
            200
        );
    }

    public function editRaffleInfo(Request $request) {
        $info = $request->all();
        $raffles = Raffles::with('schedule')->where('raffle_id', $info['raffle_id'])->get();
        $raffle = Raffles::where('raffle_id', $info['raffle_id'])->update([
            'prize_id'      =>       $info['prize_id'],
            'type_id'       =>       $info['type_id'],
            'prize_2'       =>       isset($info['prize_2']),
            'prize_3'       =>       isset($info['prize_3']),
            'prize1_probability'       =>       isset($info['prize1_probability']),
            'prize2_probability'       =>       isset($info['prize2_probability']),
            'prize3_probability'       =>       isset($info['prize3_probability']),
            'charity_id'    =>       isset($info['charity_id']) ? $info['charity_id'] : null,
            'raffle_name'   =>       $info['raffle_name'],
            'image1'        =>       isset($info['image1']) != null ? (strpos($info['image1'], 'aws') ? (str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['image1']) == $raffles['image1'] ? str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['image1']) : $this->image->uploadImage($info['image1'])) : "" ) : "",
            'image2'        =>       isset($info['image2']) != null ? (strpos($info['image2'], 'aws') ? (str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['image2']) == $raffles['image2'] ? str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['image2']) : $this->image->uploadImage($info['image2'])) : "" ) : "",
            'image3'        =>       isset($info['image3']) != null ? (strpos($info['image3'], 'aws') ? (str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['image3']) == $raffles['image3'] ? str_replace(Config::get('constants.RIFFA_S3_URL.PROFILE'), '', $info['image3']) : $this->image->uploadImage($info['image3'])) : "" ) : "",
            'raffle_desc'   =>       isset($info['raffle_desc']) ? $info['raffle_desc'] : null,
            'slots'         =>       $info['slots'],
            'updated_at'    =>       time()
        ]);

        if(isset($info['image1']) != null) {
            $raffle['image1'] = Config::get('constants.RIFFA_S3_URL.PROFILE').$raffle['image1'];
        }
        if(isset($info['image2']) != null) {
            $raffle['image2'] = Config::get('constants.RIFFA_S3_URL.PROFILE').$raffle['image2'];
        }
        if(isset($info['image3']) != null) {
            $raffle['image3'] = Config::get('constants.RIFFA_S3_URL.PROFILE').$raffle['image3'];
        }

        $raffle_schedule = RafflesSchedule::find($info['raffle_id']);

        $raffle_schedule->update([
            'raffle_id' => $info['raffle_id'],
            'schedule' => $info['schedule'],
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
            'raffle_id' => $id,
            'status' => Config::get('constants.STATUS.ACTIVE')
        ])->get();


        return Response::json(
            [
                'raffle_slots' => $raffle_slots,
            ],
            200
        );
    }

    public function saveSelectedSlot(Request $request) {
        $raffleId = $request->raffleId;
        $slotNumber = $request->slotNumber;
        $playerId = $request->playerId;
        $selectedSlot = '';
        $slot = RaffleSlots::where([
            ['raffle_id', $raffleId],
            ['slot_number', $slotNumber]
        ])->first();

        if($slot == null) {
            $selectedSlot = new RaffleSlots([
                'raffle_id'     => $raffleId,
                'player_id'     => $playerId,
                'slot_number'   => $slotNumber
            ]);
            $selectedSlot->save();

            // $selectedSlot = RaffleSlots::with(['user' => function($query) {
            //     $query->where([
            //         ['is_active', Config::get('constants.STATUS.ACTIVE')],
            //         ['role', Config::get('constants.ROLE.USER')]
            //     ]);
            // }])->where([
            //     ['raffle_id', $selectedSlot->raffle_id]
            // ])->first();
            // $selectedSlot->user->profile = Config::get('constants.RIFFA_S3_URL.PROFILE').$selectedSlot->user->profile;
        }
       
        if($selectedSlot != null) {
            //Fire the event
            //Will save selected slots then automatic deduct of 1 ticket
            //Will save also to transaction logs
            RaffleEvent::dispatch($selectedSlot);
        }
    }

    public function startRaffle(Request $request) {

        if($raffles = Raffles::with('schedule')->where([
            ['raffle_id', $request->raffle_id],
            ['is_active', 0]
        ])->update(['is_active' => 1])) {
            return response('Successful', 200);
        } else {
            return response('Failed/Already Updated', 200);
        }

    }

    public function endRaffle(Request $request) {

        if($raffles = Raffles::with('schedule')->where([
            ['raffle_id', $request->raffle_id],
            ['status', Config::get('constants.STATUS.ACTIVE')]
        ])->update(['status' => Config::get('constants.STATUS.INACTIVE')])) {
            return response('Successful', 200);
        } else {
            return response('Failed/Already Updated', 200);
        }

    }

    public function giveConsolationCoins($raffle_id) {

        $raffle_slots = RaffleSlots::whereRaw('player_id not in (select DISTINCT(player_id) from raffle_slots where is_winner = 1)')
        ->get(DB::raw('DISTINCT(player_id)'));

        foreach($raffle_slots as $raffle_slot) {
            $player = Coins::where('player_id', $raffle_slot->player_id)->first();
            $player->update([
                    'coin_balance' => $player->coin_balance + 100 ,
                    'last_update'  => time()
                ]);

            $ticket_transaction = new TicketTransaction([
                'coin_id' => $player->coin_id,
                'title' => 'Consolation Prize',
                'type' => 'Coins',
                'date' => time()
            ]);
            $ticket_transaction->save();
        }

        return 'Consolation Distributed';

    }

}
