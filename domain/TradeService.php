<?php
namespace domain;

class TradeService{


    //this function calculate the PnL and execute close function 
    public function checkPnL($mark_price, $trade_price, $type){
     //  dump($mark_price);
    //dump($trade_price);
         $pnl = 0;
        if($type == 'buy'){

             (float)$pnl =(($mark_price-$trade_price)*100/$trade_price);
             dump((float)$pnl);
        }else if($type == 'sell'){
            (float)$pnl = (($trade_price-$mark_price)*100);
           // dump((float)$pnl);
        }

        
        return ;
    }

}

