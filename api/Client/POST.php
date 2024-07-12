<?php

use Propel\Runtime\Propel;

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/VerifyUnicity.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];
$transaction = Propel::getConnection(\Buildings\Map\ClientTableMap::DATABASE_NAME);

$auditObj = new AuditObj($apiKey, "CREATE", $request);
$auditObj->setOperation("AddClient");

permissionValidator($apiKey, "CREATE");

$body = bodyParser();

$body = groupValidation($body, [
    "keys" => [
        "username" => $validateUsername,
        "password" => $validatePassword,
        "email" => $validateEmail,
        "phone_number" => $validatePhoneNumber,
    ],
    "audit" => $auditObj
]);

$transaction->beginTransaction();

$newClient = new \Buildings\Client();

$newClient->setUsername($body["username"]);
$newClient->setEmail($body["email"]);
$newClient->setPassword($body["password"]);
$newClient->setPhoneNumber($body["phone_number"]);

VerifyUnicity(\Buildings\ClientQuery::create(), "username", $body["username"]);

if((bool)$newClient->save()) {

    $user = \Buildings\ClientQuery::create()->findOneByUsername($newClient->getUsername());


    if(!isset($user)) {
        sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
            "audit" => $auditObj
        ]);
    }

    $cart = new \Buildings\Cart();

    $cart->setIdClient($user->getId());

    if((bool)$cart->save()) {
        $transaction->commit();
        sendResponse(200, false, "Client created successfully", ["client" => $newClient->toArray()], [
            "audit" => $auditObj
        ]);
    } else {
        $transaction->rollBack();
        sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
            "audit" => $auditObj
        ]);
    }
} else {
    $transaction->rollBack();
    sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
        "audit" => $auditObj
    ]);
}
