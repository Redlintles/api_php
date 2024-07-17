<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/permissionValidator.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/bodyParser.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/collectionToArray.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/audit.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findSingle.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/findAdmin.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];

permissionValidator($apiKey, "READ");

$body = bodyParser();
$auditObj = new AuditObj($apiKey, "READ", $request);
$auditObj->setOperation("ReadAdmin");

$user = findAdmin($apiKey);


if(isset($user) && $user->getUsername() === "root") {

    $targetUser = findSingle($body, [
        "keys" => [
            "admin_id" => $validateInteger,
            "username" => $validateUsername,
        ],
        "audit" => $auditObj,
        "query" => \Buildings\AdminQuery::create(),
        "throw_error" => false
    ]);

    if(!isset($targetUser)) {
        $users = \Buildings\AdminQuery::create()->find();

        $resultUsers = collectionToArray($users);
        sendResponse(200, false, "No criteria specified(admin_id,username) fetching all admins", ["users" => $resultUsers], [
            "audit" => $auditObj
        ]);
    } else {
        sendResponse(200, false, "Data from " . $targetUser->getUsername() . " Fetched successfully", $targetUser->toArray(), [
            "audit" => $auditObj
        ]);
    }
} elseif(isset($user)) {
    sendResponse(200, false, "User data fetched successfully", $user->toArray(), [], [
        "audit" => $auditObj
    ]);
} else {
    sendResponse(404, true, "User does not exists", [], [
        "audit" => $auditObj,
    ]);
}
