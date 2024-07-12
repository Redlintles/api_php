<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/FindSingle.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];


permissionValidator($apiKey, "READ");
$auditObj = new AuditObj($apiKey, "READ", $request);
$auditObj->setOperation("ReadProduct");
$body = bodyParser();

$targetProduct = findSingle($body, [
    "audit" => $auditObj,
    "keys" => ["product_id" => $validateInteger,"title" => $validateCapitalized],
    "query" => \Buildings\ProductQuery::create(),
]);

sendResponse(200, false, "Product found successfully", ["product" => $targetProduct->toArray()], [
    "audit" => $auditObj
]);
