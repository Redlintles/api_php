<?php


require_once __DIR__ . "/Audit.php";

function sendResponse(int $statusCode, bool $err, string $message, array $additionalData = [], array $auditData = [])
{


    if(isset($auditData["operation_info"])) {
        $auditData["audit"]->setOperation($auditData["operation_info"]);
    }
    $auditData["audit"]->postAudit($message, $statusCode);
    ob_start();
    header("Content-Type: application/json");
    http_response_code($statusCode);

    $response = [
        "error" => $err,
        "message" => $message
    ];
    $final = array_merge($response, $additionalData);

    echo json_encode($final);
    ob_end_flush();
    exit;
}
