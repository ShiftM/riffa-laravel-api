<?php

namespace App\Events;

use App\Models\RaffleSlots;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DrawRaffle implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $winner;
    public $raffleSlots;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($winner)
    {
        $this->winner = $winner;
        $this->raffleSlots = RaffleSlots::where('raffle_id', $winner->raffle_id)->get()->random(1);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('raffle.'.$this->winner->raffle_id);
    }

    public function broadcastAs()
    {
        return 'raffle-draw';
    }

    public function broadcastWith()
    {
        Log::info("DrawRaffle result: ".$this->raffleSlots);
        return [
            'winner' => $this->raffleSlots
        ];
    }

}
