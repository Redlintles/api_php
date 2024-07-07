<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "DELETE");


$body = bodyParser();

$user = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);

if(isset($user) && $user->getUsername() === "root") {

    if($body["username"] === "root") {
        sendResponse(400, true, "Root cannot be deleted");
    }

    $user = \Buildings\AdminQuery::create()->findOneByUsername($body["username"]);

    if(!isset($user)) {
        sendResponse(400, true, "User " . $body["username"] . " not found");
    } else {
        $user->delete();
        sendResponse(200, false, "User " . $body["username"] . " Deleted successfully");
    }



} elseif(isset($user)) {
    sendResponse(403, true, "Only root can delete admins");
}
