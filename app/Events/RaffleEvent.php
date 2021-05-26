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
use Config;

class RaffleEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public $request;
    public $taken_slots;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($selectedSlot)
    {
        $this->taken_slots = $selectedSlot;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('raffle-'.$this->taken_slots->raffle_id);
    }

    public function broadcastAs()
    {
        return 'raffle-event';
    }

    public function broadcastWith()
    {
        return [
            "slot" => $this->taken_slots,
        ];
    }

}
