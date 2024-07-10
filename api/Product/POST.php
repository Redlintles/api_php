<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];


$body = bodyParser();

permissionValidator($apiKey, "CREATE");



function addToProduct()
{
    global $body,$validateInteger,$validateLocation;

    $targetProduct = null;
    if(isset($body["product_id"])) {
        $validateInteger($body["product_id"]);
        $targetProduct = \Buildings\ProductQuery::create()->findOneById($body["product_id"]);
    } elseif(isset($body["title"])) {
        $validateLocation($body["title"]);
        $targetProduct = \Buildings\ProductQuery::create()->findOneByTitle($body["title"]);
    }

    if(!isset($targetProduct)) {
        sendResponse(400, true, "Product could not be found, is product_id or title set?");
    }

    if(!isset($body["quantity"])) {
        sendResponse(400, true, "Quantity is not set, it should be an integer greater than zero");
    }
    if(!(is_int($body["quantity"]) && (int)$body["quantity"] > 0)) {
        sendResponse(400, true, "quantity field value is not valid");
    }
    $oldQuantity = $targetProduct->getInStock();
    $targetProduct->setInStock($oldQuantity + (int)$body["quantity"]);
    if($targetProduct->save()) {
        sendResponse(200, false, $body["quantity"] . " units added to product " . $targetProduct->getTitle() . "(total=" . $targetProduct->getInStock() . ")", $targetProduct->toArray());
    } else {
        sendResponse(500, true, "An unexpected error ocurred, try again later");
    }

}



function createProduct()
{

    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/snakeToCamel.php";

    global $body,$validateInteger,$validateLocation,$validateUnityPrice;

    $keys = ["title","description","in_stock","unity_price"];

    if(count(array_intersect_key($keys, array_keys($body))) !== count($keys)) {
        sendResponse(400, true, "Invalid body, for creating a new product, it should contain title, desc, in_stock and unity_price fields");
    }

    echo (bool)isset($validateInteger);

    $validateInteger($body["in_stock"]);
    $validateLocation($body["title"]);
    $validateUnityPrice($body["unity_price"]);

    $product = new \Buildings\Product();
    foreach($keys as $field) {
        $methodName = "set" . ucfirst(snakeToCamel($field));
        $product->$methodName($body[$field]);
    }

    if($product->save()) {
        sendResponse(200, false, "Product created successfully", ["product" => $product->toArray()]);
    } else {
        sendResponse(500, true, "An unexpected error ocurred, try again later");
    }



}
if(!isset($body["type"])) {
    sendResponse(400, true, "Type field is not set in the request body");
}

if($body["type"] === "add") {
    addToProduct();
} elseif($body["type"] === "create") {
    createProduct();
} else {
    sendResponse(400, true, "Type field should be 'add' or 'create' ");
}
