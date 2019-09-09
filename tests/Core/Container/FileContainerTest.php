<?php

namespace Test\Core\Container;

use App\Core\Container\FileContainer;
use App\Core\Exception\CannotOverwriteCompareFileException;
use App\Core\Model\File;
use PHPUnit\Framework\TestCase;

class FileContainerTest extends TestCase
{
    /** @var FileContainer */
    private $container;

    protected function setUp(): void
    {
        $this->container = new FileContainer();
    }

    public function testAddFiles(): void
    {
        $file1 = $this->getMockBuilder(File::class)->disableOriginalConstructor()->getMock();
        $file2 = $this->getMockBuilder(File::class)->disableOriginalConstructor()->getMock();

        $this->container->addFile($file1);
        $this->container->addFileToCompare($file2);

        $this->assertNotNull($this->container->getFile());
        $this->assertCount(1, $this->container->getFileToCompare());
    }

    public function testAddMultipleFilesToCompare(): void
    {
        $file1 = $this->getMockBuilder(File::class)->disableOriginalConstructor()->getMock();
        $file2 = $this->getMockBuilder(File::class)->disableOriginalConstructor()->getMock();
        $file2->method('getFilePath')->willReturn('test2.txt');
        $file3 = $this->getMockBuilder(File::class)->disableOriginalConstructor()->getMock();
        $file3->method('getFilePath')->willReturn('test3.txt');

        $this->container->addFile($file1);
        $this->container->addFileToCompare($file2);
        $this->container->addFileToCompare($file3);

        $this->assertNotNull($this->container->getFile());
        $this->assertCount(2, $this->container->getFileToCompare());
    }

    public function testAddOneFileTwiceToCompare(): void
    {
        $file1 = $this->getMockBuilder(File::class)->disableOriginalConstructor()->getMock();
        $file2 = $this->getMockBuilder(File::class)->disableOriginalConstructor()->getMock();
        $file2->method('getFilePath')->willReturn('test2.txt');

        $this->container->addFile($file1);
        $this->container->addFileToCompare($file2);
        $this->container->addFileToCompare($file2);

        $this->assertNotNull($this->container->getFile());
        $this->assertCount(1, $this->container->getFileToCompare());
    }

    public function testOverwriteFileFailed(): void
    {
        $this->expectException(CannotOverwriteCompareFileException::class);

        $file1 = $this->getMockBuilder(File::class)->disableOriginalConstructor()->getMock();
        $file2 = $this->getMockBuilder(File::class)->disableOriginalConstructor()->getMock();

        $this->container->addFile($file1);
        $this->container->addFile($file2);
    }
}
