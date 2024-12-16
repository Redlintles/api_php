<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

$auditObj = new AuditObj($apiKey, "CREATE", $request);

$auditObj->setOperation("AddCartProduct");

$body = bodyParser();


$body = groupValidation($body, [
    "keys" => [
        "id_client" => "validateInteger",
        "product_id" => "validateInteger",
        "quantity" => "validateInteger"
    ],
    "audit" => $auditObj
]);

$targetCart = findSingle($body, [
    "keys" => [
        "id_client" => "validateInteger"
    ],
    "query" => \Buildings\CartQuery::create(),
    "audit" => $auditObj
]);

$targetProduct = findSingle($body, [
    "keys" => [
        "product_id" => "validateInteger",
    ],
    "query" => \Buildings\ProductQuery::create(),
    "audit" => $auditObj
]);

$targetCart->addProduct($targetProduct, $body["quantity"]);

$clientUsername = \Buildings\ClientQuery::create()->findOneById($targetCart->getIdClient());

sendResponse(
    200,
    false,
    "Product " . $targetProduct->getTitle() . " Added to " . $clientUsername->getUsername() . "'s cart successfully",
    array_merge(["cart" => $targetCart->toArray()], $targetCart->getProducts()),
    ["audit" => $auditObj]
);
