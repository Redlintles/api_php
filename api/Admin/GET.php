<?php

require $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";


$apiKey = $_SERVER["HTTP_X_API_KEY"];

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
