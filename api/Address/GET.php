<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DynamicQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/CollectionToArray.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "READ");

$body = bodyParser();

$queryObj = [];

if(isset($body["country"])) {
    $validateLocation($body["country"]);
    $queryObj["country"] = $body["country"];
}
if(isset($body["state"])) {
    $validateState($body["state"]);
    $queryObj["state"] = $body["state"];
}
if(isset($body["city"])) {
    $validateLocation($body["city"]);
    $queryObj["city"] = $body["city"];
}
if(isset($body["neighborhood"])) {
    $validateLocation($body["neighborhood"]);
    $queryObj["neighborhood"] = $body["neighborhood"];
}
if(isset($body["street"])) {
    $validateLocation($body["street"]);
    $queryObj["street"] = $body["street"];
}
if(isset($body["house_number"])) {
    $validateHouseNumber($body["house_number"]);
    $queryObj["house_number"] = $body["house_number"];
}

$addresses = dynamicQuery(\Buildings\AddressQuery::create(), $queryObj);


if(isset($addresses)) {
    sendResponse(200, false, "Addresses Fetched Successfully", ["addresses" => collectionToArray($addresses)]);
} else {
    sendResponse(404, true, "No addresses where found with the specified criteria");
}
