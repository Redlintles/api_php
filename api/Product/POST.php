<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/verifyUnicity.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

$body = bodyParser();

permissionValidator($apiKey, "CREATE");

$auditObj = new AuditObj($apiKey, "CREATE", $request);

function addToProduct()
{
    global $body,$validateInteger,$validateCapitalized,$apiKey,$auditObj;

    $auditObj->setOperation("AddQtd");

    $targetProduct = findSingle($body, [
        "keys" => [
            "product_id" => $validateInteger,
            "title" => $validateCapitalized,
        ],
        "query" => \Buildings\ProductQuery::create(),
        "audit" => $auditObj
    ]);

    if(!isset($body["quantity"])) {
        sendResponse(400, true, "Quantity is not set, it should be an integer greater than zero", [], [
            "audit" => $auditObj
        ]);
    }
    if(!(is_int($body["quantity"]) && (int)$body["quantity"] > 0)) {
        sendResponse(400, true, "quantity field value is not valid", [], [
            "audit" => $auditObj
        ]);
    }
    $oldQuantity = $targetProduct->getInStock();
    $targetProduct->setInStock($oldQuantity + (int)$body["quantity"]);
    if($targetProduct->save()) {
        sendResponse(200, false, $body["quantity"] . " units added to product " . $targetProduct->getTitle() . "(total=" . $targetProduct->getInStock() . ")", $targetProduct->toArray(), [
            "audit" => $auditObj
        ]);
    } else {
        sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
            "audit" => $auditObj
        ]);
    }
}

function createProduct()
{

    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/snakeToCamel.php";

    global $body,$validateInteger,$validateCapitalized,$validateUnityPrice,$apiKey,$auditObj;

    $auditObj->setOperation("CreateProduct");

    $body = groupValidation($body, [
        "keys" => [
            "in_stock" => $validateInteger,
            "title" => $validateCapitalized,
            "description" => function () {},
            "unity_price" => $validateUnityPrice
        ],
        "audit" => $auditObj
    ]);

    verifyUnicity(\Buildings\ProductQuery::create(), "title", $body["title"]);

    $product = new \Buildings\Product();
    foreach($body as $field => $value) {
        $methodName = "set" . ucfirst(snakeToCamel($field));
        $product->$methodName($value);
    }

    if($product->save()) {
        sendResponse(200, false, "Product created successfully", ["product" => $product->toArray()], [
            "audit" => $auditObj
        ]);
    } else {
        sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
            "audit" => $auditObj
        ]);
    }
}
if(!isset($body["type"])) {
    sendResponse(400, true, "Type field is not set in the request body", [], [
        "audit" => $auditObj
    ]);
}

if($body["type"] === "add") {
    addToProduct();
} elseif($body["type"] === "create") {
    createProduct();
} else {
    sendResponse(400, true, "Type field should be 'add' or 'create' ", [], [
        "audit" => $auditObj
    ]);
}
