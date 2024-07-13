<?php

use Symfony\Component\Validator\Constraints\Optional;

/**
 * @param array $body
 * @param array $options
 * @return object|null returns the found object or null
 * @throws \Exception if the object is not found and throw_error is true
 */

function findSingle(array $body, array $options)
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/snakeToCamel.php";
    $targetObj = null;

    if(!isset($options["throw_error"])) {
        $options["throw_error"] = true;
    }

    foreach($options["keys"] as $key => $validation) {
        if(isset($body[$key])) {
            $validation($body[$key]);
            $methodName = "findOneById";
            if(!preg_match("/_id/", $key)) {
                $methodName = "findOneBy" . ucfirst(snakeToCamel($key));
            }
            $targetObj = $options["query"]->$methodName($body[$key]);
        }
        if(isset($targetObj)) {
            break;
        }
    }

    if(!isset($targetObj) && $options["throw_error"]) {
        sendResponse(400, true, "Object not found, have you set any of " . implode(",", array_keys($options["keys"])) . "?", [], [
            $audit => $options["audit"]
        ]);
        throw new Exception("Object not found");
    } elseif(!isset($targetObj)) {
        return null;
    }
    return $targetObj;

}
