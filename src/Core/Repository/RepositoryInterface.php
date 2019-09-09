<?php

namespace App\Core\Repository;

use App\Core\Model\Report;

interface RepositoryInterface
{
    public function save(Report $report): bool;
    public function getType(): string;
}
