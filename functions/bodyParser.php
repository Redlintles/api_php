<?php


require_once __DIR__ . "/sendResponse.php";
function bodyParser()
{
    $json = file_get_contents("php://input");
    $result = json_decode($json, true);
    if(!isset($result)) {
        sendResponse(400, true, "Request body is not set, it must be a JSON", [], []);
    } else {
        return $result;
    }
}
