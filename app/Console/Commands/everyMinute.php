<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use infrastructure\Facades\BybitFacade;

class everyMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will call a function';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dump('run 1');
        BybitFacade::placeMarketOrder();
    }
}
