<?php

require $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";


$apiKey = $_GET["api_key"];

permissionValidator($apiKey, "READ");

$user = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);

if($user->getUsername() === "root") {
    $users = \Buildings\AdminQuery::create()->find()->toJSON();
    http_response_code(200);
    echo $users;
} else {
    http_response_code(200);
    echo json_encode($user->toArray());
}
