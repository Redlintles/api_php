<?php

use Buildings\Permission;

function permissionValidator(Permission $permissionObj, string $checkFor)
{

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
