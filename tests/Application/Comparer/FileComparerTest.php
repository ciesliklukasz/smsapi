<?php

namespace Test\Application\Comparer;

use App\Application\Comparer\TextFileComparer;
use App\Core\Builder\FileBuilder;
use App\Core\Container\FileContainer;
use App\Core\Exception\CompareFileNotRegisteredException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

class FileComparerTest extends TestCase
{
    /** @var FileBuilder */
    private $builder;
    /** @var TextFileComparer */
    private $comparer;
    /** @var FileContainer */
    private $container;

    protected function setUp(): void
    {
        $this->builder = new FileBuilder();
        $dispatcher = $this->getMockBuilder(EventDispatcher::class)->disableOriginalConstructor()->getMock();
        $this->comparer = new TextFileComparer($dispatcher);
        $this->container = new FileContainer();
    }

    public function testCompareTheSameFiles(): void
    {
        $filePath1 = __DIR__ . '/../../../tmp/test_compare_1.txt';
        $fileHandle1 = fopen($filePath1, 'wb');
        fwrite($fileHandle1, 'test test test');
        fclose($fileHandle1);

        $this->container->addFile($this->builder->build($filePath1));
        $this->container->addFileToCompare($this->builder->build($filePath1));
        $this->comparer->compare($this->container);
        $diffContainer = $this->comparer->getDiffContainer();

        $all = $diffContainer->getAll();

        $this->assertEmpty($all[$filePath1]);

        unlink($filePath1);
    }

    public function testCompare(): void
    {
        $filePath1 = __DIR__ . '/../../../tmp/test_compare_1.txt';
        $fileHandle1 = fopen($filePath1, 'wb');
        fwrite($fileHandle1, 'test test test');
        fclose($fileHandle1);
        $filePath2 = __DIR__ . '/../../../tmp/test_compare_2.txt';
        $fileHandle2 = fopen($filePath2, 'wb');
        fwrite($fileHandle2, 'test test test1');
        fclose($fileHandle2);

        $this->container->addFile($this->builder->build($filePath1));
        $this->container->addFileToCompare($this->builder->build($filePath2));
        $this->comparer->compare($this->container);
        $diffContainer = $this->comparer->getDiffContainer();

        $all = $diffContainer->getAll();

        $this->assertNotEmpty($all);
        $this->assertCount(1, $all);

        unlink($filePath1);
        unlink($filePath2);
    }

    public function testCompareMultipleLineFiles(): void
    {
        $filePath1 = __DIR__ . '/../../../tmp/test_compare_1.txt';
        $fileHandle1 = fopen($filePath1, 'wb');
        fwrite($fileHandle1, 'test test test' . PHP_EOL . 'test1 test1 test1');
        fclose($fileHandle1);
        $filePath2 = __DIR__ . '/../../../tmp/test_compare_2.txt';
        $fileHandle2 = fopen($filePath2, 'wb');
        fwrite($fileHandle2, 'test test test1' . PHP_EOL . 'test1 test test1' . PHP_EOL . 'test1 test1 test1');
        fclose($fileHandle2);

        $this->container->addFile($this->builder->build($filePath1));
        $this->container->addFileToCompare($this->builder->build($filePath2));
        $this->comparer->compare($this->container);
        $diffContainer = $this->comparer->getDiffContainer();

        $all = $diffContainer->getAll();

        $this->assertNotEmpty($all);
        $this->assertCount(6, $all[$filePath2]);

        unlink($filePath1);
        unlink($filePath2);
    }

    public function testCompareMultipleFiles(): void
    {
        $filePath1 = __DIR__ . '/../../../tmp/test_compare_1.txt';
        $fileHandle1 = fopen($filePath1, 'wb');
        fwrite($fileHandle1, 'test test test');
        fclose($fileHandle1);
        $filePath2 = __DIR__ . '/../../../tmp/test_compare_2.txt';
        $fileHandle2 = fopen($filePath2, 'wb');
        fwrite($fileHandle2, 'test test1 test');
        fclose($fileHandle2);
        $filePath3 = __DIR__ . '/../../../tmp/test_compare_3.txt';
        $fileHandle3 = fopen($filePath3, 'wb');
        fwrite($fileHandle3, 'test test test1');
        fclose($fileHandle3);

        $this->container->addFile($this->builder->build($filePath1));
        $this->container->addFileToCompare($this->builder->build($filePath2));
        $this->container->addFileToCompare($this->builder->build($filePath3));
        $this->comparer->compare($this->container);
        $diffContainer = $this->comparer->getDiffContainer();

        $all = $diffContainer->getAll();

        $this->assertNotEmpty($all);
        $this->assertCount(2, $all);
        $this->assertCount(1, $all[$filePath2]);
        $this->assertCount(1, $all[$filePath3]);

        unlink($filePath1);
        unlink($filePath2);
        unlink($filePath3);
    }

    public function testFailedCompareWithoutMainFile(): void
    {
        $this->expectException(CompareFileNotRegisteredException::class);

        $filePath1 = __DIR__ . '/../../../tmp/test_compare_1.txt';
        $fileHandle1 = fopen($filePath1, 'wb');
        fwrite($fileHandle1, 'test test test');
        fclose($fileHandle1);

        $this->container->addFileToCompare($this->builder->build($filePath1));
        $this->comparer->compare($this->container);

        unlink($filePath1);
    }
}
