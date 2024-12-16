<?php

/**
 * Verifies the unicity a newer value in the database, sends an error response if not
 * @param \Propel\Runtime\ActiveQuery\ModelCriteria $queryObj The query object in which the verification will be performed
 * @param string $key the key of the object to check
 * @param string $value the value of the key which should be checked
 * @return bool True if the check succeds
 */
function verifyUnicity(\Propel\Runtime\ActiveQuery\ModelCriteria $queryObj, string $key, string $value)
{
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/sendResponse.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/functions/snakeToCamel.php";


    $methodName = null;
    if (!preg_match("/id/", $key)) {
        $methodName = "filterBy" . ucfirst(snakeToCamel($key));
    } else {
        return true;
    }

    $result = $queryObj->$methodName($value)->find();
    if (!$result->isEmpty()) {
        sendResponse(400, true, "Field " . $key . " is not unique", [], []);
    }

}
