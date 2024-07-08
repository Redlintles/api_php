<?php

use Propel\Runtime\ActiveQuery\Criteria;

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "READ");

$user = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);

if(isset($user) && $user->getUsername() === "root") {
    $users = \Buildings\AdminQuery::create()->find();

    $resultUsers = [];

    foreach($users as $admin) {
        $obj = $admin->toArray();
        array_push($resultUsers, $obj);
    }
    sendResponse(200, false, "Users fetched successfully", ["users" => $resultUsers]);
} elseif(isset($user)) {
    sendResponse(200, false, "User data fetched successfully", $user->toArray());
} else {
    sendResponse(404, true, "User does not exists");
}
