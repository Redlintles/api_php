<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/updateObject.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "UPDATE");

$auditObj = new AuditObj($apiKey, "UPDATE", $request);
$auditObj->setOperation("UpdateProduct");
$body = bodyParser();

$targetProduct = findSingle($body, [
    "audit" => $auditObj,
    "keys" => ["product_id" => "validateInteger", "title" => "validateCapitalized"],
    "query" => \Buildings\ProductQuery::create()
]);


updateObject($body, [
    "title:unique" => "validateCapitalized",
    "desc" => function () {},
    "in_stock" => "validateInteger",
    "unity_price" => "validateUnityPrice",

], $targetProduct, [
    "audit" => $auditObj,
    "result" => "product",
    "success_msg" => "Product updated successfully",
    "query" => \Buildings\ProductQuery::create()
]);
