<?php
namespace domain;

class TradeService{


    //this function calculate the PnL and execute close function 
    public function checkPnL($qty,$leverage,$mark_price, $trade_price, $type){
     //  dump($mark_price);
    //dump($trade_price);
       //  $pnl = 0;

       if($trade_price != 0 && $leverage != 0 ){

        if($type == 'Buy'){

           

            $fee_to_close= ($qty/($trade_price *(($leverage)/($leverage+1))))*(0.5/100);
            $initial_margin = $qty/($trade_price*$leverage);

            $position_margin = $fee_to_close+$initial_margin;
            $unrealized_pnl = $qty*((1/$trade_price)-(1/$mark_price));

            $pnlPresent = ($unrealized_pnl/$position_margin)*100;

            //  (float)$pnl =(($mark_price-$trade_price)*100/$trade_price);
           //  dump((float)$pnlPresent);
           return $pnlPresent;
            
        } if($type == 'Sell'){


            $fee_to_close= ($qty/($trade_price *(($leverage)/($leverage-1))))*(0.5/100);
            $initial_margin = $qty/($trade_price*$leverage);

            $position_margin = $fee_to_close+$initial_margin;
            $unrealized_pnl = $qty*((1/$mark_price)-(1/$trade_price));

            $pnlPresent = ($unrealized_pnl/$position_margin)*100;
            return $pnlPresent;
            
            // (float)$pnl = (($trade_price-$mark_price)*100/$trade_price);
            //dump((float)$pnlPresent);
            
        }


       }

        
        
        return ;
    }

}

