<?php


require_once __DIR__ . "/sendResponse.php";
/**
 * @return array Decodes the req body as JSON and returns an associative Array
 */
function bodyParser()
{
    $json = file_get_contents("php://input");
    $result = json_decode($json, true);
    if (!isset($result)) {
        sendResponse(400, true, "Request body is not set, it must be a JSON", [], []);
    } else {
        return $result;
    }
}
