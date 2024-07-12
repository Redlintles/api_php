<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/FindSingle.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "DELETE");

$body = bodyParser();

$auditObj = new AuditObj($apiKey, "DELETE", $request);
$auditObj->setOperation("DeleteClient");

$targetClient = findSingle($body, [
    "keys" => [
        "client_id" => $validateInteger,
        "username" => $validateUsername
    ],
    "query" => \Buildings\ClientQuery::create(),
    "audit" => $auditObj
]);

$targetClient->delete();
if($targetClient->isDeleted()) {
    sendResponse(200, false, "User deleted successfully", ["user" => $targetClient->toArray()], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
        "audit" => $auditObj
    ]);
}
