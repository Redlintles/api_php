<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];


permissionValidator($apiKey, "READ");
$auditObj = new AuditObj($apiKey, "READ", $request);
$auditObj->setOperation("ReadProduct");
$body = bodyParser();

$targetProduct = null;

if(isset($body["product_id"])) {
    $validateInteger($body["product_id"]);
    $targetProduct = \Buildings\ProductQuery::create()->findOneById($body["product_id"]);
} elseif(isset($body["title"])) {
    $validateLocation($body["title"]);
    $targetProduct = \Buildings\ProductQuery::create()->findOneById($body["title"]);
}

if(!isset($targetProduct)) {
    sendResponse(400, true, "Target product is not found", [], [
        "audit" => $auditObj
    ]);
}

sendResponse(200, false, "Product found successfully", ["product" => $targetProduct->toArray()], [
    "audit" => $auditObj
]);
