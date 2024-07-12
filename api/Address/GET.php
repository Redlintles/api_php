<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DynamicQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/CollectionToArray.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "READ");

$auditObj = new AuditObj($apiKey, "READ", $request);
$auditObj->setOperation("GetAddress");

$body = bodyParser();

$queryObj = [];

if(isset($body["country"])) {
    $validateCapitalized($body["country"]);
    $queryObj["country"] = $body["country"];
}
if(isset($body["state"])) {
    $validateState($body["state"]);
    $queryObj["state"] = $body["state"];
}
if(isset($body["city"])) {
    $validateCapitalized($body["city"]);
    $queryObj["city"] = $body["city"];
}
if(isset($body["neighborhood"])) {
    $validateCapitalized($body["neighborhood"]);
    $queryObj["neighborhood"] = $body["neighborhood"];
}
if(isset($body["street"])) {
    $validateCapitalized($body["street"]);
    $queryObj["street"] = $body["street"];
}
if(isset($body["house_number"])) {
    $validateHouseNumber($body["house_number"]);
    $queryObj["house_number"] = $body["house_number"];
}

$addresses = dynamicQuery(\Buildings\AddressQuery::create(), $queryObj);


if(isset($addresses)) {
    sendResponse(200, false, "Addresses Fetched Successfully", ["addresses" => collectionToArray($addresses)], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(404, true, "No addresses where found with the specified criteria", [], [
        "audit" => $auditObj
    ]);
}
