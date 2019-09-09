<?php

namespace App;

use App\Core\Builder\FileBuilder;
use App\Core\Comparer\ComparerInterface;
use App\Core\Container\FileContainer;
use App\Core\Model\Report;
use App\Core\Repository\RepositoryInterface;

class Application
{
    /** @var FileBuilder */
    private $builder;
    /** @var ComparerInterface */
    private $comparer;
    /** @var RepositoryInterface */
    private $repository;

    public function __construct(FileBuilder $builder, ComparerInterface $comparer, RepositoryInterface $repository)
    {
        $this->builder = $builder;
        $this->comparer = $comparer;
        $this->repository = $repository;
    }

    public function run(array $data): Report
    {
        $container = new FileContainer();

        foreach ($data as $key => $filePath)
        {
            $file = $this->builder->build($filePath);
            if ($key === 1)
            {
                $container->addFile($file);
            }
            else
            {
                $container->addFileToCompare($file);
            }
        }

        $this->comparer->compare($container);

        $report = new Report($container->getFile(), $this->comparer->getDiffContainer());
        $this->repository->save($report);

        return $report;
    }
}
