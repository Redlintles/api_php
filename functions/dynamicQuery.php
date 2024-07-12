<?php


function dynamicQuery($queryObj, $params)
{
    foreach($params as $key => $value) {
        $methodName = "filterBy" . ucfirst($key);
        if(is_array($value)) {
            $queryObj->$methodName($value, \Propel\Runtime\ActiveQuery\Criteria::IN);
        } else {
            $queryObj->$methodName($value);
        }

    }
    return $queryObj->find();
}
