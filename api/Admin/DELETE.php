<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "DELETE");


$body = bodyParser();

$user = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);

if($user->getUsername() === "root") {

    $targetUser = null;

    if(isset($body["admin_id"])) {
        validateId($body["admin_id"]);
        $targetUser = \Buildings\AdminQuery::create()->findOneById($body["admin_id"]);
    } elseif(isset($body["username"])) {
        validateUsername($body["username"]);
        $targetUser = \Buildings\AdminQuery::create()->findOneByUsername($body["username"]);
    }

    if(!isset($targetUser)) {
        sendResponse(400, true, "User " . $body["username"] . " not found");
    }

    if($targetUser->getUsername() === "root") {
        sendResponse(400, true, "Root cannot be deleted");
    }

    $targetUser->delete();
    sendResponse(200, false, "User " . $body["username"] . " Deleted successfully");
} else {
    sendResponse(403, true, "Only root can delete admins");
}
