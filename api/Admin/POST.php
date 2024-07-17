<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/groupValidation.php";

use Ramsey\Uuid\Uuid;
use Propel\Runtime\Propel;

$apiKey = $_SERVER["HTTP_X_API_KEY"];

$body = bodyParser();


permissionValidator($apiKey, "CREATE");
$auditObj = new AuditObj($apiKey, "CREATE", $request);
$auditObj->setOperation("AddAdmin");

if(!isset($body["username"]) || !isset($body["password"]) || !isset($body["permissions"])) {
    sendResponse(400, true, "Username,Password or/and Permissions is/are not defined", [], [
        "audit" => $auditObj
    ]);
}


$body = groupValidation($body, [
    "keys" => [
        "username" => $validateUsername,
        "password" => $validatePassword,
        "permissions" => $validatePermissionString
    ],
    "audit" => $auditObj,

]);


$permissionString = $body["permissions"];

$user = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);


if($user->getUsername() === "root") {

    $data = [
        "username" => $body["username"],
        "password" => $body["password"],
        "api_key" => Uuid::uuid4()->toString()
    ];


    $usernameExists = \Buildings\AdminQuery::create()->findOneByUsername($data["username"]);

    if(isset($usernameExists)) {
        sendResponse(400, true, "Username already exists", [], [
            "audit" => $auditObj
        ]);
    }

    $transaction = Propel::getConnection(\Buildings\Map\AdminTableMap::DATABASE_NAME);

    $transaction->beginTransaction();

    $user = new \Buildings\Admin();
    $user->setUsername($data["username"]);
    $user->setPassword(password_hash($data["password"], PASSWORD_DEFAULT));
    $user->setApiKey($data["api_key"]);
    if(!(bool)$user->save()) {
        $transaction->rollBack();
        sendResponse(500, true, "An unexpected error ocurred, try again later", [], [
            "audit" => $auditObj
        ]);
    }


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

        $transaction->commit();

        sendResponse(200, false, "Admin Created Successfully", ["admin" => $user->toArray(), "permissions" => $permissionObj->toArray()], [
            "audit" => $auditObj
        ]);

    } else {
        $transaction->rollBack();
        sendResponse(500, true, "An unexpected Error Ocurred, try again later", [], [
            "audit" => $auditObj
        ]);
    }


} else {
    sendResponse(403, true, "Only root can create admins", [], [
        "audit" => $auditObj
    ]);

}
