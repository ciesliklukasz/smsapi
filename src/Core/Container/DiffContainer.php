<?php

namespace App\Core\Container;

use App\Core\Model\Diff;

class DiffContainer
{
    /** @var Diff[] */
    private $diffs;

    public function addDiff(string $filePath, array $diffs): void
    {
        $this->diffs[$filePath] = $diffs;
    }

    public function getAll(): array
    {
        return $this->diffs;
    }
}
