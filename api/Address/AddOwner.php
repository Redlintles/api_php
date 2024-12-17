<?php

use Buildings\AddressOwner;

$body = bodyParser();
$apiKey = $_SERVER["HTTP_X_API_KEY"];
$auditObj = new AuditObj($apiKey, "CREATE", $request);
$auditObj->setOperation("AddOwner");

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
    ["address_id" => "id"],
    \Buildings\AddressQuery::create(),
    true,
    $auditObj
);

$owner = null;

if ($validated["type"] == "C") {
    $owner = findSingle($body, [
        "owner_id" => "id",
    ], \Buildings\ClientQuery::create(), true, $auditObj);


} elseif ($validated["type"] = "S") {
    $owner = findSingle($body, [
        "owner_id" => "id",
    ], \Buildings\SellerQuery::create(), true, $auditObj);
}

if (isset($address) && isset($owner)) {
    $addressVerify = \Buildings\AddressOwnerQuery::create()->findOneByIdAddress($address->getId());


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
