<?php

use Buildings\MessageQuery;

$msg = new \Buildings\Message();

$results = MessageQuery::create()->find();

$msg->setMsg("Hello Mom!");

$msg->save();

$arrayResults = [];


foreach ($results as $result) {
    $arrayResults[] = $result->toArray();
}


echo json_encode($arrayResults);
