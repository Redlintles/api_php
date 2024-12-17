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
    "id_client" => "id_client",
], \Buildings\CartQuery::create(), true, $auditObj);
$targetProduct = findSingle($body, [
    "id_product" => "id",
], \Buildings\ProductQuery::create(), true, $auditObj);


$targetCart->addProduct($targetProduct, $body["quantity"]);

$clientUsername = \Buildings\ClientQuery::create()->findOneById($targetCart->getIdClient());

sendResponse(
    200,
    false,
    "Product " . $targetProduct->getTitle() . " Added to " . $clientUsername->getUsername() . "'s cart successfully",
    array_merge(["cart" => $targetCart->toArray()], $targetCart->getProducts()),
    ["audit" => $auditObj]
);
