<?php

/**
 * @param Propel\Runtime\ActiveQuery\ModelCriteria $queryObj The Object to query
 * @param array $params The Params for the query
 * @return Propel\Runtime\Collection\ObjectCollection $ The Query Result;
 */
function dynamicQuery(Propel\Runtime\ActiveQuery\ModelCriteria $queryObj, array $params): Propel\Runtime\Collection\ObjectCollection
{
    foreach ($params as $key => $value) {
        $methodName = "filterBy" . snakeToCamel($key, false);
        if (is_array($value)) {
            $queryObj->$methodName($value, \Propel\Runtime\ActiveQuery\Criteria::IN);
        } else {
            $queryObj->$methodName($value);
        }

    }
    return $queryObj->find();
}
