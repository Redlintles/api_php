<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";

$body = bodyParser();
$apiKey = $_SERVER["HTTP_X_API_KEY"];
$auditObj = new AuditObj($apiKey, "DELETE", $request);

permissionValidator($apiKey, "DELETE");
$auditObj->setOperation("DeleteCategory");


$targetCategory = findSingle($body, [
    "category_id" => "id",
], \Buildings\CategoryQuery::create(), true, $auditObj);

$targetCategory->delete();

if ($targetCategory->isDeleted()) {
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
