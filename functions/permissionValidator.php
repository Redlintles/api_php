<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";

/**
 * Checks if the user has the permissions to do the request, and sends an error response if not.
 * @param string $apiKey the key of the user to check
 * @param string $checkFor the permission to check for, can be CREATE, READ, UPDATE and DELETE.
 */
function permissionValidator(string $apiKey, string $checkFor)
{
    global $request;

    $auditObj = new AuditObj($apiKey, $checkFor, $request);
    $auditObj->setOperation("PermissionCheck");

    $users = \Buildings\AdminQuery::create()->find();
    $userId = -1;

    foreach ($users as $user) {
        $encrypted = $user->getApiKey();
        if (password_verify($apiKey, $encrypted)) {
            $userId = $user->getId();
        }
    }

    if ($userId === -1) {
        sendResponse(403, true, "User not authorized", [], [
            "audit" => $auditObj
        ]);
    }

    $permissionObj = \Buildings\PermissionQuery::create()->findOneByAdminId($userId);

    $permissions = [
        "CREATE" => $permissionObj->getCreatePermission(),
        "READ" => $permissionObj->getReadPermission(),
        "UPDATE" => $permissionObj->getUpdatePermission(),
        "DELETE" => $permissionObj->getDeletePermission(),
    ];

    if ($permissions[$checkFor] === 0) {
        sendResponse(403, true, "User does not have the " . $checkFor . " permission", [], [
            "audit" => $auditObj
        ]);
    }
}
