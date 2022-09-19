<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use infrastructure\Facades\BybitFacade;

class everyMinuteCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'checking the pnl';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dump('running 2');
        BybitFacade::checkPositions();
    }
}
