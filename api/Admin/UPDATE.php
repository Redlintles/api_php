<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findAdmin.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/updateObject.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";

$body = bodyParser();

$apiKey = $_SERVER["HTTP_X_API_KEY"];


permissionValidator($apiKey, "UPDATE");
$auditObj = new AuditObj($apiKey, "UPDATE", $request);
$auditObj->setOperation("UpdateAdmin");

if (!isset($body["admin_id"])) {
    sendResponse(400, true, "admin_id not defined", [], [
        "audit" => $auditObj
    ]);
}

$body = groupValidation($body, [
    "keys" => [
        "admin_id" => "validateInteger",
        "username?" => "validateUsername",
        "password?" => "validatePassword",
    ],
    "at_least" => 2,
    "audit" => $auditObj
]);

$targetUser = findSingle($body, [
    "keys" => [
        "admin_id" => "validateInteger"
    ],
    "query" => \Buildings\AdminQuery::create(),
    "audit" => $auditObj
]);

$isRoot = findAdmin($apiKey)->getUsername() === "root";


if (!isset($targetUser)) {
    sendResponse(400, true, "Admin not found", [], [
        "audit" => $auditObj
    ]);
}

if ($targetUser->getUsername() === "root") {

    if (!$isRoot) {
        sendResponse(400, true, "Only root can change it's own password", [], [
            "audit" => $auditObj
        ]);
    }
    if (isset($body["username"])) {
        sendResponse(400, true, "Root username cannot be changed, only password", [], [
            "audit" => $auditObj
        ]);
    }
    if (!isset($body["password"])) {
        sendResponse(400, true, "Root new password not specified", [], [
            "audit" => $auditObj
        ]);
    } elseif ($isRoot) {
        $targetUser->setPassword(password_hash($body["password"], PASSWORD_DEFAULT));
        $targetUser->save();
        sendResponse(200, false, "Root Password changed successfully", ["user" => $targetUser->toArray()], [
            "audit" => $auditObj
        ]);
    }
} elseif (!$isRoot && $targetUser->getApiKey() === $apiKey) {
    if (isset($body["username"])) {
        $targetUser->setUsername($body["username"]);
    }

    if (isset($body["password"])) {
        $targetUser->setPassword($body["password"]);
    }

    $targetUser->save();
    sendResponse(200, false, "You have changed your own username(and/or)password Successfully", [], [
        "audit" => $auditObj
    ]);
} elseif ($isRoot) {
    if (isset($body["username"])) {
        $targetUser->setUsername($body["username"]);
    }

    if (isset($body["password"])) {
        $targetUser->setPassword($body["password"]);
    }
    $targetUser->save();
    sendResponse(200, false, "Root has changed username(and/or)password of ". $targetUser->getUsername() ." successfully", ["user" => $targetUser->toArray()], [
        "audit" => $auditObj
    ]);

}
