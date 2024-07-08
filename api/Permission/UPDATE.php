<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";


$body = bodyParser();

$apiKey = $_SERVER["HTTP_X_API_KEY"];
$user = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);

if(!isset($user)) {
    sendResponse(404, true, "User not found");
}

permissionValidator($apiKey, "UPDATE");

$targetUser = null;

if(isset($body["admin_id"])) {
    validateId($body["admin_id"]);
    $targetUser = \Buildings\AdminQuery::create()->findOneById($body["admin_id"]);
} elseif(isset($body["username"])) {
    validateUsername($body["username"]);
    $targetUser = \Buildings\AdminQuery::create()->findOneByUsername($body["username"]);
} else {
    sendResponse(400, true, "No criteria for target user specified, body must contain either admin_id or username keys");
}

if(!isset($targetUser)) {
    sendResponse(404, true, "Target user not found");
}

if(!isset($body["permission"])) {
    sendResponse(400, true, "permission string not specified");
}

validatePermissionString($body["permission"]);


if($user->getUsername() !== "root") {
    sendResponse(403, true, "Only root can change permissions");
} else {
    if($targetUser->getUsername() === "root") {
        sendResponse(400, true, "Root permissions cannot be changed");
    }

    $permissionObj = \Buildings\PermissionQuery::create()->findOneByAdminId($targetUser->getId());

    $prm = $body["permission"];
    $permissionObj->setCreatePermission($prm[0]);
    $permissionObj->setReadPermission($prm[1]);
    $permissionObj->setUpdatePermission($prm[2]);
    $permissionObj->setDeletePermission($prm[3]);

    $permissionObj->save();

    sendResponse(200, false, $targetUser->getUsername() . " permissions changed successfully", [
        "user" => $targetUser->getUsername(),
        "permission" => $permissionObj->toArray()
    ]);


}
