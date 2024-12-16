<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";

$body = bodyParser();

$apiKey = $_SERVER["HTTP_X_API_KEY"];

$auditObj = new AuditObj($apiKey, "CREATE", $request);
$auditObj->setOperation("CreateAddress");
permissionValidator($apiKey, "CREATE");

$addressObj = groupValidation($body, [
    "keys" => [
        "country" => "validateCapitalized",
        "state" => "validateState",
        "city" => "validateCapitalized",
        "neighborhood" => "validateCapitalized",
        "street" => "validateCapitalized",
        "house_number" => "validateHouseNumber"
    ],
    "audit" => $auditObj,
]);

$obj = new \Buildings\Address();

$obj->setCountry($addressObj["country"]);
$obj->setCity($addressObj["city"]);
$obj->setState($addressObj["state"]);
$obj->setStreet($addressObj["street"]);
$obj->setNeighborhood($addressObj["neighborhood"]);
$obj->setNumber($addressObj["house_number"]);
$obj->save();

if (isset($obj)) {
    sendResponse(200, false, "Address Created Successfully", $obj->toArray(), [], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(500, true, "An unexpected error ocurred", [], [
        "audit" => $auditObj
    ]);
}
