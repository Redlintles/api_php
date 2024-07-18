<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/updateObject.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dynamicQuery.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "UPDATE");

$auditObj = new AuditObj($apiKey, "UPDATE", $request);
$auditObj->setOperation("UpdateProductCategories");

$body = bodyParser();

$targetProduct = findSingle($body, [
    "keys" => [
        "product_id" => $validateInteger,
        "title" => $validateCapitalized
    ],
    "audit" => $auditObj,
    "query" => \Buildings\ProductQuery::create()
]);
