<?php

$body = bodyParser();
$apiKey = $_SERVER["HTTP_X_API_KEY"];
$auditObj = new AuditObj($apiKey, "DELETE", $request);
$auditObj->setOperation("DeleteOrder");
permissionValidator($apiKey, "DELETE");

$body = groupValidation($body, [
    "keys" => [
        "order_id" => "validateInteger",
    ],
    "at_least" => 1,
    "audit" => $auditObj
]);

$orderToDelete = findSingle($body, [
    "order_id" => "id"
], \Buildings\OrderQuery::create(), true, $auditObj);

$orderProducts = dynamicQuery(\Buildings\OrderProductQuery::create(), [
    "id_order" => $orderToDelete->getId()
]);

$orderToDelete->delete();

if ($orderToDelete->isDeleted()) {
    sendResponse(200, false, "Order " . $body["order_id"] . " and it's belonging products deleted Successfully", [
        "order" => $orderToDelete->toArray(),
        "order_products" => collectionToArray($orderProducts)
    ], ["audit" => $auditObj]);
}

sendResponse(400, true, "Order could not be deleted", [], ["audit" => $auditObj]);
