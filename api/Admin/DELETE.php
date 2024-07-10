<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "DELETE");


$body = bodyParser();

$user = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);
$auditObj = new AuditObj($apiKey, "DELETE", $request);
$auditObj->setOperation("DeleteAdmin");

if($user->getUsername() === "root") {

    $targetUser = null;

    if(isset($body["admin_id"])) {
        $validateInteger($body["admin_id"]);
        $targetUser = \Buildings\AdminQuery::create()->findOneById($body["admin_id"]);
    } elseif(isset($body["username"])) {
        $validateUsername($body["username"]);
        $targetUser = \Buildings\AdminQuery::create()->findOneByUsername($body["username"]);
    }

    if(!isset($targetUser)) {
        sendResponse(400, true, "User not found", [], [
            "audit" => $auditObj
        ]);
    }

    if($targetUser->getUsername() === "root") {
        sendResponse(400, true, "Root cannot be deleted", [], [
            "audit" => $auditObj
        ]);
    }

    $targetUser->delete();
    sendResponse(200, false, "User " . $targetUser->getUsername() . " Deleted successfully", [], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(403, true, "Only root can delete admins", [], [
        "audit" => $auditObj
    ]);
}
