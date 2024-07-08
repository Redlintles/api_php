<?php

use Buildings\Permission;

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";

function formatPermission(Permission $permissionObj)
{
    return $permissionObj->getCreatePermission() . $permissionObj->getReadPermission() . $permissionObj->getUpdatePermission() . $permissionObj ->getDeletePermission();
}
$body = bodyParser();

$apiKey = $_SERVER["HTTP_X_API_KEY"];


permissionValidator($apiKey, "READ");

$user = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);
$targetUser = null;
$target = false;
if(isset($body["admin_id"])) {
    $targetUser = \Buildings\AdminQuery::create()->findOneById($body["admin_id"]);
    $target = true;
} elseif(isset($body["username"])) {
    $targetUser = \Buildings\AdminQuery::create()->findOneByUsername($body["username"]);
    $target = true;
}

if($user->getUsername() !== "root" && isset($targetUser)) {
    sendResponse(403, true, "Only Root can check for others permissions, if you want to check about your own permissions, send a empty body request");
}

if($user->getUsername() === "root" && isset($targetUser)) {
    $targetPermissions = \Buildings\PermissionQuery::create()->findOneByAdminId($targetUser->getId());
    sendResponse(200, false, $targetUser->getUsername() . " Permissions fetched successfully", ["permissions" => formatPermission($targetPermissions)]);
}

if($user->getUsername() !== "root") {
    $targetPermissions = \Buildings\PermissionQuery::create()->findOneByAdminId($user->getId());
    sendResponse(200, false, $user->getUsername() . " Permissions fetched successfully", ["permissions" => formatPermission($targetPermissions)]);
}

if($user->getUsername() === "root" && !isset($targetUser) && $target) {
    sendResponse(404, false, "User not found");
}
if($user->getUsername() === "root" && !isset($targetUser) && !$target) {
    $resultPermissions = \Buildings\PermissionQuery::create()->find();

    $resultUsers = [];

    foreach($resultPermissions as $item) {
        $obj = [];

        $obj["user"] = \Buildings\AdminQuery::create()->findOneById($item->getAdminId())->getUsername();
        $obj["permission"] = formatPermission($item);

        array_push($resultUsers, $obj);
    }

    sendResponse(200, false, "No criteria specified(admin_id, username) then returning all  users permissions", ["permissions" => $resultUsers]);
}
