<?php

require $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
require $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";

use Ramsey\Uuid\Uuid;

$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "CREATE");

validateUsername($_POST["username"]);
validatePassword($_POST["password"]);
validatePermissionString($_POST["permissions"]);

$permissionString = $_POST["permissions"];

$user = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);


if($user->getUsername() === "root") {

    $data = [
        "username" => $_POST["username"],
        "password" => $_POST["password"],
        "api_key" => Uuid::uuid4()->toString()
    ];


    $usernameExists = \Buildings\AdminQuery::create()->findOneByUsername($data["username"]);

    if(isset($usernameExists)) {
        sendResponse(400, true, "Username already exists");
    }


    $user = new \Buildings\Admin();
    $user->setUsername($data["username"]);
    $user->setPassword($data["password"]);
    $user->setApiKey($data["api_key"]);
    $user->save();

    $userQuery = \Buildings\AdminQuery::create()->findOneByUsername($data["username"]);

    if(isset($userQuery)) {
        $userId = $userQuery->getId();
        $permissionObj = new \Buildings\Permission();
        $permissionObj->setAdminId($userId);
        $permissionObj->setCreatePermission($permissionString[0]);
        $permissionObj->setReadPermission($permissionString[1]);
        $permissionObj->setUpdatePermission($permissionString[2]);
        $permissionObj->setDeletePermission($permissionString[3]);
        $permissionObj->save();

        sendResponse(200, false, "Admin Created Successfully", ["admin" => $user->toArray(), "permissions" => $permissionObj->toArray()]);

    } else {
        sendResponse(500, true, "An unexpected Error Ocurred, try again later");
    }


} else {
    sendResponse(403, true, "Only root can create admins");

}
