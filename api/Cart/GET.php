<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/collectionToArray.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "READ");

$body = bodyParser();

$auditObj = new AuditObj($apiKey, "READ", $request);

$auditObj->setOperation("GetCart");

$targetCart = findSingle($body, [
    "keys" => [
        "id_client" => "validateInteger",
    ],
    "audit" => $auditObj,
    "query" => \Buildings\CartQuery::create()
]);

sendResponse(200, false, "Cart fetched successfully", array_merge(["cart" => $targetCart->toArray()], $targetCart->getProducts()), [
    "audit" => $auditObj
]);
