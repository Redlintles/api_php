<?php

use Buildings\AddressOwner;

$body = bodyParser();
$apiKey = $_SERVER["HTTP_X_API_KEY"];
$auditObj = new AuditObj($apiKey, "CREATE", $request);

permissionValidator($apiKey, "CREATE");

$validated = groupValidation($body, [
    "keys" => [
        "type" => ["validateIsInArray",["C","S"]],
        "owner_id" => "validateInteger",
        "address_id" => "validateInteger"
    ],
    "at_least" => 3,
    "audit" => $auditObj
]);

$address = findSingle(
    $body,
    [
        "audit" => $auditObj,
        "keys" => ["address_id" => "validateInteger"],
        "query" => \Buildings\AddressQuery::create()
    ]
);

$owner = null;

if ($validated["type"] == "C") {
    $owner = findSingle($body, [
        "audit" => $auditObj,
        "keys" => ["owner_id" => "validateInteger"],
        "query" => \Buildings\ClientQuery::create()
    ]);


} elseif ($validated["type"] = "S") {
    $owner = findSingle($body, [
        "audit" => $auditObj,
        "keys" => ["owner_id" => "validateInteger"],
        "query" => \Buildings\SellerQuery::create()
    ]);
}

if (isset($address) && isset($owner)) {
    $addressVerify = \Buildings\AddressOwnerQuery::create()->findByIdAddress($address->getId());


    if (isset($addressVerify)) {
        sendResponse(400, true, "Este endereço já possuí um dono", ["rel" => $addressVerify->toArray()], ["audit" => $auditObj]);
    }
    $addressOwnerObj = new AddressOwner();

    $addressOwnerObj->setIdAddress($address->getId());
    $addressOwnerObj->setType($validated["type"]);
    if ($validated["type"] == "S") {
        $addressOwnerObj->setIdSeller($owner->getId());
    } elseif ($validated["type"] == "C") {
        $addressOwnerObj->setIdClient($owner->getId());
    }

    if ($addressOwnerObj->save()) {
        sendResponse(201, false, "Dono Adicionado com sucesso", ["address" => $address->toArray(), "owner" => $owner->toArray(), "type" => $validated["type"], "rel" => $addressOwnerObj->toArray()], ["audit" => $auditObj]);
    }

} else {
    sendResponse(404, true, "Endereço ou dono não encontrado", [], ["audit" => $auditObj]);
}
