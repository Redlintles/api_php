<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];
$body = bodyParser();
$auditObj = new AuditObj($apiKey, "DELETE", $request);

permissionValidator($apiKey, "DELETE");
$auditObj->setOperation("DeleteOrDecrementProduct");

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

$targetCart->removeProduct($targetProduct, isset($body["quantity"]) ? $body["quantity"] : null);


$clientUsername = \Buildings\ClientQuery::create()->findOneById($targetCart->getIdClient())->getUsername();
sendResponse(
    200,
    false,
    "Product " .$targetProduct->getTitle(). " Removed from " . $clientUsername ."'s cart",
    array_merge(
        ["product" => $targetProduct->toArray()],
        $targetCart->getProducts()
    ),
    ["audit" => $auditObj]
);
