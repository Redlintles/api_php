<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "UPDATE");

$body = bodyParser();

$targetClient = null;


if(isset($body["client_id"])) {
    $validateInteger($body["client_id"]);
    $targetClient = \Buildings\ClientQuery::create()->findOneById($body["client_id"]);
}


if(!isset($targetClient)) {
    sendResponse(400, true, "User not found, is client_id specified?");
}

if(isset($body["username"])) {
    $validateUsername($body["username"]);
    $isUnique = \Buildings\ClientQuery::create()->findByUsername($body["username"]);

    if(!$isUnique->isEmpty()) {
        sendResponse(400, true, "Username already exists");
    }
    $targetClient->setUsername($body["username"]);
}
if(isset($body["email"])) {
    $validateEmail($body["email"]);
    $targetClient->setEmail($body["email"]);
}
if(isset($body["password"])) {
    $validateUsername($body["password"]);
    $targetClient->setPassword($body["password"]);
}
if(isset($body["phone_number"])) {
    $validateUsername($body["phone_number"]);
    $targetClient->setPhoneNumber($body["phone_number"]);
}

if((bool)$targetClient->save()) {
    sendResponse(200, false, "Client updated successfully", ["client" => $targetClient->toArray()]);
} else {
    sendResponse(500, true, "An unexpected error ocurred, try again later");
}
