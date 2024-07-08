<?php


function collectionToArray(\Propel\Runtime\Collection\Collection $collection)
{
    $result = [];

    foreach($collection as $item) {
        array_push($result, $item->toArray());
    }

    return $result;
}
