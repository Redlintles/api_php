<?php


function UpdateObject(array $body, array $keys, $targetObject, $options)
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/snakeToCamel.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/SendResponse.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/VerifyUnicity.php";
    foreach($keys as $key => $validation) {
        if(preg_match("/:unique/", $key)) {
            $key = explode(":", $key)[0];
            VerifyUnicity($options["query"], $key, $body[$key]);
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
