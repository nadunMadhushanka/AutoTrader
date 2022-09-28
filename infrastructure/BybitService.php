<?php

namespace infrastructure;

use App\Models\Rate;
use App\Models\Record;
use App\Models\Symbol;
use infrastructure\Facades\BybitApiFacade;
use domain\Facades\TradeFacade;
use stdClass;
use Throwable;

class BybitService {

   

    

    function __construct()
    {
        $this->rate = new Rate();
        $this->record = new Record();
        $this->symbol = new Symbol();
    }

      
 


//this function changes the leverage
public function changeLev($params){

    $url = "http://localhost:8001";
    $curl_url=$url."?".http_build_query($params);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $curl_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    try {
        $result = curl_exec($curl);

    } catch (Throwable $e) {
        return $e;
    }
      

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


// get the marcket price
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
    $result = $this->record::getPendingRecords();

    foreach($result as $item){
        $symbol = $item->symbol;
        $price = $item->price;
        $id = $item->id;
        $leverage = $item->leverage;
        
        $params = [
            'symbol' => $symbol,
            'leverage' => $leverage,
            'timestamp' => time() * 1000,
        ];

        

        $this->changeLev($params);

        $markPrice = $this->marketPrice($symbol);
        
        $this->checkPrice($price,$markPrice,$id,$item);
        $this->symbol::addSymbols($symbol);
        }
    }





//this function compare mark price and trade price and then call a cloud func to open a trade
public function checkPrice($price,$markPrice,$id,$params){


    if(($params->side) == 'Buy'){

        if($price < $markPrice){

            $input['symbol'] = $params->symbol;
            $input['qty'] = $params->qty;
            $input['side'] = $params->side;
            $input['rep_rate'] = $params->rep_rate;



            $result = $this->tradeOpen($params);


            if(($result->ret_code) == 0){
                $this->rate::create($input); 
                $order_price = $result->result->price;
                $order_id = $result->result->order_id;
                $this->record::aditStatus($id,$order_id,$order_price);

            }else{
                return $result->ret_code;

            }

            

    }
}else if(($params->side) == 'Sell') {

        if($price >= $markPrice){

            $input['symbol'] = $params->symbol;
            $input['qty'] = $params->qty;
            $input['side'] = $params->side;
            $input['rep_rate'] = $params->rep_rate;


            $result = $this->tradeOpen($params);

            if(($result->ret_code) == 0){
                $this->rate::create($input);
                $order_price = $result->result->price;
                $order_id = $result->result->order_id;
                $this->record::aditStatus($id,$order_id,$order_price);

            }else{
                return $result->ret_code;
            }
            

    }       
}
        
   

}




// function for opening the trade
public function tradeOpen($params){

    $input['symbol'] = $params->symbol;
            $input['qty'] = $params->qty;
            $input['side'] = $params->side;


            $url = "http://localhost:8080";
            $curl_url=$url."?".http_build_query($input);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $curl_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


            try {
                
                $resultStr = curl_exec($curl); 

                $result = json_decode($resultStr);

                return $result;
            } catch (Throwable $e) {
                return $e;
            }
            
}


// check the pnl and closing or changing the leverage
public function checkPositions(){

   

    $records = $this->record::getSucceedRecords();

    foreach($records as $trade){
        $mark_price = $this->marketPrice($trade->symbol);
    
         if(!($trade->id) == null){
             
                $entry_price = $trade->order_price;
                $qty = $trade->qty;
                $side = $trade->side;
             $leverage = $trade->leverage;

                
    
            
            (float)$pnl = TradeFacade::checkPnL($qty,$leverage,$mark_price, $entry_price, $side);

            if($pnl != null){

                try {
                    $result = $this->rate::getRate($trade->symbol,$side);
                } catch (Throwable $th) {
                    return $th;
                }

                

                foreach($result as $rates){
                   $rep_rate = $rates->rep_rate;
                   
                   $qty = $rates->qty;
                   $id = $rates->id;
                   if($pnl<=$rep_rate){

                    $params = new stdClass();
                    
                    $params->symbol = $trade->symbol;
                    $params->side = $side;
                    $params->qty = $qty;

                   $result = $this->tradeOpen($params);

                   try {
                    $this->rate::aditStatus($id);
                   } catch (Throwable $th) {
                    return $th;
                   }
                   }
                   }
                }
            

            if($pnl<-5){
                $params = [
                    'symbol' => $trade->symbol,
                    'leverage' => 5,
                    'timestamp' => time() * 1000,
                ];


                $url = "http://localhost:8001";
                $curl_url=$url."?".http_build_query($params);
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $curl_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


                try {
                    $result = curl_exec($curl);
                } catch (Throwable $e) {
                    return $e;
                }
                

            }else if($pnl>5){

                if($side == 'Sell'){
                    $side = 'Buy';
                }else if($side == 'Buy'){
                    $side = 'Sell';
                }

                $params = [
                    'symbol' => $trade->symbol,
                    'price' => $entry_price,
                    'qty' => $qty,
                    'side' => $side
                ];


                $url = "http://localhost:8002";
                $curl_url=$url."?".http_build_query($params);
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $curl_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                

                try {
                    $resultStr = curl_exec($curl);
                    $result = json_decode($resultStr);
                    if ($result->ret_code == 0) {
                        $this->record::addClosedStatus($id);
                    }
                } catch (Throwable $th) {
                    return $th;
                }

                
                
     
            }
        } 
    }

}
}





