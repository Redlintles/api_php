<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/Audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/FindSingle.php";

$body = bodyParser();

$apiKey = $_SERVER["HTTP_X_API_KEY"];
$user = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);

$auditObj = new AuditObj($apiKey, "UPDATE", $request);
$auditObj->setOperation("ChangePermission");

if(!isset($user)) {
    sendResponse(404, true, "User not found", [], [
        "audit" => $auditObj
    ]);
}

permissionValidator($apiKey, "UPDATE");

$targetUser = findSingle($body, [
    "keys" => [
        "admin_id" => $validateInteger,
        "username" => $validateUsername
    ],
    "query" => \Buildings\AdminQuery::create(),
    "audit" => $auditObj
]);

if(!isset($body["permission"])) {
    sendResponse(400, true, "permission string not specified", [], [
        "audit" => $auditObj
    ]);
}

$validatePermissionString($body["permission"]);


if($user->getUsername() !== "root") {
    $msg = "Only root can change permissions";
    sendResponse(403, true, "Only root can change permissions", [], [
        "audit" => $auditObj
    ]);
} else {
    if($targetUser->getUsername() === "root") {
        sendResponse(400, true, "Root permissions cannot be changed", [], [
            "audit" => $auditObj
        ]);
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
    ], [
        "audit" => $auditObj
    ]);


}
