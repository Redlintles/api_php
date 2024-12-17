<?php

/**
 * Converts a snakeCase string to a camelCase string
 * @param string $string the snakeCase string to convert
 * @param bool $lcFirst, default is true, lowerCases the first letter of the result
 * @return string The camelCase String
 */
function snakeToCamel(string $string, bool $lcFirst = true): string
{
    $split = explode("_", strtolower($string));

    $split = array_map("ucfirst", $split);

    $result = implode("", $split);

    if ($lcFirst) {
        $result = lcfirst($result);
    } else {
        $result = ucfirst($result);
    }

    return $result;
}
