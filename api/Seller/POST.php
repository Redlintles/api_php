<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/verifyUnicity.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "CREATE");

$auditObj = new AuditObj($apiKey, "CREATE", $request);
$auditObj->setOperation("CreateSeller");

$body = bodyParser();

$body = groupValidation($body, [
    "keys" => [
        "username" => "validateUsername",
        "email" => "validateEmail",
        "password" => "validatePassword",
        "phone_number" => "validatePhoneNumber"
    ],
    "audit" => $auditObj
]);

verifyUnicity(\Buildings\SellerQuery::create(), "username", $body["username"]);

$seller = new \Buildings\Seller();

$seller->setUsername($body["username"]);
$seller->setEmail($body["email"]);
$seller->setPassword($body["password"]);
$seller->setPhoneNumber($body["phone_number"]);

if ($seller->save()) {
    sendResponse(200, false, "Seller created successfully", [
        "seller" => $seller->toArray()
    ], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
        "audit" => $auditObj
    ]);
}
