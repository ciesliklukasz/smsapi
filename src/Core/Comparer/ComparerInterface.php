<?php

namespace App\Core\Comparer;

use App\Core\Container\DiffContainer;
use App\Core\Container\FileContainer;

interface ComparerInterface
{
    public function compare(FileContainer $container): void;
    public function getDiffContainer(): DiffContainer;
}
