<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShuffleRaffle extends Command
{
    protected $signature = 'shuffle:raffle';
    protected $description = 'This command will shuffle and pick a winner in raffle slots';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {   
        print 'Shuffle the Raffle Slots';
    }
}
