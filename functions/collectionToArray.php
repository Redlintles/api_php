<?php

/**
 * @param Propel\Runtime\Collection\Collection $collection, Converts a propel collection to a PHP Array
 * @return array The converted collection
 */
function collectionToArray(\Propel\Runtime\Collection\Collection $collection): array
{
    $result = [];

    foreach ($collection as $item) {
        array_push($result, $item->toArray());
    }

    return $result;
}
