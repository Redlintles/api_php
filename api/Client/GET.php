<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/CollectionToArray.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";

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

    foreach($orders as $item) {
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


$targetClient = null;

if(isset($body["client_id"])) {
    $validateInteger($body["client_id"]);
    $targetClient = \Buildings\ClientQuery::create()->findOneById($body["client_id"]);
} elseif(isset($body["username"])) {
    $validateUsername($body["username"]);
    $targetClient =  \Buildings\ClientQuery::create()->findOneByUsername($body["username"]);
}

if(!isset($targetClient)) {
    sendResponse(400, true, "Client not found, is criteria(client_id,username) specified?", [], [
        "audit" => $auditObj
    ]);
}

$result = fetchClientData($targetClient);

if(isset($result)) {
    sendResponse(200, false, "Client Data fetched successfully", $result, [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(500, true, "An unexpected Error Ocurred, try again later", [], [
        "audit" => $auditObj
    ]);
}
