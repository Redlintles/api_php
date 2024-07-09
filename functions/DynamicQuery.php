<?php


function dynamicQuery($queryObj, $params)
{
    foreach($params as $key => $value) {
        if(is_array($value)) {
            $queryObj->filterBy($key, $value, \Propel\Runtime\ActiveQuery\Criteria::IN);
        } else {
            $queryObj->filterBy($key, $value);
        }
    }
    return $queryObj->find();
}
