<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

$body = bodyParser();

permissionValidator($apiKey, "UPDATE");

$targetAddress = null;

if(isset($body["address_id"])) {
    $validateInteger($body["address_id"]);
    $targetAddress = \Buildings\AddressQuery::create()->findOneById($body["address_id"]);
}

if(!isset($targetAddress)) {
    sendResponse(400, true, "address could not be found, is address_id set?");
}


$mergeObj = [];

if($body["country"]) {
    $validateLocation($body["country"]);
    $mergeObj["country"] = $body["country"];
}
if($body["state"]) {
    $validateState($body["state"]);
    $mergeObj["state"] = $body["state"];
}
if($body["city"]) {
    $validateLocation($body["city"]);
    $mergeObj["city"] = $body["city"];
}
if($body["neighborhood"]) {
    $validateLocation($body["neighborhood"]);
    $mergeObj["neighborhood"] = $body["neighborhood"];
}
if($body["street"]) {
    $validateLocation($body["street"]);
    $mergeObj["street"] = $body["street"];
}
if($body["house_number"]) {
    $validateHouseNumber($body["house_number"]);
    $mergeObj["number"] = $body["house_number"];
}

foreach($mergeObj as $key => $value) {
    $methodName = "set" . ucfirst($key);
    $targetAddress->$methodName($value);
}

if((bool)$targetAddress->save()) {
    sendResponse(200, false, "Object updated successfully");
} else {
    sendResponse(500, true, "An unexpected error ocurred, try again later");
}
