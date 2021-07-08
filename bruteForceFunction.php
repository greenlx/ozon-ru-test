<?php

$source = [10, -3, -12, 8, 42, 1, -7, 0, 3];

bruteForce($source);

function bruteForce(array $source): void
{
    if (count($source) < 2) {
        throw new Exception('Source array should have at least 2 elements.');
    }

    foreach ($source as $value) {
        if (!is_int($value)) {
            throw new Exception('Source array should contain only int values.');
        }
    }

    $range = [];
    $sum   = 0;

    foreach ($source as $key => $el) {
        $currentKey = $key;
        $tempSum    = $el;

        while (isset($source[$currentKey + 1])) {
            $tempSum    += $source[$currentKey + 1];
            $currentKey = $currentKey + 1;
            if ($sum < $tempSum) {
                $sum   = $tempSum;
                $range = [$key, $currentKey];
            }
        }
    }

    echo ' Max sum range = [' . $range[0] . ', ' . $range[1] . ']. ';
    echo ' Max sum = ' . $sum . '. ';
}
