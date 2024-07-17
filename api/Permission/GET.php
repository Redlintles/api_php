<?php

use Buildings\Permission;

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findAdmin.php";

function formatPermission(Permission $permissionObj)
{
    return $permissionObj->getCreatePermission() . $permissionObj->getReadPermission() . $permissionObj->getUpdatePermission() . $permissionObj ->getDeletePermission();
}
$body = bodyParser();

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "READ");
$auditObj = new AuditObj($apiKey, "READ", $request);
$auditObj->setOperation("GetPermission");

$user = findAdmin($apiKey);
$targetUser = findSingle($body, [
    "keys" => [
        "admin_id" => $validateInteger,
        "username" => $validateUsername
    ],
    "query" => \Buildings\AdminQuery::create(),
    "audit" => $auditObj
]);

if(isset($targetUser)) {
    $target = true;
} else {
    $target = false;
}

if($user->getUsername() !== "root" && isset($targetUser)) {
    sendResponse(403, true, "Only Root can check for others permissions, if you want to check about your own permissions, send a empty body request", [], [
        "audit" => $auditObj
    ]);
}

if($user->getUsername() === "root" && isset($targetUser)) {
    $targetPermissions = \Buildings\PermissionQuery::create()->findOneByAdminId($targetUser->getId());

    sendResponse(200, false, $targetUser->getUsername() . " Permissions fetched successfully", ["permissions" => formatPermission($targetPermissions)], [], [
        "audit" => $auditObj,
        "operation_info" => "GetSingle"
    ]);
}

if($user->getUsername() !== "root") {
    $targetPermissions = \Buildings\PermissionQuery::create()->findOneByAdminId($user->getId());
    sendResponse(200, false, $user->getUsername() . " Permissions fetched successfully", ["permissions" => formatPermission($targetPermissions)], [
        "audit" => $auditObj,
        "operation_info" => "GetSingle"
    ]);
}

if($user->getUsername() === "root" && !isset($targetUser) && $target) {
    sendResponse(404, false, "User not found", [], [
        "audit" => $auditObj,
    ]);
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


    sendResponse(200, false, "No criteria specified(admin_id, username) then returning all  users permissions", ["permissions" => $resultUsers], [
        "audit" => $auditObj,
        "operation_info" => "GetAll"
    ]);
}
