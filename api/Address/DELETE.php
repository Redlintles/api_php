<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "DELETE");

$body = bodyParser();

$auditObj = new AuditObj($apiKey, "DELETE", $request);
$auditObj->setOperation("DeleteAddress");

$targetAddress = findSingle($body, [
    "audit" => $auditObj,
    "keys" => ["address_id" => $validateInteger],
    "query" => \Buildings\AddressQuery::create()
]);

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
