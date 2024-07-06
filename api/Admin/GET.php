<?php

require $_SERVER["DOCUMENT_ROOT"] . "/functions/PermissionValidator.php";

$user = \Buildings\AdminQuery::create()->findOneByApiKey($_GET["api_key"]);
$permission = \Buildings\PermissionQuery::create()->findOneByAdminId($user->getId());

permissionValidator($permission, "READ");
if($user->getUsername() === "root") {
    $users = \Buildings\AdminQuery::create()->find()->toJSON();
    http_response_code(200);
    echo $users;
} else {
    http_response_code(200);
    echo json_encode($user->toArray());
}
