<?php

$body = bodyParser();
$apiKey = $_SERVER["HTTP_X_API_KEY"];
$auditObj = new AuditObj($apiKey, "CREATE", $request);

$auditObj->setOperation("CreateOrder");
permissionValidator($apiKey, "CREATE");

$body = groupValidation($body, [
    "keys" => [
        "id_client" => "validateInteger",
        "id_seller" => "validateInteger",
        "expires_at" => "validateDate",
        "type" => ["validateIsInArray", ["client", "company"]],
    ],
    "at_least" => 4,
    "audit" => $auditObj
]);

$seller = findSingle($body, [
    "id_seller" => "id",
], \Buildings\SellerQuery::create(), true, $auditObj);

$client = findSingle($body, [
    "id_client" => "id",
], \Buildings\ClientQuery::create(), true, $auditObj);

$cart = findSingle(["id" => $client->getId()], [
    "id" => "id"
], \Buildings\CartQuery::create(), true, $auditObj);

$cartProducts = dynamicQuery(\Buildings\CartProductQuery::create(), [
    "id_cart" => $cart->getId()
]);


if ($cartProducts->count() == 0) {
    sendResponse(400, true, "Client cart is empty, empty orders are not allowed", [], ["audit" => $auditObj]);
}


$newOrder = new \Buildings\Order();

$newOrder->setType($body["type"]);
$newOrder->setIdClient($body["id_client"]);
$newOrder->setIdSeller($body["id_seller"]);
$newOrder->setExpiresAt($body["expires_at"]);

if ($newOrder->save()) {
    $error = false;
    foreach ($cartProducts as $cartProduct) {
        $orderProduct = new \Buildings\OrderProduct();
        $orderProduct->setIdOrder($newOrder->getId());
        $orderProduct->setQuantity($cartProduct->getQuantity());
        $orderProduct->setIdProduct($cartProduct->getIdProduct());

        if (!$orderProduct->save()) {
            $error = true;
            break;
        }

        $cartProduct->delete();

        if (!$cartProduct->isDeleted()) {
            $error = true;
            break;
        }
    }


    $orderProducts = dynamicQuery(\Buildings\OrderProductQuery::create(), [
        "id_order" => $newOrder->getId(),
    ]);


    sendResponse(201, false, "Order created successfully", [
        "order" => $newOrder->toArray(),
        "order_products" => collectionToArray($orderProducts)
    ], ["audit" => $auditObj]);

} else {
    sendResponse(400, true, "Order could not be created", [], ["audit" => $auditObj]);
}
