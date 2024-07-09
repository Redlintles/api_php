<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";

$body = bodyParser();

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "UPDATE");

if(!isset($body["admin_id"])) {
    sendResponse(400, true, "admin_id not defined");
}
if(isset($body["username"])) {
    $validateUsername($body["username"]);
}

if(isset($body["password"])) {
    $validatePassword($body["password"]);
}

$targetUser = \Buildings\AdminQuery::create()->findOneById($body["admin_id"]);
$isRoot = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey)->getUsername() === "root";


if(!isset($targetUser)) {
    sendResponse(400, true, "Admin not found");
}

if($targetUser->getUsername() === "root") {

    if(!$isRoot) {
        sendResponse(400, true, "Only root can change it's own password");
    }
    if(isset($body["username"])) {
        sendResponse(400, true, "Root username cannot be changed, only password");
    }
    if(!isset($body["password"])) {
        sendResponse(400, true, "Root new password not specified");
    } else {
        $targetUser->setPassword($body["password"]);
        $targetUser->save();
        sendResponse(200, false, "Root Password changed successfully");
    }
} elseif(!$isRoot && $targetUser->getApiKey() === $apiKey) {
    if(isset($body["username"])) {
        $targetUser->setUsername($body["username"]);
    }

    if(isset($body["password"])) {
        $targetUser->setPassword($body["password"]);
    }

    $targetUser->save();
    sendResponse(200, false, "You have changed your own username(and/or)password Successfully");
} elseif($isRoot) {
    if(isset($body["username"])) {
        $targetUser->setUsername($body["username"]);
    }

    if(isset($body["password"])) {
        $targetUser->setPassword($body["password"]);
    }
    $targetUser->save();
    sendResponse(200, false, "Root has changed username(and/or)password successfully");

}
