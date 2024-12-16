<?php

/**
 * Converts a snakeCase string to a camelCase string
 * @param string $string the snakeCase string to convert
 * @return string The camelCase String
 */
function snakeToCamel(string $string): string
{
    $split = explode("_", strtolower($string));

    $split = array_map("ucfirst", $split);

    $result = lcfirst(implode("", $split));

    return $result;
}
