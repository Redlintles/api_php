<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/CollectionToArray.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "READ");

$body = bodyParser();

$user = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);


if(isset($user) && $user->getUsername() === "root") {

    $targetUser = null;


    if(isset($body["admin_id"])) {
        $validateId($body["admin_id"]);
        $targetUser = \Buildings\AdminQuery::create()->findOneById($body["admin_id"]);
    } elseif(isset($body["username"])) {
        $validateUsername($body["username"]);
        $targetUser = \Buildings\AdminQuery::create()->findOneByUsername($body["username"]);
    }
    if(!isset($targetUser)) {
        $users = \Buildings\AdminQuery::create()->find();

        $resultUsers = collectionToArray($users);
        sendResponse(200, false, "No criteria specified(admin_id,username) fetching all admins", ["users" => $resultUsers]);
    } else {
        sendResponse(200, false, "Data from " . $targetUser->getUsername() . " Fetched successfully", $targetUser->toArray());
    }
} elseif(isset($user)) {
    sendResponse(200, false, "User data fetched successfully", $user->toArray());
} else {
    sendResponse(404, true, "User does not exists");
}
