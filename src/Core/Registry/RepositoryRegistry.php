<?php

namespace App\Core\Registry;

use App\Core\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

class RepositoryRegistry
{
    /** @var RepositoryInterface[] */
    private $repositories = [];

    public function register(RepositoryInterface $repository): void
    {
        Assert::keyNotExists($this->repositories, $repository->getType());
        $this->repositories[$repository->getType()] = $repository;
    }

    public function getRepository(string $type): RepositoryInterface
    {
        Assert::keyExists($this->repositories, $type);
        return $this->repositories[$type];
    }
}
