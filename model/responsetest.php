<?php
    require_once('Response.php');
    $res = new Response();
    $res->setSuccess(false);
    $res->setHttpStatusCode(404);
    $res->addMessage("Error with Message 1");
    // $res->addMessage("Test Message 2");
    $res->send();
?>