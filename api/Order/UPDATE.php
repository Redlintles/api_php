<?php

$body = bodyParser();
$apiKey = $_SERVER["HTTP_X_API_KEY"];
$auditObj = new AuditObj($apiKey, "UPDATE", $request);

permissionValidator($apiKey, "UPDATE");
$auditObj->setOperation("UpdateOrder");

$validatedBody = groupValidation($body, [
    "keys" => [
        "order_id" => "validateInteger",
        "id_client?" => "validateInteger",
        "id_seller?" => "validateInteger",
        "expires_at?" => "validateDate",
        "type?" => ["validateIsInArray", ["company", "client"]],
        "products_operation" => ["validateIsInArray",["add","override","none"]]
    ],
    "at_least" => 3,
    "audit" => $auditObj
]);

$orderToUpdate = findSingle($validatedBody, [
    "order_id" => "id"
], \Buildings\OrderQuery::create(), true, $auditObj);

$orderProducts = dynamicQuery(\Buildings\OrderProductQuery::create(), [
    "id_order" => $orderToUpdate->getId()
]);


updateObject($validatedBody, [
    "id_client" => "validateInteger",
    "id_seller" => "validateInteger",
    "expires_at" => "validateDate",
    "type" => ["validateIsInArray", ["company", "client"]]
], $orderToUpdate, [
    "query" => \Buildings\OrderQuery::create(),
    "success_msg" => "Success",
    "send_response" => false,
]);




foreach ($body["products"] as $product) {
    $p = findSingle(["id" => $product["id"]], ["id" => "id"], \Buildings\ProductQuery::create(), true, $auditObj);

    if ($p->getInStock() < $product["quantity"]) {
        sendResponse(422, true, "Não há quantidade o suficiente do produto " . $p->getTitle() . " Requisitado: " .$product["quantity"] . " Em Estoque: " . $p->getInStock() . ".", [], ["audit" => $auditObj]);
    }
}

if ($body["products_operation"] == "add") {
    foreach ($body["products"] as $product) {
        $p = findSingle(["id" => $product["id"]], ["id" => "id"], \Buildings\ProductQuery::create(), true, $auditObj);
        $orderToUpdate->addProduct($p, $product["quantity"]);
    }
} elseif ($validatedBody["products_operation"] == "override") {
    $orderProducts = dynamicQuery(\Buildings\OrderProductQuery::create(), [
        "id_order" => $orderToUpdate->getId()
    ]);

    foreach ($orderProducts as $p) {
        $p->delete();
    }

    foreach ($body["products"] as $product) {
        $p = findSingle(["id" => $product["id"]], ["id" => "id"], \Buildings\ProductQuery::create(), true, $auditObj);
        $orderToUpdate->addProduct($p, $product["quantity"]);
    }
}

$orderProducts = dynamicQuery(\Buildings\OrderProductQuery::create(), [
    "id_order" => $orderToUpdate->getId()
]);
sendResponse(200, false, "Order Updated Successfully!", [
    "order" => $orderToUpdate->toArray(),
    "order_products" => collectionToArray($orderProducts)
], ["audit" => $auditObj]);
