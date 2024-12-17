<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "DELETE");

$auditObj = new AuditObj($apiKey, "DELETE", $request);
$auditObj->setOperation("DeleteDiscount");

$body = bodyParser();

$targetDiscount = findSingle($body, [
    "discount_id" => "id",
], \Buildings\DiscountQuery::create(), true, $auditObj);

$targetDiscount->delete();

if ($targetDiscount->isDeleted()) {
    sendResponse(
        200,
        false,
        "Discount deleted successfully",
        [
        "discount" => $targetDiscount->toArray()
    ],
        [
        "audit" => $auditObj
    ]
    );
} else {
    sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
        "audit" => $auditObj
    ]);
}
