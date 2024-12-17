<?php

$body = bodyParser();
$apiKey = $_SERVER["HTTP_X_API_KEY"];
$auditObj = new AuditObj($apiKey, "DELETE", $request);
$auditObj->setOperation("RemoveOwner");

permissionValidator($apiKey, "DELETE");

$keysArr = [
    "address_id" => "validateInteger",
    "owner_id" => "validateInteger",
    "type" => ["validateIsInArray",["C","S"]],
];

$validatedBody = groupValidation($body, [
    "keys" => $keysArr,
    "at_least" => 3,
    "audit" => $auditObj
]);

$addressOwnerRel = findSingle(
    $validatedBody,
    ["address_id" => "idAddress", "owner_id" => "idOwner"],
    \Buildings\AddressOwnerQuery::create(),
    true,
    $auditObj
);

if (isset($addressOwnerRel)) {
    $addressOwnerRel->delete();
    if ($addressOwnerRel->isDeleted()) {
        sendResponse(200, false, "Address owner rel Deleted successfully", ["rel" => $addressOwnerRel->toArray()], ["audit" => $auditObj]);
    } else {
        sendResponse(500, true, "Address owner could not be deleted, try again later", [], ["audit" => $auditObj]);
    }
} else {
    sendResponse(404, true, "Address owner relationship not found", [], ["audit" => $auditObj]);
}
