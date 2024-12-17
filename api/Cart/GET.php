<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/collectionToArray.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];
$body = bodyParser();
$auditObj = new AuditObj($apiKey, "READ", $request);

permissionValidator($apiKey, "READ");
$auditObj->setOperation("GetCart");

$targetCart = findSingle($body, [
    "id_client" => "id_client",
], \Buildings\CartQuery::create(), true, $auditObj);

sendResponse(200, false, "Cart fetched successfully", array_merge(["cart" => $targetCart->toArray()], $targetCart->getProducts()), [
    "audit" => $auditObj
]);
