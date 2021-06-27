<?php
require_once("Task.php");
try{
     $address = "feet";
     $task = new Task($address);
     header('Content-type: application/json; charset=UTF-8');
     echo json_encode($task->retrunOSMArray());
     echo json_encode($task->retrunGoogleArray());
}
catch(TaskException $e) {
    echo "Error " . $e->getMessage();
}