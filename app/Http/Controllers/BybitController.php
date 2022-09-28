<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use infrastructure\Facades\BybitFacade;
use App\Models\Record;
use App\Models\Symbol;

class BybitController extends Controller
{
    public function placeOrder(Request $request){

         $input = $request->all();

        $currpair = $input['symbol'];
        
         
        Record::create($input);
        
        Symbol::addSymbols($currpair);

       //  BybitFacade::checkPositions();
        return redirect('/');
    }
}
