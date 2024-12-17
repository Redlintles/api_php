<?php

$body = bodyParser();

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "CREATE");

function createProduct()
{

    global $request;

    $apiKey = $_SERVER["HTTP_X_API_KEY"];
    $auditObj = new AuditObj($apiKey, "CREATE", $request);
    $auditObj->setOperation("CreateProduct");

    $body = bodyParser();
    $body = groupValidation($body, [
        "keys" => [
            "in_stock" => 'validateInteger',
            "title" => 'validateCapitalized',
            "unity_price" => 'validateUnityPrice',
        ],
        "audit" => $auditObj
    ]);

    verifyUnicity(\Buildings\ProductQuery::create(), "title", $body["title"]);

    $product = new \Buildings\Product();
    foreach ($body as $field => $value) {
        $methodName = "set" . ucfirst(snakeToCamel($field));
        $product->$methodName($value);
    }

    if ($product->save()) {
        sendResponse(200, false, "Product created successfully", ["product" => $product->toArray()], [
            "audit" => $auditObj
        ]);
    } else {
        sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
            "audit" => $auditObj
        ]);
    }
}
function addToProduct()
{

    global $request;

    $apiKey = $_SERVER["HTTP_X_API_KEY"];
    $auditObj = new AuditObj($apiKey, "CREATE", $request);

    $apiKey = $_SERVER["HTTP_X_API_KEY"];

    $body = bodyParser();

    $auditObj->setOperation("IncQtd");

    $targetProduct = findSingle($body, [
        "product_id" => "id"
    ], \Buildings\ProductQuery::create(), true, $auditObj);

    Validate::validateInteger($body["quantity"]);
    $targetProduct->incrementProduct($body["quantity"]);

    sendResponse(400, true, "Product quantity incremented by " . $body["quantity"] . " Successfully(total=" . $targetProduct->getInStock() . ")", ["product" => $targetProduct->toArray()], [
        "audit" => $auditObj
    ]);
}
if (!isset($body["type"])) {
    sendResponse(400, true, "Type field is not set in the request body", [], [
        "audit" => $auditObj
    ]);
}

if ($body["type"] === "add") {
    addToProduct();
} elseif ($body["type"] === "create") {
    createProduct();
} else {
    sendResponse(400, true, "Type field should be 'add' or 'create' ", [], [
        "audit" => $auditObj
    ]);
}
