<?php

namespace App\Core\Model;

class Diff
{
    /** @var int */
    private $diffFileLine;
    /** @var array */
    private $diff;

    public function __construct(int $diffFileLine, array $diff)
    {
        $this->diffFileLine = $diffFileLine;
        $this->diff = $diff;
    }

    public function getDiffFileLine(): int
    {
        return $this->diffFileLine;
    }

    public function getDiff(): array
    {
        return $this->diff;
    }

    public function __toString()
    {
        return 'Different line: ' . $this->getDiffFileLine() . ' Diff: ' . json_encode($this->getDiff()) . PHP_EOL;
    }
}
