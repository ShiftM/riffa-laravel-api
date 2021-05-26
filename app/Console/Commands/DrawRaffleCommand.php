<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RafflesController;
use App\Models\Raffles;
use App\Models\RafflesSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DrawRaffleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'draw:winner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will randomly pick winner in a designated time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $enterRaffle = new RafflesController();
        $now = date("Y-m-d H:i"); //using UTC Timezone
        // Log::info($now);

        // get the raffle schedule today
        $raffleSched = RafflesSchedule::whereRaw("CONVERT_TZ(FROM_UNIXTIME(schedule, '%Y-%m-%d %H:%i'), @@session.time_zone, '+00:00') = '$now'")->get();
        // Log::info($raffleSched);

        //schedule must be in UTC Timezone
        if($raffleSched != null){
            foreach($raffleSched as $raffles) {

                $raffleStatus = Raffles::where([
                    'raffle_id' => $raffles->raffle_id
                ])->first();

                if($raffleStatus->status == 1){
                    $enterRaffle->shuffle($raffleStatus->raffle_id);
                }

            }
        }
    }
}
