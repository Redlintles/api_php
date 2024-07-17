<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/updateObject.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/verifyUnicity.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "UPDATE");

$auditObj = new AuditObj($apiKey, "UPDATE", $request);
$auditObj->setOperation("UpdateSeller");

$body = bodyParser();

$body = groupValidation($body, [
    "keys" => [
        "seller_id" => $validateInteger,
        "username?" => $validateUsername,
        "email?" => $validateEmail,
        "password?" => $validatePassword,
        "phone_number?" => $validatePhoneNumber
    ],
    "at_least" => 2,
    "audit" => $auditObj
]);

if(isset($body["username"])) {
    verifyUnicity(\Buildings\SellerQuery::create(), "username", $body["username"]);
}

$targetSeller = findSingle($body, [
    "keys" => [
        "seller_id" => $validateInteger
    ],
    "query" => \Buildings\SellerQuery::create(),
    "audit" => $auditObj
]);

updateObject($body, [
    "username:unique" => $validateUsername,
    "email" => $validateEmail,
    "password" => $validatePassword,
    "phone_number" => $validatePhoneNumber
], $targetSeller, [
    "query" => \Buildings\SellerQuery::create(),
    "result" => "seller",
    "success_msg" => "Seller updated successfully",
    "audit" => $auditObj
]);
