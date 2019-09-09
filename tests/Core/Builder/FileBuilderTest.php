<?php

namespace Test\Core;

use App\Core\Builder\FileBuilder;
use App\Core\Exception\ResourceNotExists;
use App\Core\Model\File;
use PHPUnit\Framework\TestCase;

class FileBuilderTest extends TestCase
{
    /** @var FileBuilder */
    private $builder;

    protected function setUp(): void
    {
        $this->builder = new FileBuilder();
    }

    public function testBuildFile(): void
    {
        $filePath = __DIR__ . '/../../../tmp/test_compare_1.txt';
        $fileHandle = fopen($filePath, 'wb');
        fwrite($fileHandle, 'test');
        fclose($fileHandle);

        $file = $this->builder->build($filePath);

        $this->assertInstanceOf(File::class, $file);
        $this->assertEquals('test_compare_1.txt', $file->getBaseName());
        $this->assertEquals('txt', $file->getExtension());
        $this->assertEquals('4', $file->getSize());
        $this->assertEquals('ASCII', $file->getEncoding());
        $this->assertEquals($filePath, $file->getFilePath());
        $this->assertEquals(['test'], $file->getContent());

        unlink($filePath);
    }

    public function testFailedBuildFile(): void
    {
        $this->expectException(ResourceNotExists::class);

        $filePath = __DIR__ . '/../../../tmp/test_compare_1.txt';
        $this->builder->build($filePath);
    }
}
