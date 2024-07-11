<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "DELETE");

$body = bodyParser();

$auditObj = new AuditObj($apiKey, "DELETE", $request);

$auditObj->setOperation("DeleteAddress");


$targetAddress = null;

if($body["address_id"]) {
    $validateInteger($body["address_id"]);
    $targetAddress = \Buildings\AddressQuery::create()->findOneById($body["address_id"]);
}

if(!isset($targetAddress)) {
    sendResponse(400, true, "Target address not found, is address_id set?", [], [
        "audit" => $auditObj
    ]);
}

$targetAddress->delete();
if($targetAddress->isDeleted()) {
    sendResponse(200, false, "Address Deleted Successfully", [], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
        "audit" => $auditObj
    ]);
}
