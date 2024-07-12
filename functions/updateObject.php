<?php


function updateObject(array $body, array $keys, $targetObject, $options)
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/snakeToCamel.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/verifyUnicity.php";
    foreach($keys as $key => $validation) {
        if(preg_match("/:unique/", $key)) {
            $key = explode(":", $key)[0];
            verifyUnicity($options["query"], $key, $body[$key]);
        }
        if(isset($body[$key])) {
            $validation($body[$key]);
            $methodName = "set" . ucfirst(snakeToCamel($key));
            $targetObject->$methodName($body[$key]);
        }
    }

    if($targetObject->save()) {
        sendResponse(200, false, $options["success_msg"], [$options["result"] => $targetObject->toArray()], ["audit" => $options["audit"]]);
    } else {
        sendResponse(500, true, "An unexpected error ocurred, try again later", [], ["audit" => $options["audit"]]);
    }
}
