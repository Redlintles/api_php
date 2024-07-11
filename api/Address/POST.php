<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";

$body = bodyParser();

$apiKey = $_SERVER["HTTP_X_API_KEY"];

$auditObj = new AuditObj($apiKey, "CREATE", $request);
$auditObj->setOperation("CreateAddress");
permissionValidator($apiKey, "CREATE");

$addressObj = [];
if(isset($body["country"])) {
    $validateLocation($body["country"]);
    $addressObj["country"] = $body["country"];
}
if(isset($body["state"])) {
    $validateState($body["state"]);
    $addressObj["state"] = $body["state"];
}
if(isset($body["city"])) {
    $validateLocation($body["city"]);
    $addressObj["city"] = $body["city"];
}
if(isset($body["neighborhood"])) {
    $validateLocation($body["neighborhood"]);
    $addressObj["neighborhood"] = $body["neighborhood"];
}
if(isset($body["street"])) {
    $validateLocation($body["street"]);
    $addressObj["street"] = $body["street"];
}
if(isset($body["house_number"])) {
    $validateHouseNumber($body["house_number"]);
    $addressObj["number"] = $body["house_number"];
}

$obj = new \Buildings\Address();

$obj->setCountry($addressObj["country"]);
$obj->setCity($addressObj["city"]);
$obj->setState($addressObj["state"]);
$obj->setStreet($addressObj["street"]);
$obj->setNeighborhood($addressObj["neighborhood"]);
$obj->setNumber($addressObj["number"]);
$obj->save();

if(isset($obj)) {
    sendResponse(200, false, "Address Created Successfully", $obj->toArray(), [], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(500, true, "An unexpected error ocurred", [], [
        "audit" => $auditObj
    ]);
}
