<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "DELETE");

$auditObj = new AuditObj($apiKey, "DELETE", $request);
$auditObj->setOperation("DeleteSeller");

$body = bodyParser();

$targetObj = findSingle($body, [
    "keys" => [
        "seller_id" => $validateInteger,
        "username" => $validateUsername
    ],
    "audit" => $auditObj,
    "query" => \Buildings\SellerQuery::create()
]);


$targetObj->delete();

if($targetObj->isDeleted()) {
    sendResponse(200, false, "Seller deleted successfully", [
        "seller" => $targetObj->toArray()
    ], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(400, true, "An unexpected error ocurred, try again later", [], [
        "audit" => $auditObj
    ]);
}
