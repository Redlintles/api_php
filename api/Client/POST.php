<?php

use Propel\Runtime\Propel;

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
$newClient->setPassword(password_hash($body["password"], PASSWORD_DEFAULT));
$newClient->setPhoneNumber($body["phone_number"]);

verifyUnicity(\Buildings\ClientQuery::create(), "username", $body["username"]);

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
