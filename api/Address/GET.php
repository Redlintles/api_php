<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DynamicQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/CollectionToArray.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "READ");

$auditObj = new AuditObj($apiKey, "READ", $request);
$auditObj->setOperation("GetAddress");

$body = bodyParser();

$queryObj = groupValidation($body, [
    "keys" => [
        "country?" => $validateCapitalized,
        "state?" => $validateState,
        "city?" => $validateCapitalized,
        "neighborhood?" => $validateCapitalized,
        "street?" => $validateCapitalized,
        "house_number?" => $validateHouseNumber,

    ],
    "at_least" => 1,
    "audit" => $auditObj
]);
$addresses = dynamicQuery(\Buildings\AddressQuery::create(), $queryObj);


if(isset($addresses)) {
    sendResponse(200, false, "Addresses Fetched Successfully", ["addresses" => collectionToArray($addresses)], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(404, true, "No addresses where found with the specified criteria", [], [
        "audit" => $auditObj
    ]);
}
