<?php

namespace App\Core\Model;

use App\Core\Container\DiffContainer;

class Report
{
    /** @var File */
    private $file;
    /** @var DiffContainer */
    private $diff;

    public function __construct(File $file, DiffContainer $diff)
    {
        $this->file = $file;
        $this->diff = $diff;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function getDiff(): DiffContainer
    {
        return $this->diff;
    }
}
