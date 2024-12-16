<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/collectionToArray.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "READ");

$body = bodyParser();

$auditObj = new AuditObj($apiKey, "READ", $request);
$auditObj->setOperation("GetClient");
function fetchClientData(\Buildings\Client $targetClient)
{
    $result = [];

    $cart = \Buildings\CartQuery::create()->findOneByIdClient($targetClient->getId());
    $cart_products = \Buildings\CartProductQuery::create()->findByIdCart($cart->getId());
    $orders = \Buildings\OrderQuery::create()->findByIdClient($targetClient->getId());
    $addrs = \Buildings\AddressOwnerQuery::create()->filterByIdClient($targetClient->getId())->find();


    $final_orders = [];

    foreach ($orders as $item) {
        $order = [];
        $order["order"] = $item;
        $order["products"] = collectionToArray(\Buildings\OrderProductQuery::create()->findByIdOrder($item->getId()));
        array_push($final_orders, $order);
    }

    $result = [
        "client" => $targetClient->toArray(),
        "cart" => [
            "cart" => $cart->toArray(),
            "products" => collectionToArray($cart_products)
        ],
        "addresses" => collectionToArray($addrs),
        "orders" => $final_orders
    ];
    return $result;
}

$targetClient = findSingle($body, [
    "keys" => [
        "client_id" => "validateInteger",
        "username" => "validateUsername"
    ],
    "query" => \Buildings\ClientQuery::create(),
    "audit" => $auditObj,
]);

$result = fetchClientData($targetClient);

if (isset($result)) {
    sendResponse(200, false, "Client Data fetched successfully", $result, [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(500, true, "An unexpected Error Ocurred, try again later", [], [
        "audit" => $auditObj
    ]);
}
