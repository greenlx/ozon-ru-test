<?php

//Normally each class should be placed in separate php file.
//But due to test conditions (send the result as one file) this file contains the classes together.

$source = [10, -3, -12, 8, 42, 1, -7, 0, 3];

$finder = new BruteForceMaxSumIntervalKeysFinder($source);
$finder->execute()
    ->printRange()
    ->printSum();


class BruteForceMaxSumIntervalKeysFinder
{
    private array $source;
    private array $range;
    private int $sum = 0;

    public function __construct(array $source)
    {
        $validator = new SourceArrayValidator();
        $validator->validate($source);
        $this->source = $source;
    }

    public function execute(): self
    {
        foreach ($this->source as $key => $el) {
            $currentKey = $key;
            $tempSum    = $el;

            while ($this->issetNextElement($currentKey)) {
                $tempSum    += $this->getNextElement($currentKey);
                $currentKey = $this->getNextKey($currentKey);
                if ($this->sum < $tempSum) {
                    $this->sum   = $tempSum;
                    $this->range = [$key, $currentKey];
                }
            }
        }

        return $this;
    }

    public function printRange(): self
    {
        echo ' Max sum range = [' . $this->range[0] . ', ' . $this->range[1] . ']. ';

        return $this;
    }

    public function printSum(): self
    {
        echo ' Max sum = ' . $this->sum . '. ';

        return $this;
    }

    private function issetNextElement(int $key): bool
    {
        return isset($this->source[$key + 1]);
    }

    private function getNextElement(int $key): int
    {
        if (!$this->issetNextElement($key)) {
            throw new Exception('There is now next element with key ' . (string)($key + 1));
        }

        return $this->source[$key + 1];
    }

    private function getNextKey(int $key): int
    {
        if (!$this->issetNextElement($key)) {
            throw new Exception('There is now key ' . (string)($key + 1));
        }

        return $key + 1;
    }
}


class SourceArrayValidator
{
    public function validate(array $source)
    {
        if (count($source) < 2) {
            throw new Exception('Source array should have at least 2 elements.');
        }

        foreach ($source as $value) {
            if (!is_int($value)) {
                throw new Exception('Source array should contain only int values.');
            }
        }
    }
}
