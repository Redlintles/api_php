<?php


function apiKeyValidator()
{
    $apiKey = $_GET["api_key"];
    echo $apiKey;

    $result = \Buildings\AdminQuery::create()->findOneByApiKey($apiKey);

    if(!isset($result)) {
        $response = [
            "error" => true,
            "message" => "Invalid API Key, Unauthorized"
        ];

        http_response_code(403);

        echo json_encode($response);
    }
}
