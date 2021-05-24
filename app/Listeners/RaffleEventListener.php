<?php

namespace App\Listeners;

use App\Events\RaffleEvent;
use App\Http\Controllers\TicketController;
use App\Models\RaffleSlots;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RaffleEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->enterRaffle = new TicketController();
    }

    /**
     * Handle the event.
     *
     * @param  RaffleEvent  $event
     * @return void
     */
    public function handle(RaffleEvent $event)
    {
        // $raffle_slots = RaffleSlots::where([
        //     ['raffle_id', $event->request['raffle_id']],
        //     ['slot_number', $event->request['slot_number']]
        // ])->first();

        // if($raffle_slots==null) {
        //     $taken_slot = new RaffleSlots([
        //         'raffle_id'     => $event->request['raffle_id'],
        //         'player_id'     => $event->request['player_id'],
        //         'slot_number'   => $event->request['slot_number']
        //     ]);

        //     if($this->enterRaffle->enterRaffle($event->request['player_id']) == 'Deducted'){

        //         if($taken_slot->save()){
        //             return response('Successful', 200);
        //         }
        //         else {
        //             return response('Failed', 200);
        //         }

        //     } else {
        //         return $this->enterRaffle->enterRaffle($event->request['player_id']);
        //     }
        // } else {
        //     return response('Slot Taken', 200);
        // }
    }
}
