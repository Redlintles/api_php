<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "DELETE");


$body = bodyParser();

$auditObj = new AuditObj($apiKey, "DELETE", $request);
$auditObj->setOperation("DeleteClient");


$targetClient = null;

if(isset($body["client_id"])) {
    $validateInteger($body["client_id"]);
    $targetClient = \Buildings\ClientQuery::create()->findOneById($body["client_id"]);
} elseif(isset($body["username"])) {
    $validateUsername($body["username"]);
    $targetClient = \Buildings\ClientQuery::create()->findOneByUsername($body["username"]);
}

if(!isset($targetClient)) {
    sendResponse(400, true, "User not found, is client_id or username specified?", [], [
        "audit" => $auditObj
    ]);
}

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
