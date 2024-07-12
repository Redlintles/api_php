<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/UpdateObject.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/FindSingle.php";

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


UpdateObject($body, [
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
