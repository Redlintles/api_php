<?php


function verifyUnicity($queryObj, string $key, string $value)
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/snakeToCamel.php";


    $methodName = null;
    if(!preg_match("/id/", $key)) {
        $methodName = "filterBy" . ucfirst(snakeToCamel($key));
    } else {
        return true;
    }

    $result = $queryObj->$methodName($value)->find();
    if(!$result->isEmpty()) {
        sendResponse(400, true, "Field " . $key . " is not unique", [], []);
    }

}
