<?php

$body = bodyParser();

$apiKey = $_SERVER["HTTP_X_API_KEY"];
$auditObj = new AuditObj($apiKey, "READ", $request);
$auditObj->setOperation("GetOrder");
permissionValidator($apiKey, "READ");

$body = groupValidation($body, [
    "keys" => [
        "order_id" => "validateInteger",
    ],
    "at_least" => 1,
    "audit" => $auditObj
]);

$targetOrder = findSingle($body, [
    "order_id" => "id"
], \Buildings\OrderQuery::create(), true, $auditObj);

$orderProducts = dynamicQuery(\Buildings\OrderProductQuery::create(), [
    "id_order" => $targetOrder->getId()
]);

sendResponse(200, false, "Order fetched successfully", ["order" => $targetOrder->toArray(), "order_products" => collectionToArray($orderProducts)], ["audit" => $auditObj]);
