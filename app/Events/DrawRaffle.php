<?php

namespace App\Events;

use App\Http\Controllers\RafflesController;
use App\Models\Raffles;
use App\Models\RaffleSlots;
use App\Models\RafflesSchedule;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Config;

class DrawRaffle implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $raffleId;
    public $raffleSlots;
    public $random_number;
    public $slots_taken;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($raffleId)
    {
        $this->raffleController = new RafflesController();
        $this->raffleId = $raffleId;

        //will draw winner from 1 to a max number. May produce no winner.
        $raffle = Raffles::where('raffle_id', $raffleId)->first();
        $this->random_number = rand(1,$raffle->slots);

        $this->slots_taken = RaffleSlots::where([
            'raffle_id' => $raffleId,
            'slot_number' => $this->random_number,
        ])->first();
        if($this->slots_taken != null){
            $this->slots_taken->update([
                'is_winner' => Config::get('constants.STATUS.ACTIVE')
            ]);
        }


        //will add 1 day to schedule
        $now = strtotime(Carbon::now()->addDay());
        RafflesSchedule::where('raffle_id', $raffleId)
        ->update([
            'schedule' => $now
        ]);

        //will give out consolation price
        $this->raffleController->giveConsolationCoins($raffleId);

        //will change status of slots taken to 0
        $this->taken_slots = RaffleSlots::where([
            'raffle_id' => $raffleId,
            'status' => Config::get('constants.STATUS.ACTIVE')
        ])->get();
        if($this->taken_slots != null){
            foreach($this->taken_slots as $slots) {
                $slots->update([
                    'status' => Config::get('constants.STATUS.INACTIVE')
                ]);
            }
        }

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('raffle.'.$this->raffleId);
    }

    public function broadcastAs()
    {
        return 'raffle-draw';
    }

    public function broadcastWith()
    {
        Log::info("DrawRaffle ". $this->raffleId ." result: ". $this->random_number. " --- Winner Info: ". $this->slots_taken);
        return [
            'winner' => $this->random_number,
            'winner_info' => $this->slots_taken,
        ];
    }

}
