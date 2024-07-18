<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";

function groupValidation($body, $options)
{
    $validatedObj = [];

    if(!isset($options["at_least"])) {
        $options["at_least"] = count($options["keys"]);
    }


    if(!isset($options["keys"]) || !isset($options["audit"])) {
        return null;
    }
    foreach($options["keys"] as $key => $validation) {
        $optional = false;
        if(preg_match("/\?$/", $key)) {
            $key = substr($key, 0, strlen($key) - 1);
            $optional = true;
        }
        if(isset($body[$key])) {

            if(is_array($validation)) {
                $validation[0]($body[$key], $validation[1]);
            } else {
                $validation($body[$key]);
            }
            $validatedObj[$key] = $body[$key];
        } elseif(!$optional) {
            sendResponse(400, true, "Key " . $key . "Is not set on body", [], ["audit" => $options["audit"]]);
        }
    }

    if(isset($options["at_least"]) && count($validatedObj) < $options["at_least"]) {
        sendResponse(400, true, "At least ". $options["at_least"] . " Key Match(es) are required", [], ["audit" => $options["audit"]]);
    }

    return $validatedObj;
}
