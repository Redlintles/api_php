<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";

function permissionValidator(string $apiKey, string $checkFor)
{
    $user = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);
    $permissionObj = \Buildings\PermissionQuery::create()->findOneByAdminId($user->getId());

    $permissions = [
        "CREATE" => $permissionObj->getCreatePermission(),
        "READ" => $permissionObj->getReadPermission(),
        "UPDATE" => $permissionObj->getUpdatePermission(),
        "DELETE" => $permissionObj->getDeletePermission(),
    ];

    if($permissions[$checkFor] === 0) {
        sendResponse(403, true, "User does not have the " . $checkFor . " permission");
    }
}
