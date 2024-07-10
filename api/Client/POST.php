<?php

use Propel\Runtime\Propel;

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];
$transaction = Propel::getConnection(\Buildings\Map\ClientTableMap::DATABASE_NAME);

$auditObj = new AuditObj($apiKey, "CREATE", $request);

$auditObj->setOperation("AddClient");

permissionValidator($apiKey, "CREATE");


$body = bodyParser();

$keys = ["username", "password", "email", "phone_number"];

if(array_keys($body) !== $keys) {
    sendResponse(400, true, "Client data not specified, body must contain username,password,email and phone_number", [], [
        "audit" => $auditObj
    ]);
}

$validateUsername($body["username"]);
$validateEmail($body["email"]);
$validatePassword($body["password"]);
$validatePhoneNumber($body["phone_number"]);

$transaction->beginTransaction();

$newClient = new \Buildings\Client();

$newClient->setUsername($body["username"]);
$newClient->setEmail($body["email"]);
$newClient->setPassword($body["password"]);
$newClient->setPhoneNumber($body["phone_number"]);


$usernameExists = \Buildings\ClientQuery::create()->filterByUsername($body["username"])->find();

if(!$usernameExists->isEmpty()) {
    sendResponse(400, true, "Username already exists, choose another", [], [
        "audit" => $auditObj
    ]);
}

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
