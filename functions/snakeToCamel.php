<?php


function snakeToCamel($string)
{
    $split = explode("_", strtolower($string));

    $split = array_map("ucfirst", $split);

    $result = lcfirst(implode("", $split));

    return $result;
}
