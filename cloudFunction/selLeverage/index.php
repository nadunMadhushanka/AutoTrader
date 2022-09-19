<?php

use cloudFunction\selLeverage\ApiCalling;
use Google\CloudFunctions\FunctionsFramework;
use Psr\Http\Message\ServerRequestInterface;

// Register the function with Functions Framework.
// This enables omitting the `FUNCTIONS_SIGNATURE_TYPE=http` environment
// variable when deploying. The `FUNCTION_TARGET` environment variable should
// match the first parameter.




FunctionsFramework::http('setLeverage', 'setLeverage');
FunctionsFramework::http('openTrade', 'openTrade');
FunctionsFramework::http('closeTrade', 'closeTrade');

require "apiCalling.php";


function openTrade(ServerRequestInterface $request): string
{
//8080
    $url = 'https://api-testnet.bybit.com/private/linear/order/create';
        $method = 'POST';

        $symbol = '';
        $qty = '';
        $side = '';
        
        



        $queryString = $request->getQueryParams();
        $qty = $queryString['qty'] ?? $qty;
        $symbol = $queryString['symbol'] ?? $symbol;
        $side = $queryString['side'] ?? $side;
        

    $params = [
        'symbol' => $symbol, 
        'side' => $side, 
        'order_type' => 'Market', 
        'qty' => (float)$qty, 
        'time_in_force' => 'GoodTillCancel',
        'reduce_only' => false,
        'close_on_trigger' => false,
        'timestamp' => time() * 1000,
        
        
    ];

    $api = new ApiCalling();

    $result = $api->signedRequest($params,$url,$method);



     return $result;
}

function setLeverage(ServerRequestInterface $request): string
{//8001
    $url = 'https://api-testnet.bybit.com/private/linear/position/set-leverage';
    $method = 'POST';
    
    $leverage = '';
    $symbol = '';

    $queryString = $request->getQueryParams();
    $leverage = $queryString['qty'] ?? $leverage;
    $symbol = $queryString['symbol'] ?? $symbol;
        

    $params = [
        'symbol' => $symbol,
        'buy_leverage' => $leverage,
        'sell_leverage' => $leverage,
        // 'time_in_force' => 'GoodTillCancel',
        // 'reduce_only' => false,
        // 'close_on_trigger' => false,
         'timestamp' => time() * 1000,
        
    ]; 

    $api = new ApiCalling();

    $result = $api->signedRequest($params,$url,$method);
    return $result;
}




function closeTrade(ServerRequestInterface $request): string
{//8002
    $name = 'World';
    $body = $request->getBody()->getContents();
    echo $body;


    $url = 'https://api-testnet.bybit.com/private/linear/order/create';
        $method = 'POST';

        $symbol = '';
        $qty = '';
        $side = '';
      

        $queryString = $request->getQueryParams();
        $qty = $queryString['qty'] ?? $qty;
        $symbol = $queryString['symbol'] ?? $symbol;
        $side = $queryString['side'] ?? $side;
        

    $params = [
        'symbol' => $symbol, 
        'side' => $side, 
        'order_type' => 'Market', 
        'qty' => (float)$qty, 
        'time_in_force' => 'GoodTillCancel',
        'reduce_only' => true,
        'close_on_trigger' => true,
        'timestamp' => time() * 1000,
        
        
    ];

    $api = new ApiCalling();

    $result = $api->signedRequest($params,$url,$method);



     return $result;
}

