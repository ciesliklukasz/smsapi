<?php

namespace Test\Core\Registry;

use App\Core\Registry\RepositoryRegistry;
use App\Infrastructure\Repository\FileRepository;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RepositoryRegistryTest extends TestCase
{
    /** @var RepositoryRegistry */
    private $registry;

    protected function setUp(): void
    {
        $this->registry = new RepositoryRegistry();
    }

    public function testRegistryRepository(): void
    {
        $repository = new FileRepository();
        $this->registry->register($repository);

        $this->assertInstanceOf(FileRepository::class, $this->registry->getRepository($repository->getType()));
    }

    public function testFailedRegistryRepository(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $repository = new FileRepository();
        $this->registry->register($repository);
        $this->registry->register($repository);
    }

    public function testFailedGetNotRegisteredRepository(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $repository = new FileRepository();
        $this->registry->register($repository);
        $this->registry->getRepository('test');
    }
}
