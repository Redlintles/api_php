<?php


require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";

/**
 * Validates a body object based on validation functions, if the validation fails, throws an error
 * @param array $body The body to be validated
 * @param array $options an array which should contain the keys property which is an array of body keys to be validated, and functions to validate that key as values, place ? after the name of the key to mark it as optional the at_least parameter controls the number of minimum matches for the validation to be considered.
 * @return array the validated array
 */
function groupValidation($body, $options): array
{
    $validatedObj = [];

    if (!isset($options["at_least"])) {
        $options["at_least"] = count($options["keys"]);
    }


    if (!isset($options["keys"]) || !isset($options["audit"])) {
        return null;
    }
    foreach ($options["keys"] as $key => $validation) {
        $optional = false;
        if (preg_match("/\?$/", $key)) {
            $key = substr($key, 0, strlen($key) - 1);
            $optional = true;
        }
        if (isset($body[$key])) {

            if (is_array($validation)) {

                $methodName = $validation[0];
                Validate::$methodName($body[$key], $validation[1]);
            } else {

                Validate::$validation($body[$key]);
            }
            $validatedObj[$key] = $body[$key];
        } elseif (!$optional) {
            sendResponse(400, true, "Key " . $key . "Is not set on body", [], ["audit" => $options["audit"]]);
        }
    }

    if (isset($options["at_least"]) && count($validatedObj) < $options["at_least"]) {
        sendResponse(400, true, "At least ". $options["at_least"] . " Key Match(es) are required", [], ["audit" => $options["audit"]]);
    }

    return $validatedObj;
}
