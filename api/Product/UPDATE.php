<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/FindSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/UpdateObject.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "UPDATE");

$auditObj = new AuditObj($apiKey, "UPDATE", $request);
$auditObj->setOperation("UpdateProduct");
$body = bodyParser();

$targetProduct = findSingle($body, [
    "audit" => $auditObj,
    "keys" => ["product_id" => $validateInteger, "title" => $validateLocation],
    "query" => \Buildings\ProductQuery::create()
]);


UpdateObject($body, [
    "title:unique" => $validateLocation,
    "desc" => function () {},
    "in_stock" => $validateInteger,
    "unity_price" => $validateUnityPrice,

], $targetProduct, [
    "audit" => $auditObj,
    "result" => "product",
    "success_msg" => "Product updated successfully",
    "query" => \Buildings\ProductQuery::create()
]);
