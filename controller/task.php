<?php
require_once("../model/Response.php");
require_once("../model/Task.php");

if(array_key_exists("address", $_GET)){
    $address = urlencode($_GET['address']);
    if($address == ''){
        $res = new Response();
        $res->setSuccess(false);
        $res->setHttpStatusCode(400);   // Bad Request
        $res->addMessage("Address Cannot be Null");
        $res->send();
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        try{
                $task = new Task(
                    $address
                );
                     $osmTaskArray = $task->retrunOSMArray();  // Call to function in TASK Class
                     $googleTaskArray = $task->retrunGoogleArray();
                    $returnData =  array();
                    $res = new Response();
                    $res->setSuccess(true);
                    $res->toCache(true);
                    $res->setHttpStatusCode(200);   
                    $res->addMessage("Please check the response data to validate");
                    $res->setOSMData($osmTaskArray);
                    $res->setGoogleData($googleTaskArray); 
                    $res->send();
                    exit;
        }
        catch(Exception $e){
                    $res = new Response();
                    $res->setSuccess(false);
                    $res->setHttpStatusCode(500);   // Bad Request
                    $res->addMessage($e->getMessage());
                    $res->send();
                    exit;
        }
    }
    else{
      
            $res = new Response();
            $res->setSuccess(false);
            $res->setHttpStatusCode(400);   // Bad Request
            $res->addMessage("Bad Request / Wrong Method");
            $res->send();
            exit;
    }
    
}
else{
            $res = new Response();
            $res->setSuccess(false);
            $res->setHttpStatusCode(404);   // Bad Request
            $res->addMessage("Address cannot be empty / Please specify address to fecth results");
            $res->send();
            exit;
}