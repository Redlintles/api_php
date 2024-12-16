<?php

/**
 * Validates Updates an object with the passed in data, and returns the appropiated response if it succeeds or fails
 * @param array $body The object with the newer data
 * @param array $keys The keys to validate if :unique is present, verify the Unicity of the new value in case that key must remain unique
 * @param object $targetObject the object to update(where the set methods will be called)
 * @param array $options an array with query(the propel query obj), success_msg, result species the key name and audit specify the audit object for the operation
 */
function updateObject(array $body, array $keys, object $targetObject, array $options)
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/dataValidation.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/snakeToCamel.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/verifyUnicity.php";
    foreach ($keys as $key => $validation) {
        if (preg_match("/:unique/", $key)) {
            $key = explode(":", $key)[0];
            verifyUnicity($options["query"], $key, $body[$key]);
        }
        if (isset($body[$key])) {
            $validation($body[$key]);
            $methodName = "set" . ucfirst(snakeToCamel($key));
            $targetObject->$methodName($body[$key]);
        }
    }

    if ($targetObject->save()) {
        sendResponse(200, false, $options["success_msg"], [$options["result"] => $targetObject->toArray()], ["audit" => $options["audit"]]);
    } else {
        sendResponse(500, true, "An unexpected error ocurred, try again later", [], ["audit" => $options["audit"]]);
    }
}
