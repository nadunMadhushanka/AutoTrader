<?php

namespace infrastructure;

use App\Models\Record;
use App\Models\Symbol;
use infrastructure\Facades\BybitApiFacade;
use infrastructure\Facades\BybitFacade;
use domain\Facades\TradeFacade;

class BybitService {

      
 


//this function changes the leverage
public function changeLev($params){

    $url = "http://localhost:8001";
    $curl_url=$url."?".http_build_query($params);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $curl_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);

    dump($result);
    

}



//this function gets all available coins list
public function getTickers(){
    $url = 'https://api-testnet.bybit.com/v2/public/symbols';
    $method = 'GET';
    $param=[];
    $result = BybitApiFacade::signedRequest($param,$url,$method);
        $currDetails = $result->result;
    return $currDetails;
}



public function marketPrice($symbol){
    $param = ['symbol' => $symbol];
        $url = 'https://api-testnet.bybit.com/v2/public/tickers';
        $method = 'GET';
        $result = BybitApiFacade::signedRequest($param,$url, $method);
        $currDetails = $result->result;
        $markPrice = $currDetails[0]->mark_price;
        return $markPrice;
}




// this function excecute few functions and finally open an order
public function placeMarketOrder(){
    $result = Record::getRecords();

    foreach($result as $item){
        $symbol = $item->symbol;
        $price = $item->price;
        $id = $item->id;

        $markPrice = $this->marketPrice($symbol);
        
        $this->checkPrice($price,$markPrice,$id,$item);
        Symbol::addSymbols($symbol);
        }
    }







//this function drops records
public function destroy($id)
    {
        Record::destroy($id);
        return redirect('home')->with('flash_message', 'Product deleted!');  
    }






    //this function compare mark price and trade price and then call a cloud func to open a trade
public function checkPrice($price,$markPrice,$id,$params){

        if($price >= $markPrice){

            $url = "http://localhost:8080";
            $curl_url=$url."?".http_build_query($params);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $curl_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);  
            $this->destroy($id);
            dump($result);  
            return 'yes';
        }else{
            dump('no');
        }
}






//this function gets all the trade records 
 public function getTrade($currpair)
    {
        $url = 'https://api-testnet.bybit.com/private/linear/position/list';
        $method = 'GET';

    $params = [
        'symbol' => $currpair, 
         //'exec_type' => 'Trade',
         //'order_status' => 'New',
       //  'order_type' => 'Market',
        // 'time_in_force' => 'GoodTillCancel',
        // // 'reduce_only' => true,
        // // 'close_on_trigger' => false,
         'timestamp' => time() * 1000,
    ];

    return BybitApiFacade::signedRequest($params,$url,$method);

}








public function checkPositions(){

    $symbols = Symbol::getSymbols();

    //dd($symbols);

    foreach($symbols as $currpair){
        $mark_price = $this->marketPrice($currpair['symbol']);
        
        $result = $this->getTrade($currpair['symbol']);
        if(!($result->result) == null){
            foreach($result->result as $item){
              //  dump($item);
                $entry_price = $item->entry_price;
              //  dump($entry_price);
                $qty = $item->size;
              //  dump($qty);
                $side = $item->side;
             //   dump($side);

                if($side == 'Sell'){
                    $side = 'Buy';
                }else if($side == 'Buy'){
                    $side = 'Sell';
                }


            
            
            
            (float)$pnl = TradeFacade::checkPnL($mark_price, $entry_price, $side);
           // dump($pnl);

            if($pnl<-5){
                $params = [
                    'symbol' => $currpair['symbol'],
                    'buy_leverage' => 5, 
                    'sell_leverage' => 5,
                    'timestamp' => time() * 1000,
                ];


            }else if($pnl>5){

                $params = [
                    'symbol' => $currpair['symbol'],
                    'price' => $entry_price,
                    'qty' => $qty,
                    'side' => $side
                ];


                $url = "http://localhost:8002";
                $curl_url=$url."?".http_build_query($params);
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $curl_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($curl);

              //  dump($result);

                
            }
        
    }
    
}
}

}
}


