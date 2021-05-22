<?php

namespace App\Listeners;

use App\Events\DrawRaffle;
use App\Models\RaffleSlots;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Response;

class DrawRaffleListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DrawRaffle  $event
     * @return void
     */
    public function handle(DrawRaffle $event)
    {

    }
}
