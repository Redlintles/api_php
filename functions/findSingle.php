<?php


function throwNotFoundError($body, $audit)
{

    sendResponse(404, true, "Object not found, If the object exists, have you set any of " . implode(",", array_keys($body)) . "?", [
        "params" => $body
    ], [
        "audit" => $audit
    ]);
}

/**
 * @param array $params the params the object must attend to be valid.
 * @param array $mapping maps $params keys to database column names.
 * @param \Propel\Runtime\ActiveQuery\ModelCriteria $queryObj The query object used to make the requisition.
 * @param bool $throw_error Sends a not found error if the object is not found by default, if set to false, the function returns null instead
 * @return object|null returns the found object or null.
 * @throws \Exception if the object is not found and throw_error is true.
 */
function findSingle(array $params, array $mapping, \Propel\Runtime\ActiveQuery\ModelCriteria $queryObj, bool $throwErr, AuditObj | null $auditObj = null): object | null
{
    $return = null;
    foreach ($params as $key => $value) {
        if (!key_exists($key, $mapping)) {
            continue;
        }
        $methodName = "filterBy" . snakeToCamel($mapping[$key], false);
        if (method_exists($queryObj, $methodName)) {
            $queryObj->$methodName($value);
        }

    }

    $return = $queryObj->findOne();
    if (isset($return)) {
        return $return;
    }

    if ($throwErr) {
        throwNotFoundError($params, $auditObj);
    } else {
        return null;
    }

}
