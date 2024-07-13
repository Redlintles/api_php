<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "DELETE");

$body = bodyParser();

$auditObj = new AuditObj($apiKey, "DELETE", $request);

$auditObj->setOperation("DeleteProduct");

$targetProduct = findSingle($body, [
    "query" => \Buildings\ProductQuery::create(),
    "keys" => [
        "product_id" => $validateInteger,
        "title" => $validateCapitalized
    ],
    "audit" => "auditObj"
]);

$targetProduct->delete();

if($targetProduct->isDeleted()) {
    sendResponse(200, false, "Product " . $targetProduct->getTitle() ." Deleted successfully", [], ["audit" => $auditObj]);
} else {
    sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
        "audit" => $auditObj
    ]);
}
