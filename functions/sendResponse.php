<?php


require_once __DIR__ . "/audit.php";

/**
 * @param int $statusCode The Response Status Code
 * @param bool $err If true, it's an error response
 * @param string $message The message of the response
 * @param array $additionalData The data of the response
 * @param array $auditData Data relative to the auditory
 */

function sendResponse(int $statusCode, bool $err, string $message, array $additionalData = [], array $auditData = [])
{

    if (isset($auditData["audit"])) {
        if (isset($auditData["operation_info"])) {
            $auditData["audit"]->setOperation($auditData["operation_info"]);
        }
        $auditData["audit"]->postAudit($message, $statusCode);
    }
    ob_start();
    header("Content-Type: application/json");
    http_response_code($statusCode);

    $response = [
        "error" => $err,
        "message" => $message,
        "data" => $additionalData
    ];


    echo json_encode($response);
    ob_end_flush();
    exit;
}
