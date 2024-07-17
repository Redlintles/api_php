<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "DELETE");
$auditObj = new AuditObj($apiKey, "DELETE", $request);
$auditObj->setOperation("DeleteCategory");

$body = bodyParser();

$targetCategory = findSingle($body, [
    "keys" => [
        "category_id" => $validateInteger,
        "name" => $validateCapitalized
    ],
    "audit" => $auditObj,
    "query" => \Buildings\CategoryQuery::create()
]);

$targetCategory->delete();

if($targetCategory->isDeleted()) {
    sendResponse(200, false, "Category deleted successfully", [
        "category" => $targetCategory->toArray(),
    ], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
        "audit" => $auditObj
    ]);
}
