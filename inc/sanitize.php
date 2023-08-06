<?php
const FILTERS = [
    'string' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'string[]' => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags' => FILTER_REQUIRE_ARRAY
    ],
    'email' => FILTER_SANITIZE_EMAIL,
    'int' => [
        'filter' => FILTER_SANITIZE_NUMBER_INT,
        'flags' => FILTER_REQUIRE_SCALAR
    ],
    'int[]' => [
        'filter' => FILTER_SANITIZE_NUMBER_INT,
        'flags' => FILTER_REQUIRE_ARRAY
    ],
    'float' => [
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'flags' => FILTER_FLAG_ALLOW_FRACTION
    ],
    'float[]' => [
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'flags' => FILTER_REQUIRE_ARRAY
    ],
    'url' => FILTER_SANITIZE_URL,
];

function array_trim(array $items):array
{
    $result = [];
    foreach ($items as $key => $item)
    {
        if(is_string($item)) $result[$key] = trim($item);
        elseif (is_array($item)) $result[$key] = array_trim($item);
        else $result[$key] = $item;
    }
    return $result;
}

function sanitize(array $inputs, array $fields, array $FILTERS = FILTERS, bool $trim = true ):array
{
    $options = array_map(fn($field) => $FILTERS[$field], $fields);
    $data = filter_var_array($inputs, $options);
    return $trim ? array_trim($data) : $data;
}

