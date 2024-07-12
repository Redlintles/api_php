<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/FindSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/UpdateObject.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

$body = bodyParser();

$auditObj = new AuditObj($apiKey, "UPDATE", $request);
$auditObj->setOperation("UpdateAddress");

permissionValidator($apiKey, "UPDATE");

$targetAddress = findSingle($body, [
    "keys" => [
        "address_id" => $validateInteger,
    ],
    "audit" => $auditObj,
    "query" => \Buildings\AddressQuery::create()
]);


$mergeObj = groupValidation($body, [
    "audit" => $auditObj,
    "keys" => [
        "country?" => $validateCapitalized,
        "state?" => $validateState,
        "city?" => $validateCapitalized,
        "neighborhood?" => $validateCapitalized,
        "street?" => $validateCapitalized,
        "house_number?" => $validateHouseNumber
    ],
    "at_least" => 1
]);

if(isset($mergeObj["house_number"])) {
    $mergeObj["number"] = $mergeObj["house_number"];
    unset($mergeObj["house_number"]);
}

UpdateObject($body, [
    "country" => $validateCapitalized,
    "state" => $validateState,
    "city" => $validateCapitalized,
    "neighborhood" => $validateCapitalized,
    "street" => $validateCapitalized,
    "house_number" => $validateHouseNumber
], $targetAddress, [
    "audit" => $auditObj,
    "result" => "address",
    "success_msg" => "Address Updated Successfully",
    "query" => \Buildings\AddressQuery::create(),
]);
