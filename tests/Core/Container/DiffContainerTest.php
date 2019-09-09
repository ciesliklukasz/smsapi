<?php

namespace Test\Core\Container;

use App\Core\Container\DiffContainer;
use App\Core\Model\Diff;
use PHPUnit\Framework\TestCase;

class DiffContainerTest extends TestCase
{
    /** @var DiffContainer */
    private $container;

    protected function setUp(): void
    {
        $this->container = new DiffContainer();
    }

    public function testAddDiff(): void
    {
        $this->container->addDiff('test.txt', [
            new Diff(1, ['test' => 'test1'])
        ]);

        $this->assertCount(1, $this->container->getAll());
    }

    public function testAddDiffMultipleFiles(): void
    {
        $this->container->addDiff('test.txt', [
            new Diff(1, ['test' => 'test1'])
        ]);
        $this->container->addDiff('test1.txt', [
            new Diff(1, ['test' => 'test1'])
        ]);

        $this->assertCount(2, $this->container->getAll());
    }

    public function testOverWriteDiffsForFile(): void
    {
        $this->container->addDiff('test.txt', [
            new Diff(1, ['test' => 'test1'])
        ]);
        $this->container->addDiff('test.txt', [
            new Diff(1, ['test' => 'test1'])
        ]);

        $this->assertCount(1, $this->container->getAll());
    }
}
