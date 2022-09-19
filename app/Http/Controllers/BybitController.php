<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use infrastructure\Facades\BybitFacade;
use App\Models\Record;
use App\Models\Symbol;

class BybitController extends Controller
{
    public function placeOrder(Request $request){

         $input = $request->all();

        $currpair = $input['symbol'];
        $price = $input['price'];
        $qty = $input['qty'];
        $side = $input['side'];
         
          Record::create($input);
          Symbol::addSymbols($currpair);
          BybitFacade::changeLev($input);
          return redirect('/');
         //BybitFacade::getMarketPrice();
         
         //dump($state);
      // BybitFacade::placeOrder($currpair,$price, $qty,$side);
        // BybitFacade::checkPositions();
    
    }
}
