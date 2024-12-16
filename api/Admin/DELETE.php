<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findAdmin.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "DELETE");


$body = bodyParser();

$user = findAdmin($apiKey);
$auditObj = new AuditObj($apiKey, "DELETE", $request);
$auditObj->setOperation("DeleteAdmin");

if ($user->getUsername() === "root") {

    $targetUser = findSingle($body, [
        "keys" => [
            "admin_id" => "validateInteger",
            "username" => "validateUsername"
        ],
        "audit" => $auditObj,
        "query" => \Buildings\AdminQuery::create()
    ]);

    if ($targetUser->getUsername() === "root") {
        sendResponse(400, true, "Root cannot be deleted", [], [
            "audit" => $auditObj
        ]);
    }
    sendResponse(200, false, "User " . $targetUser->getUsername() . " Deleted successfully", [], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(403, true, "Only root can delete admins", [], [
        "audit" => $auditObj
    ]);
}
