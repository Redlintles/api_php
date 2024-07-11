<?php



function findSingle(array $body, array $options)
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/DataValidation.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/snakeToCamel.php";
    $targetObj = null;


    foreach($options["keys"] as $key => $validation) {
        if(isset($body[$key])) {
            $validation($body[$key]);
            $methodName = "findOneById";
            if(!preg_match("/_id/", $key)) {
                $methodName = "findOneBy" . ucfirst(snakeToCamel($body[$key]));
            }
            $targetObj = $options["query"]->$methodName($body[$key]);
        }
        if(isset($targetObj)) {
            break;
        }
    }

    if(!isset($targetObj)) {
        sendResponse(400, true, "Object not found, have you set any of " . implode(",", $options["keys"]) . "?", [], [
            $audit => $options["audit"]
        ]);
    } else {
        return $targetObj;
    }

}
