<?php

use Buildings\Permission;

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

        $response = [
            "error" => true,
            "message" => "User does not have the " . $checkFor . " permission"
        ];

        http_response_code(403);

        echo json_encode($response);
        exit;
    }
}
