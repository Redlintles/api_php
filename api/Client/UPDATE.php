<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/updateObject.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "UPDATE");

$body = bodyParser();

$auditObj = new AuditObj($apiKey, "UPDATE", $request);
$auditObj->setOperation("UpdateClient");

$targetClient = findSingle($body, [
    "keys" => [
        "client_id" => $validateInteger
    ],
    "query" => \Buildings\ClientQuery::create(),
    "audit" => $auditObj
]);


updateObject($body, [
    "username:unique" => $validateUsername,
    "password" => $validatePassword,
    "email" => $validateEmail,
    "phone_number" => $validatePhoneNumber,
], $targetClient, [
    "audit" => $auditObj,
    "result" => "client",
    "success_msg" => "Client updated successfully",
    "query" => \Buildings\ClientQuery::create()
]);
