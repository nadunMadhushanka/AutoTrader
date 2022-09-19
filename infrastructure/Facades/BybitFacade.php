<?php

namespace infrastructure\Facades;

use Illuminate\Support\Facades\Facade;

class BybitFacade extends Facade{


    protected static function getFacadeAccessor()
    {
        return 'infrastructure\BybitService';  
    }

}