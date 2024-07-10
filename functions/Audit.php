<?php

function audit(string $apiKey, string $type, string $route, string $data_str)
{
    $audit = new \Buildings\Audit();

    $username = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey)->getUsername();
    $audit->setOperationExecutor($username);
    $audit->setOperationType($type);
    $audit->setOperationRoute($route);
    $audit->setOperationDataString($data_str);
    $audit->save();
}
