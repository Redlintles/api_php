<?php

function audit(string $apiKey, string $type, string $route, int $httpCode, string $operation, bool $success, string $data = "")
{
    $audit = new \Buildings\Audit();

    $additionalData = ($data ? "/" . $data : "");

    $dataString = ucfirst(explode("/", $type)[1]) . "/" . $operation . "/" . ($success ? "success" : "error") . "/" . $httpCode . $additionalData;
    $username = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey)->getUsername();
    $audit->setOperationExecutor($username);
    $audit->setOperationType($type);
    $audit->setOperationRoute($route);
    $audit->setOperationDataString($dataString);

    $audit->save();
}
