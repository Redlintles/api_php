<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

$body = bodyParser();


$auditObj = new AuditObj($apiKey, "UPDATE", $request);

$auditObj->setOperation("UpdateAddress");

permissionValidator($apiKey, "UPDATE");

$targetAddress = null;

if(isset($body["address_id"])) {
    $validateInteger($body["address_id"]);
    $targetAddress = \Buildings\AddressQuery::create()->findOneById($body["address_id"]);
}

if(!isset($targetAddress)) {
    sendResponse(400, true, "address could not be found, is address_id set?", [], [
        "audit" => $auditObj
    ]);
}


$mergeObj = [];

if($body["country"]) {
    $validateCapitalized($body["country"]);
    $mergeObj["country"] = $body["country"];
}
if($body["state"]) {
    $validateState($body["state"]);
    $mergeObj["state"] = $body["state"];
}
if($body["city"]) {
    $validateCapitalized($body["city"]);
    $mergeObj["city"] = $body["city"];
}
if($body["neighborhood"]) {
    $validateCapitalized($body["neighborhood"]);
    $mergeObj["neighborhood"] = $body["neighborhood"];
}
if($body["street"]) {
    $validateCapitalized($body["street"]);
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
    sendResponse(200, false, "Object updated successfully", [], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
        "audit" => $auditObj
    ]);
}
