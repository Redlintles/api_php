<?php


require_once "./Audit.php";

function sendResponse(int $statusCode, bool $err, string $message, array $additionalData = [], array $auditData = [])
{


    if(isset($additionalData["operation_info"])) {
        $additionalData["audit"]->setOperation($additionalData["operation_info"]);
    }
    $additionalData["audit"]->postAudit($message, $statusCode);
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
