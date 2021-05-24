<?php

namespace App\Events;

use App\Http\Controllers\TicketController;
use App\Models\RaffleSlots;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RaffleEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public $request;
    public $taken;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->enterRaffle = new TicketController();
        $this->request = $request;
        $raffle_slots = RaffleSlots::where([
            ['raffle_id', $request['raffle_id']],
            ['slot_number', $request['slot_number']]
        ])->first();

        if($raffle_slots==null) {
            $taken_slot = new RaffleSlots([
                'raffle_id'     => $request['raffle_id'],
                'player_id'     => $request['player_id'],
                'slot_number'   => $request['slot_number']
            ]);

            $this->taken = $taken_slot;

            $this->enterRaffle->enterRaffle($request['player_id']);

                $taken_slot->save();
        //             return response('Successful', 200);
        //         }
        //         else {
        //             return response('Failed', 200);
        //         }

        //     } else {
        //         return $this->enterRaffle->enterRaffle($request['player_id']);
        //     }
        } else {
            return response('Slot Taken', 200);
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('raffle-'.$this->request['raffle_id']);
    }

    public function broadcastAs()
    {
        return 'raffle-event';
    }

    public function broadcastWith()
    {
        return [
            "taken_slot" => $this->taken,
        ];
    }

}
