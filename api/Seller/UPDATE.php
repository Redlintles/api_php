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

$body = bodyParser();
$apiKey = $_SERVER["HTTP_X_API_KEY"];
$auditObj = new AuditObj($apiKey, "UPDATE", $request);

permissionValidator($apiKey, "UPDATE");
$auditObj->setOperation("UpdateSeller");

$body = groupValidation($body, [
    "keys" => [
        "seller_id" => "validateInteger",
        "username?" => "validateUsername",
        "email?" => "validateEmail",
        "password?" => "validatePassword",
        "phone_number?" => "validatePhoneNumber"
    ],
    "at_least" => 2,
    "audit" => $auditObj
]);

if (isset($body["username"])) {
    verifyUnicity(\Buildings\SellerQuery::create(), "username", $body["username"]);
}

$targetSeller = findSingle($body, [
    "seller_id" => "id",
], \Buildings\SellerQuery::create(), true, $auditObj);

updateObject($body, [
    "username:unique" => "validateUsername",
    "email" => "validateEmail",
    "password" => "validatePassword",
    "phone_number" => "validatePhoneNumber"
], $targetSeller, [
    "query" => \Buildings\SellerQuery::create(),
    "result" => "seller",
    "success_msg" => "Seller updated successfully",
    "audit" => $auditObj
]);
