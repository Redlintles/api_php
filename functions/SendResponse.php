<?php


function sendResponse(int $statusCode, $err, $message, $additionalData = [])
{

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
