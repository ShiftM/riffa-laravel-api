<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RaffleSlots;
use Config;
use Response;
class RaffleSlotsController extends Controller
{
    public function savePlayerSlot(Request $request) {
        $raffleId = $request->raffleId;
        $playerId = $request->playerId;
        $slotNumber = $request->slotNumber;

        $slot = new RaffleSlots([
            'raffle_id'  => $raffleId,
            'player_id'  => $playerId,
            'slot_number' => $slotNumber,
            'created_at' => time()
        ]);

        $slot->save();

        return Response::json(
            [
                'slot' => $slot
            ],
            200
        );
    }
}
