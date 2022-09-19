<?php

namespace infrastructure\Facades;

use Illuminate\Support\Facades\Facade;

class BybitApiFacade extends Facade{


    protected static function getFacadeAccessor()
    {
        return 'infrastructure\BybitApiService';  
    }

}