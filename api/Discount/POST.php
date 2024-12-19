<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "CREATE");

$auditObj = new AuditObj($apiKey, "CREATE", $request);
$auditObj->setOperation("CreateDiscount");

$body = bodyParser();

$body = groupValidation($body, [
    "keys" => [
        "type" => ['validateIsInArray',["C", "P"]],
        "category_id?" => 'validateInteger',
        "product_id?" => 'validateInteger',
        "percent" => 'validateInteger',
        "starts_at" => 'validateDate',
        "expires_at" => 'validateDate'
    ],
    "at_least" => 5,
    "audit" => $auditObj
]);
$target = null;

$discount = new \Buildings\Discount();
if ($body["type"] === "C") {
    $discount->setType("C"); // Category
    $discount->setIdCategory($body["category_id"]);
    $target = findSingle($body, [
        "category_id" => "id",
    ], \Buildings\CategoryQuery::create(), true, $auditObj);
} elseif ($body["type"] === "P") {
    $discount->setType("P"); // Products
    $discount->setIdProduct($body["product_id"]);
    $target = findSingle($body, [
        "product_id" => "id",
    ], \Buildings\ProductQuery::create(), true, $auditObj);
}

Validate::validateExpirationTimeBefore($body["starts_at"], $body["expires_at"]);

if (!isset($target)) {
    sendResponse(400, true, "Discount Target not found", [], ["audit" => $auditObj]);
}

if ($body["percent"] > 100 || $body["percent"] < 0) {
    sendResponse(400, true, "Percent value must be between 0% and 100%", [], ["audit" => $auditObj]);
}

$discount->setStartAt($body["starts_at"]);
$discount->setExpiresAt($body["expires_at"]);
$discount->setPercent($body["percent"]);

if ($discount->save()) {
    sendResponse(200, false, "Discount created successfully", ["discount" => $discount->toArray()], ["audit" => $auditObj]);
} else {
    sendResponse(500, true, "An unexpected Error ocurred, try again later", [], ["audit" => $auditObj]);
}
