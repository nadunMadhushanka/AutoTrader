<?php 

namespace cloudFunction\selLeverage;

class ApiCalling
{

    function signedRequest($params,$url,$method)
    {
    

        
    
    $qs=$this->get_signed_params($params,$method);
    $curl_url=$url."?".$qs;
    $curl=curl_init($curl_url);
   // echo $curl_url;
    curl_setopt($curl, CURLOPT_URL, $curl_url);
    #curl_setopt($curl, CURLOPT_POSTFIELDS, $qs);
    curl_setopt($curl, CURLOPT_POST, $method == "POST" ? true : false);
  //  curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    #curl_setopt($curl, CURLOPT_PROXY,"127.0.0.1:1087");
    $execResult=curl_exec($curl);
  //  $response = curl_getinfo($curl);

  
    //curl_close ($curl);
    return $execResult;

    }



    function get_signed_params($params) {
        $public_key = "k8iGFMKeYcqJFZODJq";
        $secret_key = "pcz61s38OZEXnnRuxecarpmap4J5deI23iM7";
        $params = array_merge(['api_key' => $public_key], $params);
        ksort($params);
        //decode return value of http_build_query to make sure signing by plain parameter string
        $signature = hash_hmac('sha256', urldecode(http_build_query($params)), $secret_key);
        return http_build_query($params) . "&sign=$signature";
    }

    // function getTickers($url){
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     //curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    //     curl_setopt($ch, CURLOPT_POST, $method == "POST" ? true : false);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $execResult = curl_exec($ch);
    //     $response = curl_getinfo($ch);

    //     curl_close ($ch);
    //     return json_decode($execResult);

    // }

    // function getMarketPrice($params,$url){
    //     $data = http_build_query($params);
    //     $getUrl = $url."?".$data;
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    //     curl_setopt($ch, CURLOPT_URL, $getUrl);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    //   //  curl_setopt($ch, CURLOPT_POST, $method == "POST" ? true : false);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $execResult = curl_exec($ch);
    //     $response = curl_getinfo($ch);

    //     curl_close ($ch);
    //     return json_decode($execResult);

    // }

}