<?php

namespace domain\Facades;

use Illuminate\Support\Facades\Facade;

class TradeFacade extends Facade{


    protected static function getFacadeAccessor()
    {
        return 'domain\TradeService';  
    }

}