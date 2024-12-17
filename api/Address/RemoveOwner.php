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
    [
     "keys" => $keysArr,
     "audit" => $auditObj,
     "query" => \Buildings\AddressOwnerQuery::create(),

],
    ["throw_error" => true]
);

if (isset($addressOwnerRel)) {
    $addressOwnerRel->delete();
    if ($addressOwnerRel->isDeleted()) {
        sendResponse(200, false, "Addres owner rel Deleted successfully", ["rel" => $addressOwnerRel->toArray()], ["audit" => $auditObj]);
    } else {
        sendResponse(500, true, "Address owner could not be deleted, try again later", [], ["audit" => $auditObj]);
    }
} else {
    sendResponse(404, true, "Address owner relationship not found", [], ["audit" => $auditObj]);
}
